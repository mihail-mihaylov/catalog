<div class="tabs-container">
    <form method="POST" class="restriction_store_form"  action="{{route('restrictions.store')}}" data-submit data-table-name="restrictions_table">
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
                <div class="tab-pane {{($language->pivot->default==1)?'active':''}}" id="language-tab-{{$i}}" role="tabpanel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="groupName">{{trans('general.name')}}:</label>
                            <input id="groupName" type="text" name="translations[name][{{$language->id}}]" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="groupName">{{trans('area.name')}}:</label>
                            <input id="groupName" type="text" name="area[name][{{$language->id}}]" class="form-control" >
                        </div>
                    </div>
                    <?php $i++; ?>
                </div>
            @endforeach
        </div><br />

        <div class="form-group">
            <label for="trackedObjectLimits">{{trans_choice('trackedObjects.trackedОbject', 1)}}</label><br>
            <select id="restriction-vehicles" class="form-control fix-select2" name="trackedObjectLimits[]" multiple="multiple">
                @foreach($trackedObjects as $trackedObject)
                    <option value="{{ $trackedObject->id }}">{{$trackedObject->identification_number}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="speed">{{trans('restrictions.allowed_speed')}}</label><br>
            <input type="text" class="form-control" name="speed">
        </div>

        <div class="form-group">
            <label>{{trans('restrictions.pick_allowed_area')}}</label>
            <div id="create_map"></div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 pull-right">
                <button type="button" class="btn btn-white" data-dismiss="modal">
                    {{trans('general.cancel')}}
                </button>
                <button class="inline btn btn-primary restriction_store_button" type="button">{{trans('general.save')}}</button>
            </div>
        </div>
    </form>
    <br />
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
