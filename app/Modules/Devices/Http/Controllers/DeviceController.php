<?php

namespace App\Modules\Devices\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Modules\TrackedObjects\Http\Requests\UpdateDeviceRequest;
use App\Modules\TrackedObjects\Http\Requests\CreateDeviceRequest;
use App\Repositories\DeviceRepository;

use App\Repositories\GroupRepository;
use DB;

class DeviceController extends Controller
{
    private $deviceRepository;
    private $groupRepository;

    public function __construct(
        DeviceRepository $deviceRepository,
        GroupRepository $groupRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = $this->deviceRepository->allWithDeleted();
        $groups = $this->groupRepository->allWithDeleted();

        return view('backend.devices.index', compact('groups', 'devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = $this->groupRepository->all();
        $html = view('backend.devices.create', compact(['groups']))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function store(CreateDeviceRequest $request)
    {
        $device = Device::create([
            'name' => '{"'.env().'"}'
        ]);

        $this->slaveDevice->createTranslations($request->translations, 'device_id', $device);
        
        $html = view('backend.devices.partials.row_device', compact('device'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $model = $device         = $this->slaveDevice->findWithDeletes($id, ['deviceModel', 'trackedObject']);
        $deviceModels   = $this->slaveDeviceModel->allWithDeleted();
        $trackedObjects = $this->slaveTrackedObject->with(['type', 'brand', 'model'])->get();
        $html           = view('backend.devices.partials.edit', compact('device', 'deviceModels', 'trackedObjects', 'model'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function update(UpdateDeviceRequest $request, $id)
    {
        $device = $this->slaveDevice->findWithDeletes($id);
        $device->update($request->input());

        $device->load(['deviceModel', 'trackedObject']);
        $company = $this->company;
        
        $html = view('backend.devices.partials.row_device', compact('device', 'company'))->render();

        $this->slaveDevice->updateTranslations($request->translations, 'device_id', $device);

        return AjaxController::success(['html' => $html]);
    }

    public function destroy($id)
    {
        dd('dotuk');
        $device = $this->slaveDevice->findWithDeletes($id);

        $device->delete($id);
        $company = $this->company;

        $html = view('backend.devices.partials.row_device', compact('device', 'company'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function restore($id)
    {
        $this->slaveDevice->restore($id);
        $device = $this->slaveDevice->findWithDeletes($id, ['deviceModel', 'trackedObject']);
        $company = $this->company;

        $html   = view('backend.devices.partials.row_device', compact('device', 'company'))->render();
        return AjaxController::success(['html' => $html]);
    }

}
