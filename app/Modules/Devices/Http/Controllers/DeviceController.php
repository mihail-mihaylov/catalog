<?php

namespace App\Modules\Devices\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\TrackedObjects\Http\Requests\UpdateDeviceRequest;
use App\Modules\TrackedObjects\Http\Requests\CreateDeviceRequest;
use App\Repositories\DeviceRepository;

use App\Repositories\GroupRepository;
use App\Http\Controllers\AjaxController as Ajax;
use DB;

//use Redirect;
//use Request;

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
        $deviceModels = $this->slaveDeviceModel->allWithDeleted();
        $trackedObjects = $this->slaveTrackedObject->with(['type', 'brand', 'model'])->get();
        $model = $this->slaveDevice->newObject();
        
        $html         = view('backend.devices.create', compact('deviceModels', 'trackedObjects', 'model'))->render();
        return AjaxController::success(['html' => $html]);
    }

    public function store(CreateDeviceRequest $request)
    {
        // there is ALWAYS only one company row in slave db
        // hence the '1'
        $data = [
            'device_model_id'       => Input::get('device_model_id'),
            'identification_number' => Input::get('identification_number'),
            'company_id'            => 1,
        ];

        if (Input::get('tracked_object_id')) {
            $data['tracked_object_id'] = Input::get('tracked_object_id');
        }

        $data['digital_inputs'] = $request->digital_inputs;
        $data['analog_inputs'] = $request->analog_inputs;

        $device = $this->slaveDevice->create($data);

        $this->slaveDevice->createTranslations($request->translations, 'device_id', $device);
        
        $company = $this->company;

        $html = view('backend.devices.partials.row_device', compact('device', 'company'))->render();
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

    public function updateDeviceInputs(CreateUpdateDeviceInputRequest $request)
    {
        $input = $request->input('input_id');
        $device = $request->route('device');
        if (isset($input)) {
            $selectedInput = $this->deviceInput->find($input); 
            $selectedInput->update($request->input('devices_inputs')[0]);
            $this->deviceInput->updateTranslations($request->translations, 'device_input_id', $selectedInput);
        } else {
            $data = $request->input('devices_inputs')[0];
            $data['device_id'] = $device;
            $selectedInput = $this->deviceInput->create($data);
            $this->deviceInput->createTranslations($request->translations, 'device_input_id', $selectedInput);
        }

        return Ajax::success([
            'html' => view('backend.devices.partials.inputs_list')->with([
                'inputs' => $this->slaveDevice->find($device)->allInputs,
                'device' => $selectedInput->device,
            ])->render()
        ]);
    }

}
