<?php
namespace App\Modules\Restrictions\Repositories;

use App\Modules\Restrictions\Interfaces\RestrictionInterface;
use App\Modules\Restrictions\Models\Area;
use App\Modules\Restrictions\Models\AreaPoint;
use App\Modules\Restrictions\Models\Limit;
use App\Modules\Users\Repositories\Eloquent\EloquentRepository;
use Illuminate\Http\Request;

class RestrictionRepository extends EloquentRepository
{

    public function __construct(
        Limit $model,
        Area $area,
        AreaPoint $areaPoint,
        Device $device
    ) {
        $this->model         = $model;
        $this->area          = $area;
        $this->areaPoint     = $areaPoint;
        $this->device = $device;
    }

    public function getArea()
    {
        return $this->model->area;
    }

    public function updateRestriction(Limit $restriction, $input)
    {
        $restriction = $this->updateRestrictionArea($restriction, $input);
        $restriction = $this->updateRestrictionAreaPoints($restriction, $input);
        $restriction = $this->updateRestrictionSpeed($restriction, $input);
        $restriction = $this->updateRestrictionTrackedObjects($restriction, $input);

        $restriction->save();
        $this->saveTranslations($restriction, $input);

        return $restriction;
    }

    private function updateRestrictionArea($restriction, $input)
    {
        $mustCreateArea = $restriction->areaField->isEmpty() && isset($input['area_point']);
        $mustDeleteArea = isset($input['delete_area']);
        if ($mustDeleteArea) {
            $restriction->area()->dissociate();
            $restriction->save();
            return $restriction;
        }

        if ($mustCreateArea) {

            $area = $this->area->create([
                'area_type' => $input['area_type'],
                'radius'    => isset($input['radius']) ? $input['radius'] : 0,
            ]);

            $restriction->area()->associate($area);
            $this->saveAreaTranslations($restriction, $input);

        } else {

            if (isset($input['area_type'])) {
                $restriction->area->area_type = $input['area_type'];
                $restriction->area->radius    = isset($input['radius']) ? $input['radius'] : 0;
                $restriction->area->save();
                $this->saveAreaTranslations($restriction, $input);
            }

        }

        $restriction->save();
        return $restriction;
    }

    private function updateRestrictionAreaPoints(Limit $restriction, array $input)
    {
        // dd($restriction->area);
        if (isset($restriction->area)) {
            $restriction->area->areaPoints()->delete();

            foreach ($input['area_point'] as $areaPoint) {
                $point = $this->areaPoint->create([
                    'area_id'   => $restriction->area_id,
                    'latitude'  => $areaPoint['lat'],
                    'longitude' => $areaPoint['lng'],
                ]);
            }
        }

        $restriction->save();
        return $restriction;
    }

    private function updateRestrictionTrackedObjects(Limit $restriction, array $input)
    {
        // var_dump($input['trackedObjectLimits']);
        if (!isset($input['trackedObjectLimits'])) {
            $input['trackedObjectLimits'] = $this->trackedObject->all()->lists('id')->toArray();
        }

        $restriction->trackedObjects()->sync($input['trackedObjectLimits']);

        $restriction->save();
        return $restriction;
    }

    private function updateRestrictionSpeed(Limit $restriction, array $input)
    {
        $restriction->speed = trim($input['speed']) !== '' ? $input['speed'] : null;

        $restriction->save();
        return $restriction;
    }

    public function deleteRestriction($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function restoreRestriction($id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }
    /**
     * Receives $request->translations[name][$langId]
     * returns $request->translations[name][$langId, $restrictionId, $speed etc]
     * @param  Request $request Request object
     * @return array           the prepared array, ready for foreign table inserts
     */
    public function prepareTranslationInput(array $input, $id)
    {
        // $languageTranslation = [];

        // // get them pilin up like ['language_id', 'limit_id', 'name'] for convenience by insert
        // foreach ($input['translations'] as $key => $translation) {
        //     foreach ($translation as $langId => $value) {
        //         $languageTranslation[] = ['name' => $value, 'language_id' => $langId, 'limit_id' => $id];
        //     }
        // }

        // return $languageTranslation;
    }

    public function prepareAreaTranslationInput($restriction, $input)
    {
        // $languageTranslation = [];
        // // get them pilin up like ['language_id', 'limit_id', 'name'] for convenience by insert
        // foreach ($input['area'] as $key => $translation) {
        //     foreach ($translation as $langId => $value) {
        //         $languageTranslation[] = ['name' => $value, 'language_id' => $langId, 'limit_id' => $restriction->id];
        //     }
        // }

        // return $languageTranslation;
    }

    public function saveAreaTranslations($restriction, $input)
    {
        foreach ($input['area'] as $key => $translation) {
            foreach ($translation as $langId => $value) {
                $restrictionTranslation = $restriction
                    ->area
                    ->translations()
                    ->where('area_id', $restriction->area->id)
                    ->where('language_id', $langId)->first();

                if (isset($restrictionTranslation)) {
                    $restrictionTranslation->update(
                        ['name' => $value]
                    );
                } else {
                    $restriction->area->translations()->create([
                        'name'        => $value,
                        'area_id'     => $restriction->area->id,
                        'language_id' => $langId,
                    ]);
                }

            }
        }
        // $translations = $this->prepareAreaTranslationInput($restriction, $input);
    }

    public function saveTranslations(Limit $restriction, $input)
    {
        foreach ($input['translations'] as $key => $translation) {
            foreach ($translation as $langId => $value) {
                $restrictionTranslation = $restriction
                    ->translations()
                    ->where('limit_id', $restriction->id)
                    ->where('language_id', $langId)->first();
                // find and update the existing one
                if (isset($restrictionTranslation)) {
                    $restrictionTranslation->update(
                        ['name' => $value]
                    );

                } else {
                    $restriction->translations()->create([
                        'name'        => $value,
                        'limit_id'    => $restriction->id,
                        'language_id' => $langId,
                    ]);

                }
            }
        }
        // $translations = $this->prepareTranslationInput($input, $restriction->id);
        // $restriction->translations()->delete();
    }
}
