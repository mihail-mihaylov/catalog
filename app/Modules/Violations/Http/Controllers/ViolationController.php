<?php

namespace App\Modules\Violations\Http\Controllers;

use App\Http\Controllers\AjaxController as Ajax;
use App\Http\Controllers\Controller;
use App\Modules\Violations\Interfaces\ViolationInterface;
use App\Modules\Violations\Models\UserViolationNotification;
use App\Modules\Restrictions\Interfaces\RestrictionInterface;
use App\Modules\Violations\Interfaces\UserViolationNotificationInterface;
use App\Models\MasterCompany;
use App\Traits\SwitchesDatabaseConnection;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    use SwitchesDatabaseConnection;

    public function __construct(ViolationInterface $violations, RestrictionInterface $restrictionRepository, UserViolationNotificationInterface $userViolationNotification, MasterCompany $company)
    {
        $this->authorize('user');
        $this->violations   = $violations;
        $this->restrictions = $restrictionRepository;
        $this->userViolationNotification = $userViolationNotification;
        $this->company = $company;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('restrictions#violations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $violation = $this->violations->findOrFail($id);
        } catch (\Exception $e) {
            return Ajax::fail(false);
        }

        $violationData = $this->violations->getViolationData($violation);

        $html = view('backend.violations.partials.show')->with(
            [
                'violation'     => $violation->id,
                'violationData' => $violationData,
            ])->render();
        // dd($html);
        return Ajax::success(['html' => $html]);
    }

    public function destroyAll()
    {
        $this->violations->destroyAll();
        return Ajax::success();
    }

    public function getNotifications()
    {
        // notifications variable served via namespace App\Http\ViewComposers\ViolationNotification;
        return Ajax::success(['html' => view('backend.violations.partials.notifications')->render()]);
    }


    /**
     * Mark violations as seen
     *
     */
    public function clearViolations()
    {
        UserViolationNotification::where('user_id', Auth::user()->id)
                                    ->where('seen', 0)
                                    ->update(['seen' => 1]);

        return Ajax::success();
    }

    public function getViolation($id)
    {
        try {
            $violation = $this->violations->findOrFail($id);
        } catch (\Exception $e) {
            return Ajax::fail(false);
        }

        $violationData = $this->violations->getViolationData($violation);

        return Ajax::success(['violationData' => $violationData]);
    }

    public function getViolationsByRestriction($restriction_id)
    {
        $violations = $this->violations->getViolationsByRestriction($restriction_id);

        // dd($violations->toJson(), 5);
        return Ajax::success(['violations' => $violations->toJson()]);
    }
}
