<?php

/**
 * Description of GeneralReportController
 *
 * @author Mihail Mihaylov <mmihaylov@neterra.net>
 */

namespace App\Modules\Reports\Http\Controllers;

use App\DriverI18n;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AjaxController;
use App\Models\GpsEvent;
use App\Modules\Pois\Repositories\Eloquent\PoiRepository;
use App\Modules\Reports\Http\Requests\GeneralReportRequest;
use App\Modules\TrackedObjects\Repositories\Eloquent\DeviceRepository;
//use App\Modules\Users\Repositories\SlaveUserInterface;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DBNetfleet;
use Validator;
use View;
use Gate;
use Illuminate\Http\Request;

class GeneralReportController extends Controller
{
    public function __construct(DeviceRepository $deviceRepository) {
        $this->deviceRepository             = $deviceRepository;
    }

    public function index()
    {
        $devices = $this->deviceRepository->getAll();

        return View::make('backend.reports.general.create')->with(compact('devices'));
    }

    public function report(GeneralReportRequest $request)
    {
        $deviceId       = $request->deviceId;
        $startDate      = $lastDate = $request->hiddenLastDate;
        $periodInput    = $request->periodInput; //days

        $from           = new Carbon($startDate);
        $from           = $from->subDays($periodInput)->tz(config('app.timezone'))->toDateTimeString();
        $to             = Carbon::parse($lastDate)->toDateTimeString();

        $events = GpsEvent::where("gps_utc_time", ">=", $from)
            ->where("gps_utc_time", '<=', $to)
            ->where('device_id', $deviceId)
            ->orderBy("gps_utc_time")
            ->get();
        $events = GpsEvent::all();

        $device         = $this->deviceRepository->getDeviceInfo($deviceId);

        return View::make('backend.reports.general.index')->with(compact('device', 'events', 'from', 'to'));
    }

    public function getTrips(GetDailyTripInfoRequest $request, $date, $deviceId)
    {
        /**
         *
         * We should simply refactor this
         * method to use POST instead of GET
         *
         */
//        $date = $request->all()[3];
//
//        $start = clone $end = new Carbon($date);
//
//        $start = $start->subDays(self::DAILY_TRIP_REPORT_INTERVAL_IN_DAYS);
//
//        $trips = $this->slaveTripRepository->getTripsForGeneralReport($deviceId, $start->toDateTimeString(), $end->toDateTimeString());
//
//        return AjaxController::success(['trips' => $trips]);
    }

    public function getLastEvent($deviceId)
    {
//        $lastEvent = $this->gpsEventRepository->getLastGpsEvent($deviceId);

//        return AjaxController::success(['lastEvent' => $lastEvent]);
    }

    public function getPopup()
    {
        $html = view('backend.reports.general.partials.popup');

        return AjaxController::success(['html' => $html]);
    }

}
