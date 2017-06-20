<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Http\Repositories\SlaveGpsEventInterface;
use App\Modules\Reports\Repositories\Eloquent\TripRepository;
use App\Modules\SharedTasks\Repositories\Eloquent\SlaveSharedTaskRepository;
use App\Repositories\DeviceRepository;
use App\Modules\TrackedObjects\Repositories\Eloquent\TrackedObjectRepository;
use App\Modules\TrackedObjects\Repositories\SlaveGroupsTrackedObjectsInterface;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Modules\Pois\Repositories\Eloquent\PoiRepository;
use Carbon\Carbon;
use App\PoiHistory;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Http\Request;
use View;
use Gate;
use DB;
use Session;

class DashboardController extends Controller
{
    protected $deviceRepository;
    protected $slavePoiRepository;

    public function __construct(
        DeviceRepository $deviceRepository
    ) {
//        $this->slaveGpsEventRepository             = $slaveGpsEventRepository;
        $this->deviceRepository               = $deviceRepository;
//        $this->slaveTripRepository                 = $slaveTripRepository;
//        $this->slaveSharedTask                     = $slaveSharedTask;
//        $this->company                             = $this->getManagedCompany();
//        $this->slaveUser                           = $slaveUser;
//        $this->slaveGroupsTrackedObjectsRepository = $slaveGroupsTrackedObjectsRepository;
//        $this->slavePoiRepository = $slavePoiRepository;
    }

    public function index(Request $request)
    {
        $devicesLastData = $this->deviceRepository->getAllWithLastData()->get();
//        dd($devicesLastData->first()->name);

        // Get last visited pois
        // $lastVisited = $this->slavePoiRepository->getLastVisited();

        return View::make('backend.dashboard.index')->with(compact('devicesLastData'));
    }

    public function getDevicesLastData(Request $request)
    {
        $devicesLastData = $this->deviceRepository->getAllWithLastData()->get();

        return AjaxController::success(['devicesLastData' => $devicesLastData]);
    }


}
