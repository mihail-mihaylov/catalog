<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Modules\Groups\Repositories\Eloquent\SlaveGroupRepository as Group;
use App\Modules\Groups\Requests\CreateGroupRequest;
use App\Modules\Groups\Requests\UpdateGroupRequest;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;
use Session;

class GroupsController extends Controller
{
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groups  = $groupRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('manageGroup', $this->company);
        // $languages = Session::get('company_languages');
        $template  = view('backend.users.partials.create_group')->with([
            // 'languages' => $languages,
            'model'     => $this->groups->newObject()
        ])->render();

        return AjaxController::success(['html' => $template]);
    }
    public function getEditGroup($id)
    {
        $this->authorize('manageGroup', $this->company);
        $group    = $this->groups->findWithDeletes($id);
        $template = view('backend.users.partials.edit_group')->with([
            'group' => $group,
            'model' => $group,
        ])->render();
        return AjaxController::success(['html' => $template]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        $this->authorize('manageGroup', $this->company);
        $attributes = [
            // there is ALWAYS only one company row in slave db
            'company_id' => 1,
        ];

        $newGroup = $this->groups->create($attributes);

        $this->groups->createTranslations($request->translations, 'group_id', $newGroup);

        return $this->getGroupRow($newGroup->id);
//        return AjaxController::success(['id' => $newGroup->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $this->authorize('manageGroup', $this->company);
        $group = $this->groups->find($id);
        $this->groups->updateTranslations($request->translations, 'group_id', $group);

        return $this->getGroupRow($id);
//        return AjaxController::success(['message' => true]);
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
        $this->groups->delete($id);

        return $this->getGroupRow($id);
//        return AjaxController::success(['message' => true]);
    }

    public function restore($id)
    {
        $this->authorize('deleteGroup', $this->company);
        $this->groups->restore($id);

        return $this->getGroupRow($id);
//        return AjaxController::success(['message' => true]);
    }

    public function getGroupRow($id)
    {
        $group = $this->groups->findWithDeletes($id, ['translations']);

        $this->authorize('manageGroup', $this->company);

        $company = $this->company;

        $html = view('backend.users.partials.groups.list_row', compact("group", "company"))->render();

        return AjaxController::success(['html' => $html]);
    }
}
