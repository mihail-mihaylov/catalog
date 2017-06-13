<?php

/**
 * Description of TrackedObjectsController
 *
 * @author Nikolay Velchev <nvelchev@neterra.net>
 */

namespace App\Modules\TrackedObjects\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Http\Repositories\LanguageInterface as Language;
use App\Modules\Groups\Repositories\Eloquent\SlaveGroupRepository as Group;
use App\Modules\TrackedObjects\Http\Requests\CheckTrackedObjectIdentificationNumber as CheckTrackedObjectId;
use App\Modules\TrackedObjects\Http\Requests\CreateUpdateTrackedObjectRequest;
use App\Modules\TrackedObjects\Repositories\DeviceInterface as SlaveDevice;
use App\Modules\TrackedObjects\Repositories\SlaveTrackedObjectBrandInterface as SlaveTrackedObjectBrand;
use App\Modules\TrackedObjects\Repositories\TrackedObjectInterface as SlaveTrackedObject;
use App\Modules\TrackedObjects\Repositories\SlaveTrackedObjectTypeInterface as SlaveTrackedObjectType;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Traits\SwitchesDatabaseConnection;
use Auth;
use Input;
use Request;

class TrackedObjectsController extends Controller
{

    use SwitchesDatabaseConnection;

    public function __construct(Language $language, SlaveUserInterface $slaveUser, SlaveTrackedObjectBrand $slaveTrackedObjectBrand, SlaveTrackedObjectType $slaveTrackedObjectType, SlaveTrackedObject $slaveTrackedObject, SlaveDevice $slaveDevice, Group $groupRepository)
    {

        $this->middleware('auth');
        $this->slaveTrackedObjectBrand = $slaveTrackedObjectBrand;
        $this->slaveTrackedObjectType  = $slaveTrackedObjectType;
        $this->slaveTrackedObject      = $slaveTrackedObject;
        $this->language                = $language;
        $this->slaveUser               = $slaveUser;
        $this->slaveDevice             = $slaveDevice;
        $this->groups                  = $groupRepository;
        $this->company                 = $this->getManagedCompany();
    }

    public function index(Request $request)
    {

        $trackedObjects = collect([]);

        $devices = $this->slaveDevice->allWithDeleted(['deviceModel', 'trackedObject']);

        if (auth()->user()->administrates($this->company) ||
            auth()->user()->owns($this->company) ||
            \Gate::allows(getenv('ROLE_SUPER_USER'))) {

            $trackedObjects = $this->slaveTrackedObject->allWithDeleted(['brand']);
            $groups  = $this->groups->allWithDeleted(['withDeletedTrackedObjects', 'translation']);
            // dd($groups);
        } else {
            $user           = $this->slaveUser->find(auth()->user()->slave_user_id);
            $trackedObjects = $this->slaveTrackedObject->getTrackedObjectsBasedOnGroup($user);
            $groups = $user->groups();
            // $trackedObjectsIds = \DB::connection('slave')
            //     ->table('users')
            //     ->join('users_groups', 'users.id', '=', 'users_groups.user_id')
            //     ->join('groups_tracked_objects', 'groups_tracked_objects.group_id', '=', 'users_groups.group_id')
            //     ->join('tracked_objects', 'tracked_objects.id', '=', 'groups_tracked_objects.tracked_object_id')
            //     ->where('users.id', '=', auth()->user()->slave_user_id)
            //     ->get(['tracked_objects.id']);

            // // convert the php plain objects to a flat array
            // $trackedObjectsIds = json_decode(json_encode($trackedObjectsIds), true);
            // $trackedObjectsIds = collect($trackedObjectsIds)->flatten()->toArray();

            // // get eloquent entities
            // $trackedObjects = $this->slaveTrackedObject->with(['brand'])->find($trackedObjectsIds);
        }

        $languages      = $this->language->all();
        $company        = $this->company;

        return view('backend.trackedObjects.index', compact('groups', 'devices', 'trackedObjects', 'languages', 'company'));
    }

