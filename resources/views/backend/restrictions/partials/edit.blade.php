<div class="tabs-container">
    <form method="PUT" class="restriction_update_form" action="{{route('restrictions.update', ['id' => $restriction->id])}}" data-submit data-table-name="restrictions_table">
        <ul class="nav nav-tabs" role="tablist">
            <?php $i = 0; ?>
            @foreach(Session::get('company_languages') as $language)
                <li role="presentation" class="{{($language->pivot->default==1)?'active':''}}">
                    <a href="#language-tab-{{$i}}" aria-controls="language-tab-{{$i}}" role="tab" data-toggle="tab">{{{$language->name}}}</a>
                </li>
                <?php $i++; ?>
            @endforeach
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach(Session::get('company_languages') as $language)
                <div class="tab-pane {{($i==0)?'active':''}}" id="language-tab-{{$i}}" role="tabpanel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="groupName">{{trans('general.name')}}:</label>
                            <input id="groupName" type="text" name="translations[name][{{$language->id}}]" class="form-control" value="{{!$restriction->translations->isEmpty() ? $restriction->translations()->where('language_id',$language->id)->first()->name:null}}">
                        </div>
                        <div class="form-group">
                            <label for="groupName">{{trans('general.area_name')}}:</label>
                            <input id="groupName" type="text" name="area[name][{{$language->id}}]" class="form-control" value="{{($area !== null) && (! $area->translations->isEmpty()) ?
                            $area->translations()
                            ->where('language_id', $language->id)
                            ->first()->name :
                            null}}" >
                        </div>
                    </div>
                    <?php $i++; ?>
                </div>
            @endforeach
        </div><br />

        <div class="form-group">
            <select id="restriction-vehicles" class="col col-lg-12 form form-control fix-select2" name="trackedObjectLimits[]" multiple="multiple">
                @foreach($restriction->trackedObjects as $selectedTrackedObject)
                    <option value="{{ $selectedTrackedObject->id }}" selected>{{$selectedTrackedObject->identification_number}}</option>
                @endforeach
                @foreach($unselectedTrackedObjects as $unselectedTrackedObject)
                    <option value="{{ $unselectedTrackedObject->id }}" >{{$unselectedTrackedObject->identification_number}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="speed">{{trans('restrictions.allowed_speed')}}</label><br>
            <input type="text" class="form-control" name="speed" value="{{$restriction->speed}}">
        </div>

        <!-- Hidden checkbox for deleting area  -->
        <input type="checkbox" name="delete_area" class="delete_area" style="display: none;"><br><br />

        <label>{{trans('restrictions.pick_allowed_area')}}</label>
        <div class="area_data">
            @if ($restriction->area)
                @foreach($restriction->area->areaPoints as $areaPoint)
                    <div class="area_data area_points edit-form-lat" data-longitude="{{$areaPoint->longitude}}" data-latitude="{{$areaPoint->latitude}}"></div>
                @endforeach
                <div class="hidden area_data area_radius" name="radius" data-radius="{{$restriction->area->radius}}" ></div>
                <div class="hidden area_data area_type" name="area_type" data-areatype="{{$restriction->area->area_type}}"></div>
            @else
        </div>
            @endif
        <div id="edit_map"></div>
        <br>

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right">
                <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
                <button class="inline btn btn-primary restriction_update_button" type="button">
                    {{trans('general.save')}}
                </button>
            </div>
        </div>
    </form>

</div>

<script type="text/javascript">
    $('#restriction-vehicles').select2({
        width:"100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
</script>
