<?php

namespace App\Modules\TrackedObjects\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Http\Repositories\LanguageInterface as Language;
use App\Modules\Groups\Repositories\GroupInterface as SlaveGroup;
use App\Modules\TrackedObjects\Http\Requests\CreateTrackedObjectGroupRequest;
use App\Modules\TrackedObjects\Http\Requests\UpdateTrackedObjectGroupRequest;
use App\Modules\TrackedObjects\Http\Requests\UpdateTrackedObjectGroups;
use App\Modules\TrackedObjects\Repositories\TrackedObjectInterface as SlaveTrackedObject;
use App\Modules\Users\Repositories\SlaveUserInterface as SlaveUser;
use App\Traits\SwitchesDatabaseConnection;
use Illuminate\Http\Request;
use Input;
use DB;

class TrackedObjectsGroupsController extends Controller
{

    use SwitchesDatabaseConnection;

    public function __construct(SlaveGroup $group, SlaveUser $slaveUser, Language $language, SlaveTrackedObject $slaveTrackedObject)
    {
        $this->middleware('auth');
        $this->authorize('user');

        $this->slaveTrackedObject = $slaveTrackedObject;
        $this->language = $language;
        $this->group = $group;
        $this->slaveUser = $slaveUser;
        $this->company = $this->getManagedCompany();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->group->allWithDeleted();
        $languages = \Session::get('company_languages');
        // $languages      = $this->language->all();
        $trackedObjects = $this->slaveTrackedObject->allWithDeleted();
        $company = $this->company;
        return view('backend.trackedObjectsGroups.index', compact('groups', 'languages', 'trackedObjects', 'company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('createGroup', $this->company);

        // $languages = $this->language->all();
        $model = $this->group->newObject();
        $html = view('backend.trackedObjectsGroups.partials.create', compact('model'))->render();

        return AjaxController::success(['html' => $html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTrackedObjectGroupRequest $request)
    {
        $this->authorize('createGroup', $this->company);

        $group = $this->group->create([
            'company_id' => $this->company->slave_company_id,
        ]);

        try {
            DB::beginTransaction();
            $this->group->createTranslations($request->translations, 'group_id', $group);
        } catch (Exception $e) {
            DB::rollBack();
            return AjaxController::fail(['html' => $e]);
        } finally {
            DB::commit();
            $company = $this->company;

            $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();
            return AjaxController::success(['html' => $html]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('readGroup', $this->company);

        $group = $this->group->findOrFail($groupId)->toJson();
        return AjaxController::success(['data' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('updateGroup', $this->company);

        $model = $group = $this->group->with(['translations'])->findOrFail($id);
        $languages = \Session::get('company_languages');
        // $languages = $this->language->all();

        $html = view('backend.trackedObjectsGroups.partials.edit', compact('languages', 'group', 'model'))->render();
        return AjaxController::success(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrackedObjectGroupRequest $request, $id)
    {
        $this->authorize('updateGroup', $this->company);

        $group = $this->group->with(['translations'])->findOrFail($id);

        $this->group->updateTranslations($request->translations, 'group_id', $group);

        $company = $this->company;
        $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();
        // dd($html);

        return AjaxController::success(['html' => $html]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deleteGroup', $this->company);

        $group = $this->group->with(['trackedObjects'])->findOrFail($id);
        //check smth
        $group->delete($id);

        $company = $this->company;
        $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();

        return AjaxController::success(['html' => $html]);
    }

    // RestoreUserRequest $request
    public function restore($id)
    {
        $this->authorize('deleteGroup', $this->company);

        $this->group->restore($id);
        $group = $this->group->findWithDeletes($id);
        $company = $this->company;
        $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();

        return AjaxController::success(['html' => $html]);
    }

    /*
     *
     */

    public function updateTrackedObjectsGroups(UpdateTrackedObjectGroups $request, $trackedObjectId)
    {
        $trackedObject = $this->slaveTrackedObject->findOrFail($trackedObjectId);

        if ($request->groups) {
            $trackedObject->groups()->sync($request->groups);
        } else {
            $trackedObject->groups()->detach();
        }

        # Update groups
        $groups =  $this->group->allWithDeleted(['trackedObjects', 'translation']);
        $htmlGroups = [];
        foreach ($groups as $group) {
            # Get HTML spans for groups tracked objects column
            $htmlGroups[$group->id] = view('backend.trackedObjectsGroups.partials.list_group_tracked_objects')
                ->with([
                    'group' => $group
                ])
                ->render();
        }

        return AjaxController::success(['groups' => $htmlGroups]);
    }

    /* Get tracked objects groups
     *
     * @method GET
     * @return
     */

    public function getTrackedObjectsGroups($trackedObjectId)
    {

        $this->authorize('readGroup', $this->company);

        $objectGroups = $this->slaveTrackedObject->find($trackedObjectId)->groups->lists('id')->toArray();
        $groups = $this->group->withTranslations()->get();
        $company = $this->company;
        $html = view('backend.trackedObjectsGroups.partials.list_tracked_object_groups', compact('objectGroups', 'groups', 'trackedObjectId', 'company'))->render();
        return AjaxController::success(['html' => $html]);
    }

    /*
     * Add tracked object to group
     *
     * @method POST
     * @return
     */

    public function removeTrackedObjectFromGroup($trackedObjectId, $groupId)
    {
        $this->authorize('deleteGroup', $this->company);
        $group = $this->group->findOrFail($groupId);
        $trackedOBject = $this->slaveTrackedObject->find($trackedObjectId);
        $group->trackedObjects()->detach($trackedOBject->id);
        $company = $this->company;
        $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();

        return AjaxController::success(['html' => $html]);
    }

    /*
     * Add tracked object to group
     *
     * @method POST
     * @return
     */

    // public function reloadGroupTrackedObjects($groupId)
    // {
    //     $this->authorize('readGroup', $this->company);
    //     $group   = $this->slaveUser->auth()->company->groups()->findOrFail($groupId);
    //     $company = $this->company;
    //     $html = view('backend.trackedObjectsGroups.partials.list_group_tracked_objects', compact('group', 'company'))->render();
    //     return AjaxController::success(['html' => $html]);
    // }

    /**
     * Get tracked objects
     *
     * @param $groupId
     * @return mixed
     */
    public function getTrackedObjects($groupId)
    {
        $this->authorize('readTrackedObject', $this->company);

        $trackedObjects = $this->slaveTrackedObject->withBrand()->get();

        $trackedObjectsInGroup = $this->slaveTrackedObject->with(['groups'])->whereHas('groups', function($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->get()->lists('id')->toArray();

        $company = $this->company;

        $html = view('backend.trackedObjects.partials.list_tracked_objects', compact('groupId', 'trackedObjects', 'trackedObjectsInGroup', 'company'))->render();

        return AjaxController::success(['html' => $html]);
    }

    /**
     * Add/Remove tracked objects from group
     *
     * @param Request $request
     * @param $groupId
     * @return mixed
     */
    public function syncTrackedObjectsWithGroup(Request $request, $groupId)
    {
        $group = $this->group->findOrFail($groupId);

        if ($request->get('trackedObjects')) {
            $group->trackedObjects()->sync($request->get('trackedObjects'));
        } else {
            $group->trackedObjects()->detach();
        }

        $company = $this->company;

        $html = view('backend.trackedObjectsGroups.partials.row_group', compact('group', 'company'))->render();

        return AjaxController::success(['html' => $html]);
    }
}
