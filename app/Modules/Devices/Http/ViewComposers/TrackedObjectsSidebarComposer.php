<?php

namespace App\Modules\TrackedObjects\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class TrackedObjectsSidebarComposer
{
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