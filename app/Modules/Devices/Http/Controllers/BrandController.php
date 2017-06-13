<?php

/**
 * Description of BrandController
 *
 * @author nvelchev
 */

namespace App\Modules\TrackedObjects\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Models\SlaveTrackedObjectModel;
use App\Traits\SwitchesDatabaseConnection;

class BrandController extends Controller
{

    use SwitchesDatabaseConnection;
    
    public function __construct(SlaveTrackedObjectModel $slaveTrackedObjectModel)
    {
        $this->authorize('user');
        
        $this->toggleSlaveConnection();
        $this->slaveTrackedObjectModel = $slaveTrackedObjectModel;
    }

    public function getBrandModels($brandId)
    {
        $models = $this->slaveTrackedObjectModel->with(['translation'])->where('tracked_object_brand_id', $brandId)->get();

        $html = view('backend.trackedObjects.partials.select_models_dropdown', compact('models'))->render();

        return AjaxController::success(['html' => $html]);
    }

}
