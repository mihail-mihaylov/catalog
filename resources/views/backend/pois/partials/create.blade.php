<div class="tabs-container">
    <form class="form-horizontal" data-submit method='POST' data-table-name="pois_table" action="{{URL::route('pois.store')}}" >
        <div class="form-group">
            <label class="col-sm-2 control-label" name="icon">{{ trans('poi.icon') }}</label>
            <div class="col-sm-10">
                {!!
                    Form::select(
                        'icon',
                        [
                            'house_parking' => trans('poi.house_parking'), //'Дом / паркинг',
                            'warehouse' => trans('poi.warehouse'), //'Склад',
                            'shop' => trans('poi.shop'), //'Магазин',
                            'factory' => trans('poi.factory'), //'Завод',
                            'office_building' => trans('poi.office_building'), //'Офис',
                            'service' => trans('poi.service'), // 'Сервиз',
                            'gas_station' => trans('poi.gas_station'), //'Бензиностанция'
                            'station' => trans('poi.station'), //'Спирка'
                            'rail_station' => trans('poi.rail_station'), //'Гара'
                        ],
                        '1',
                        [
                            'class' => 'form-control',
                            'data-placeholder' => 'Моля изберете'
                        ])
                !!}
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        <div class="form-group">
            <div id="map_modal" style="width:100%;height: 400px;"></div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label hidden">{{ trans('poi.coordinates') }}</label>

            <div class="col-sm-10">
                {!!
                    Form::hidden(
                    'coordinates',
                    null,
                    [
                        'id' => 'locationvalue',
                        'class' => 'form-control',
                        'placeholder' => trans('poi.map_explanation'), //
                    ])
                !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right m-r">
                <button type="button" class="btn btn-white" data-dismiss="modal">
                    {{trans('general.cancel')}}
                </button>
                <button class="inline btn btn-primary" type="submit">
                    {{trans('general.save')}}
                </button>
            </div>
        </div>
    </form>
</div>






