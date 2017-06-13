<?php

namespace App\Modules\Restrictions\Http\Controllers;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Modules\Groups\Repositories\GroupInterface;
use App\Modules\Restrictions\Http\Requests\CreateRestrictionRequest;
use App\Modules\Restrictions\Http\Requests\UpdateRestrictionRequest;
use App\Modules\Restrictions\Interfaces\AreaInterface;
use App\Modules\Restrictions\Interfaces\AreaPointInterface;
use App\Modules\Restrictions\Repositories\RestrictionRepository;
use App\Modules\Restrictions\Interfaces\SlaveRestrictionTranslationsInterface;
use App\Modules\Restrictions\Models\Limit;
use App\Modules\TrackedObjects\Repositories\TrackedObjectInterface;
use App\Modules\Users\Repositories\SlaveUserInterface;
use App\Modules\Violations\Interfaces\ViolationInterface;
use App\Restriction;
use Faker\Provider\es_AR\Company;
use Gate;
use Illuminate\Http\Request;
use View;

class RestrictionController extends Controller
{
    public function __construct(
        RestrictionRepository $restrictionRepository,
        TrackedObjectInterface $trackedObjectsRepository,
        AreaInterface $areas,
        AreaPointInterface $areaPoints,
        ViolationInterface $violations,
        SlaveRestrictionTranslationsInterface $restrictionTranslations,
        SlaveUserInterface $user,
        GroupInterface $groups
    ) {
        $this->restrictionRepository            = $restrictionRepository;
        $this->trackedObjects          = $trackedObjectsRepository;
        $this->areas                   = $areas;
        $this->areaPoints              = $areaPoints;
        // $this->managedCompany          = $this->restrictions->getManagedCompany();
        $this->violations              = $violations;
        $this->restrictionTranslations = $restrictionTranslations;
        $this->user                    = $user;
        $this->groups                  = $groups;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Gate::allows('owner')) {
            $userGroupsIds = $this->groups->all()->lists('id')->toArray();
        // } else {
        //     $userGroupsIds = $this->user->find(auth()->user()->slave_user_id)->groups->lists('id')->all();
        // }
        // foreach ($this->restrictions as $restriction) {
        //     // dd($restriction->violation);
        // }
        return View::make('backend.restrictions.index')->with([
            'restrictions'  => $this->restrictions->with([
                'trackedObjects',
                'area',
                'violations',
                'defaultTranslation',
                'translations',
                'translation',
            ])->withTrashed()->get(),
            'company'       => $this->company,
            'userGroupsIds' => $userGroupsIds,
            // 'violations'    => $this->violations->allWithDeleted(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user           = $this->user->find(auth()->user()->slave_user_id);
        $trackedObjects = $this->trackedObjects->getTrackedObjectsBasedOnGroup($user);

        $html = view('backend.restrictions.partials.create')->with([
            'trackedObjects' => $trackedObjects,
        ])->render();

        return AjaxController::success(['html' => $html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRestrictionRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRestrictionRequest $request)
    {
        // $this->authorize('createRestriction', $this->company);

        // dd($request->all());
        $restriction        = $this->restrictions->create([]);
        $restriction->speed = trim($request->input('speed')) !== '' ? $request->input('speed') : null;
        $restriction->save();

        if (($trackedObjects = $request->input('trackedObjectLimits')) === null) {
            // no tracked objects specified
            // select all for assignment later
            $trackedObjects = $this->trackedObjects->all()->lists('id')->toArray();
        }

        // if no area specified, return response
        if ($request->input('area_point') === null) {
            $restriction->trackedObjects()->sync($trackedObjects);
            $this->restrictions->saveTranslations($restriction, $request->input());
            // $this->restrictions->saveAreaTranslations($restriction, $request->input());

            $html = view('backend.restrictions.partials.row')->with(
                [
                    'restriction' => $restriction,
                    'company'     => $this->company,
                ]
            )->render();

            return AjaxController::success(['html' => $html]);
        }

        // else we go on with area and area points
        $area = $this->areas->create([
            'area_type' => $request->input('area_type'),
            'radius'     => ($request->input('area_type') == 'circle') ? $request->input('radius') : null
        ]);

        // store area points
        // dd($request->input('area_point'));
        foreach ($request->input('area_point') as $areaPoint) {
            $areaPoint = $this->areaPoints->create([
                'area_id'   => $area->id,
                'latitude'  => $areaPoint['lat'],
                'longitude' => $areaPoint['lng'],
            ]);
            $areaPoint->save();
        }

        $restriction->area_id = $area->id;
        $restriction->trackedObjects()->sync($trackedObjects);
        $restriction->save();

        $this->restrictions->saveTranslations($restriction, $request->input());
        $this->restrictions->saveAreaTranslations($restriction, $request->input());

        $html = view('backend.restrictions.partials.row')->with(
            [
                'restriction' => $restriction,
                'company'     => $this->company,
            ]
        )->render();

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
        // $this->authorize('updateRestriction', $this->company);
        $restriction       = $this->restrictions->find($id);
        $user           = $this->user->find(auth()->user()->slave_user_id);
        $allTrackedObjects = $this->trackedObjects->getTrackedObjectsBasedOnGroup($user);

        $unselectedTrackedObjects = $allTrackedObjects->diff($restriction->trackedObjects);
        // dd($restriction->area->areaPoints);
        $html = view('backend.restrictions.partials.edit')->with([
            'area'                     => $restriction->area,
            'restriction'              => $restriction,
            'selectedTrackedObjects'   => $restriction->trackedObjects,
            'unselectedTrackedObjects' => $unselectedTrackedObjects,
        ])->render();

        return AjaxController::success(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRestrictionRequest $request, $id)
    {
        // \DB::listen(function ($q) {
        //     echo "<pre>"; print_r($q->sql);echo "<br>";
        //     echo "<pre>"; print_r($q->sql);echo "<br>";
        // });

        // $this->authorize('updateRestriction', $this->company);
        $restriction = $this->restrictions->find($id);

        $restriction = $this->restrictions->updateRestriction($restriction, $request->input());

        $html = view('backend.restrictions.partials.row')->with([
            'restriction' => $restriction,
            'company'     => $this->company,
        ])->render();

        return AjaxController::success(['html' => $html, 'id' => $restriction->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->authorize('deleteRestriction', $this->company);

        $this->restrictions->deleteRestriction($id);

        $restriction = Limit::withTrashed()->find($id);

        $html = view('backend.restrictions.partials.row')->with([
            'restriction' => $restriction,
            'company'     => $this->company,
        ])->render();

//        return redirect(route('restrictions.index'));
        return AjaxController::success(['html' => $html]);
    }

    /**
     * Restore the specified resource to storage
     * @param $restrictions
     * @return Limit the restriction object
     */
    public function restore($restrictions)
    {
        $this->authorize('deleteRestriction', $this->company);

        $this->restrictions->restoreRestriction($restrictions);

        $restriction = $this->restrictions->find($restrictions);

        $html = view('backend.restrictions.partials.row')->with([
            'restriction' => $restriction,
            'company'     => $this->company,
        ])->render();

//        return redirect(route('restrictions.index'));
        return AjaxController::success(['html' => $html]);
    }
}
