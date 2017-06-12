<?php

/**
 * Description of SlaveDeviceObserver
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Observers;

use App\Modules\TrackedObjects\Repositories\MasterDeviceInterface;
use App\Modules\TrackedObjects\Repositories\DeviceInterface;
use Event;

class SlaveDeviceObserver
{

    public function __construct(MasterDeviceInterface $masterDevice, DeviceInterface $slaveDevice)
    {
        $this->masterDevice = $masterDevice;
        $this->slaveDevice = $slaveDevice;
    }

    public function created($model)
    {
        $attributes = $model->getAttributes();
        $attributes['company_id'] = $model->company->master_company_id;
        unset($attributes['tracked_object_id']);
        $masterDevice = $this->masterDevice->create($attributes);
        $masterDevice->slave_device_id = $model->id;
        $masterDevice->save();
        $model->master_device_id = $masterDevice->id;
        $model->save();
        Event::fire('device.created');
    }

    public function updated($model)
    {
        Event::fire('device.updated');
        
        $attributes = $model->getAttributes();
        $attributes['slave_device_id'] = $model->id;
        unset($attributes['master_device_id']);
        unset($attributes['tracked_object_id']);
        return $masterDevice = $this->masterDevice->update($model->master_device_id, $attributes);
    }

    public function deleted($model)
    {
        Event::fire('device.deleted');

        $device = $this->masterDevice->findWithDeletes($model->master_device_id);
        return $device->delete($model->master_device_id);
    }

    public function restored($model)
    {
        return;
//        Event::fire('device.deleted');
//
//        $device = $this->masterDevice->findWithDeletes($model->master_device_id);
//        return $device->restore($model->master_device_id);
    }

}
