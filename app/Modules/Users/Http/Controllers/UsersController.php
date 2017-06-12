<?php

namespace App\Modules\Users\Http\Controllers;

use App\Modules\Groups\Repositories\Eloquent\SlaveGroupRepository as SlaveGroup;
use App\Modules\Users\Repositories\Eloquent\SlaveUserI18nRepository;
use App\Modules\Users\Http\Requests\RestoreUserRequest;
use App\Modules\Users\Http\Requests\CreateUserRequest;
use App\Modules\Users\Http\Requests\UpdateUserRequest;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Modules\Users\Http\Requests\DeleteUserRequest;
use App\Traits\SwitchesDatabaseConnection;
use App\Http\Controllers\AjaxController;
use App\Http\Repositories\RoleInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Role;
use App\User;
use DB;

class UsersController extends Controller
{
    use SwitchesDatabaseConnection;

    public function __construct(SlaveUserInterface $slaveUser, Request $request, SlaveGroup $slaveGroup, RoleInterface $role, SlaveUserI18nRepository $translation)
    {
        $this->authorize('user');

        $this->slaveUser   = $slaveUser;
        $this->slaveGroup  = $slaveGroup;
        $this->roles       = $role;
        $this->company     = $this->getManagedCompany();
        // dd(auth()->user()->administrates($this->company), auth()->user()->can('update_company_users'));
        $this->translation = $translation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = $this->company;
        $groups  = $this->slaveGroup->allWithDeleted(['translation', 'usersWithTranslations']);
        $users   = $this->slaveUser->allWithDeleted(['role', 'company', 'translation']);
        return view('backend.users.index', compact('company', 'groups', 'dropdownCompanies', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('createUser', $this->company);

        $roles  = $this->roles->all();
        $user   = $this->slaveUser->auth();
        $groups = $this->slaveGroup->with(['translation'])->get();

        $template = view('backend.users.partials.create')->with(
            [
                'roles'   => $roles,
                'user'    => $user,
                'company' => $this->company,
                'groups'  => $groups,
                'model'   => $this->slaveUser->newObject(),
            ]
        )->render();

        return AjaxController::success(['html' => $template]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $role            = Role::find($request->input('role_id'));
        $translationData = $request->translations;
        $attributes = $request->input();
        // there is ALWAYS only one company row in slave db
        // hence the '1'
        $attributes['company_id'] = 1;
        $attributes['password']   = bcrypt($attributes['password']);

        $user = $this->slaveUser->create($attributes);

        if (null != $request->input('groups')) {
            $user->groups()->sync($request->groups);
        }

        $this->slaveUser->createTranslations($translationData, 'user_id', $user);

        return $this->getUserRow($user, $this->company);
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
        $user = $this->slaveUser->findWithDeletes($id, ['company', 'groups']);

        $roles = $this->roles->all();

        $template = view('backend.users.partials.edit')->with(
            [
                'user'           => $user,
                'model'          => $user,
                'roles'          => $roles->all(),
                'managedCompany' => $this->company,
            ]
        )->render();

        return AjaxController::success(['html' => $template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $role = Role::find($request->input('role_id'));

        $userInput             = $request->input();

        unset($userInput['translations']);

        if (null === $request->input('groups')) {
            $userInput['groups'] = [];
        }

        if (isset($userInput['password'])) {
            $userInput['password'] = bcrypt($userInput['password']);
        }

        # Update user
        $user = $this->slaveUser->update($request->route('user'), $userInput);
        $this->slaveUser->updateTranslations($request->translations, 'user_id', $user);

        # Update user groups
        if ($request->get('groups')) {
            $user->groups()->sync($request->get('groups'));
        } else {
            $user->groups()->detach();
        }

        return $this->getUserRow($user, $this->company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        $this->authorize('deleteUser', $this->company);

        $user = $this->slaveUser->find($id);

        if (auth()->user()->can('deleteHimself', $user)) {
            $user = $this->slaveUser->delete($id);
        }

        return $this->getUserRow($user, $this->company);
    }

    public function restore($id, RestoreUserRequest $request)
    {
        $this->authorize('deleteUser', $this->company);
        $user = $this->slaveUser->restore($id);

        return $this->getUserRow($user, $this->company);
    }

    private function getUserRow(User $user, Company $company)
    {
        $html = view('backend.users.partials.users.users_list_row')->with(
            [
                'company' => $company,
                'user'    => $user,
            ]
        )->render();

        # Update groups
        $groups  = $this->slaveGroup->allWithDeleted(['translation', 'usersWithTranslations']);
        $htmlGroups = [];
        foreach ($groups as $group) {
            # Get HTML spans for groups users column
            $htmlGroups[$group->id] = view('backend.users.partials.groups.list_group_users')
                ->with([
                    'group' => $group
                ])
                ->render();
        }

        return AjaxController::success(['html' => $html, 'groups' => $htmlGroups]);
    }
}
