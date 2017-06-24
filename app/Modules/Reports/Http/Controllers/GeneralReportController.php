<?php

namespace App\Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AjaxController;
use App\Models\Device;
use App\Models\GpsEvent;
use App\Modules\Pois\Repositories\Eloquent\PoiRepository;
use App\Modules\Reports\Http\Requests\GeneralReportRequest;
use App\Repositories\DeviceRepository;
//use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Repositories\GpsEventRepository;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use View;
use Illuminate\Http\Request;

class GeneralReportController extends Controller
{
    private $deviceRepository;
    private $gpsEventRepository;

    public function __construct(DeviceRepository $deviceRepository, GpsEventRepository $gpsEventRepository) {
        $this->deviceRepository = $deviceRepository;
        $this->gpsEventRepository = $gpsEventRepository;
    }

    public function index()
    {
        $devices = $this->deviceRepository->getAll();

        return View::make('backend.reports.general.create')->with(compact('devices'));
    }

    public function report(GeneralReportRequest $request)
    {
        $deviceId = $request->deviceId;
        $from = $request->from;
        $to = $request->to;

        $events = [];
        $this->gpsEventRepository->getGpsEventsFromTo($deviceId, $from, $to)
            ->map(function ($gpsEvent) use (&$events) {
                $events[Carbon::parse($gpsEvent->gps_utc_time)->toDateString()][] = $gpsEvent->toArray() ;
            });
        $device = $this->deviceRepository->getDeviceInfo($deviceId);


        return View::make('backend.reports.general.index')->with(compact('device', 'events', 'from', 'to'));
    }

    public function show()
    {
        dd('show');
    }

    public function getLastEvent($deviceId)
    {
        $lastEvent = Device::find($deviceId)->lastGpsEvent()->first();

        return AjaxController::success(['lastEvent' => $lastEvent]);
    }

    public function getTrips(Request $request, $date, $deviceId)
    {
        $events = $this->gpsEventRepository->getGpsEventsFrom($deviceId, $date);

        return AjaxController::success(['events' => $events]);
    }

    public function getPopup()
    {
        $html = view('backend.reports.general.partials.popup');

        return AjaxController::success(['html' => $html]);
    }

}
