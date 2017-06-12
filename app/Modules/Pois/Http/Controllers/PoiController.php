<?php

namespace App\Modules\Pois\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Modules\Pois\Http\Requests\CreatePoiRequest;
use App\Modules\Pois\Http\Requests\UpdatePoiRequest;
use App\Modules\Pois\Repositories\Eloquent\PoiRepository;
use App\Traits\SwitchesDatabaseConnection;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;

class PoiController extends Controller
{
    public function __construct(PoiRepository $poiRepository)
    {
        $this->poiRepository = $poiRepository;
    }

    public function index()
    {
        $pois = $this->poiRepository->getAllPois();

        return View::make('backend.pois.index')->with(compact( 'pois'));
    }


    public function json()
    {
        $pois = $this->poiRepository->getAllPoisInJson();

        return AjaxController::success(['pois' => $pois]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $languages = \Session::get('company_languages');
        $model = $this->poiRepository->newObject();

        $template = view('backend.pois.partials.create')->with(['languages' => $languages, 'model' => $model])->render();

        return AjaxController::success(['html' => $template]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePoiRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePoiRequest $request)
    {
        $poi = $this->slavePoiRepository->createNewPoi($request);
        $this->slavePoiRepository->createTranslations($request->translations, 'poi_id', $poi);

        $number = $this->slavePoiRepository->getAllPois()->count() + 1;

        $html = view('backend.pois.partials.poi_row', compact('poi', 'number'))->render();
        return AjaxController::success(['html' => $html]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $languages = \Session::get('company_languages');
        $model = $poi = $this->slavePoiRepository->findWithDeletes($id, ['poiPoints']);

        $template = view('backend.pois.partials.edit')->with([
            'languages' => $languages,
            'poi'       => $poi,
            'model'     => $model,
        ])->render();

        return AjaxController::success(['html' => $template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePoiRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePoiRequest $request, $id)
    {
        $poi = $this->slavePoiRepository->updatePoi($request, $id);
        $this->slavePoiRepository->updateTranslations($request->translations, 'poi_id', $poi);

        return $this->getPoiRow($poi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poi = $this->slavePoiRepository->delete($id);

        return $this->getPoiRow($poi);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $poi = $this->slavePoiRepository->restore($id);

        return $this->getPoiRow($poi);
    }


    /**
     * Render row template
     *
     * @param $poi
     * @return mixed
     */
    private function getPoiRow($poi)
    {
        $html = view('backend.pois.partials.poi_row')->with(
            [
                'poi' => $poi,
            ]
        )->render();

        return AjaxController::success(['html' => $html]);
    }
}
