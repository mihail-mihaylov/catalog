<?php

namespace App\Modules\Dashboard\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class DashboardSidebarComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {

        // Dependencies automatically resolved by service container...
        // $this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function generate(View $view)
    {
        $companyModules = auth()->user()->company->modules;
        $rolesModules = auth()->user()->role->modules;

        $modules = $companyModules->intersect($rolesModules);

        $view->with('modules', $modules);
    }
}