    public function edit($id)
    {
        $this->authorize('updateTrackedObject', $this->company);
        $objectGroups = $this->slaveTrackedObject->find($id)->groups->lists('id')->toArray();
        $groups = $this->groups->withTranslations()->get();
        $company = $this->company;
        $types = $this->slaveTrackedObjectType->with(['translation'])->get();
        $trackedObject = $this->slaveTrackedObject->findWithDeletes($id);
        $brands = $this->slaveTrackedObjectBrand->with(['translation'])->get();
        $trackedObjectBrand = $this->slaveTrackedObjectBrand->with(['models', 'translation'])->findOrFail($trackedObject->tracked_object_brand_id);

        $html = view('backend.trackedObjects.edit', compact('company', 'brands', 'types', 'trackedObject', 'trackedObjectBrand', 'groups', 'objectGroups'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function update(CreateUpdateTrackedObjectRequest $createUpdateTrackedObjectRequest, $id)
    {
        $this->authorize('updateTrackedObject', $this->company);

        # Update tracked object
        $trackedObject = $this->slaveTrackedObject->findWithDeletes($id);
        $trackedObject->update(Input::all());

        # Update tracked object groups
        if ($createUpdateTrackedObjectRequest->get('tracked_object_groups_ids')) {
            $trackedObject->groups()->sync($createUpdateTrackedObjectRequest->get('tracked_object_groups_ids'));
        } else {
            $trackedObject->groups()->detach();
        }

        $company = $this->company;

        # Get groups
        $groups  = $this->getTrackedObjectGroups();

        $html    = view('backend.trackedObjects.partials.row_tracked_object', compact('trackedObject', 'company'))->render();
        return AjaxController::success(['html' => $html, 'groups' => $groups]);
    }

    public function create()
    {
        $this->authorize('createTrackedObject', $this->company);

        $company = $this->company;
        $brands  = $this->slaveTrackedObjectBrand->with(['translation'])->get();
        $types   = $this->slaveTrackedObjectType->with(['translation'])->get();
        $groups = $this->groups->withTranslations()->get();

        $html = view('backend.trackedObjects.create', compact('company', 'brands', 'types', 'groups'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function store(CreateUpdateTrackedObjectRequest $createUpdateTrackedObjectRequest)
    {
        $this->authorize('createTrackedObject', $this->company);
        $data               = Input::all();
        $data['company_id'] = $this->company->slave_company_id;
        $trackedObject      = $this->slaveTrackedObject->create($data);
        $trackedObject->groups()->attach($data['tracked_object_groups_ids']);

        $company            = $this->company;

        # Update groups
        $groups  = $this->getTrackedObjectGroups();

        $html               = view('backend.trackedObjects.partials.row_tracked_object', compact('trackedObject', 'company'))->render();

        return AjaxController::success(['html' => $html, 'groups' => $groups]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deleteTrackedObject', $this->company);

        $trackedObject = $this->slaveTrackedObject->delete($id);

        $company       = $this->company;

        # Get groups
        $groups  = $this->getTrackedObjectGroups();

        $html = view('backend.trackedObjects.partials.row_tracked_object', compact('trackedObject', 'company'))->render();
        // dd($html);

        return AjaxController::success(['html' => $html, 'groups' => $groups]);
    }

    public function restore($id)
    {
        $this->authorize('deleteTrackedObject', $this->company);

        $trackedObject = $this->slaveTrackedObject->restore($id);

        $company       = $this->company;

        # Get groups
        $groups = $this->getTrackedObjectGroups();

        $html = view('backend.trackedObjects.partials.row_tracked_object', compact('trackedObject', 'company'))->render();

        return AjaxController::success(['html' => $html, 'groups' => $groups]);
    }

    public function checkTrackedObjectId(CheckTrackedObjectId $request)
    {
        return AjaxController::success(['html' => $request]);
    }

    public function getTrackedObjectGroups() {

        if(\Gate::allows(getenv('ROLE_OWNER'))) {
            $groups  = $this->groups->allWithDeleted([
                'trackedObjects',
                'translation'
            ]);
        } else {
            $groups  = $this->groups->with(['trackedObjects', 'translation']);
        }

        $htmlGroups = [];
        // dd($groups);
        foreach ($groups as $group) {
            # Get HTML spans for groups tracked objects column
            $htmlGroups[$group->id] = view('backend.trackedObjectsGroups.partials.list_group_tracked_objects')
                ->with([
                    'group' => $group
                ])
                ->render();
        }

        return $htmlGroups;
    }

}
