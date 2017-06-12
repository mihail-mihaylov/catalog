<form class="form-horizontal" method='POST' action="{{URL::route('trackedobjects.store')}}" id="createTrackedObjectForm" data-submit="" data-table-name="tracked_objects_table">
    <input type='hidden' name='_token' value='{{csrf_token()}}'>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('brands.brand')}}</label>
        <div class="col-sm-10">
            <select id='brandSelectBox' class='form-control fix-select2' name='tracked_object_brand_id'>
                <option value=''>{{trans('brands.choose_brand')}}</option>
                @foreach($brands as $brand)
                    <option value='{{$brand->id}}'>{{{$brand->translation[0]->name}}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="hr-line-dashed"></div>
    <div id='models_holder' style="display: none;"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('general.type') }}</label>
        <div class="col-sm-10">
            <select id='typeSelectBox' class='form-control fix-select2' name='tracked_object_type_id'>
                @foreach($types as $type)
                <option value='{{$type->id}}'>{{{$type->translation[0]->name}}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('general.identification_number')}}</label>
        <div class="col-sm-10">
            <input type='text' class='form-control' name='identification_number'>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{ trans('trackedObjects.groups') }}</label>
        <div class="col-sm-10">
            <select id='groupSelectBox' class='form-control fix-select2' name='tracked_object_groups_ids[]' multiple="multiple">
                @foreach($groups as $group)
                    <option value='{{ $group->id }}'>
                        {{{$group->translation[0]->name}}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{trans('general.cancel')}}</button>
            <button class="inline btn btn-primary" type="submit">{{trans('general.save')}}</button>
        </div>
    </div>

</form>

<script type="text/javascript">
    $('#brandSelectBox').select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });

    $('#typeSelectBox').select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });

    $('#groupSelectBox').select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
</script>
