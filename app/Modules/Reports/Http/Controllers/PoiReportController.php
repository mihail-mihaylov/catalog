<?php

namespace App\Modules\Reports\Http\Controllers;

use App\Models\PoiHistory;
use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Reports\Http\Requests\PoiReportRequest;
use App\Modules\TrackedObjects\Repositories\TrackedObjectInterface as TrackedObjects;
use App\Repositories\PoiRepository;
use Carbon\Carbon;
use View;

class PoiReportController extends Controller
{
    public function __construct(
        DeviceRepository $deviceRepository,
        PoiRepository $poiRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->poiRepository = $poiRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pois = $this->poiRepository->getAllPois();
        $devices = $this->deviceRepository->getAll();

        return View::make('backend.reports.poi.create')->with(compact('devices', 'pois'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PoiReportRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(PoiReportRequest $request)
    {
        $to = $from = $request->hiddenLastDate;
        
        $from = Carbon::parse($from)->subDays($request->periodInput);
        $to   = Carbon::parse($to)->toDateTimeString();

        $poiHistory = PoiHistory::where('poi_id', $request->poi)
            ->whereDate('start_time', '>=', $from)
            ->whereDate('start_time', '<=', $to)
            ->with('device', 'poi')
            ->orderBy('start_time')
            ->get();

        $poi = $this->poiRepository->getPoi($request->poi)->get();

        return View::make('backend.reports.poi.index')->with(compact('poiHistory', 'from', 'to', 'poi'));
    }
}
