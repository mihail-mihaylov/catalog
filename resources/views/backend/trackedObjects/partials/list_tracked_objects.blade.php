<form class='form-horizontal' action="{{ route('group.trackedObjects.sync', ['groupId' => $groupId]) }}" method="POST" data-table-name="groups_table" data-submit>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label class="col-sm-3 control-label">
            {{trans('trackedObjects.tracked_objects')}}
        </label>
        <div class="col-sm-9">
            <select class="js-example-basic-multiple form-control" name="trackedObjects[]" multiple="multiple">
                @foreach($trackedObjects as $trackedObject)
                    @if (in_array($trackedObject->id, $trackedObjectsInGroup))
                        <option value="{{ $trackedObject->id }}" selected>{{ $trackedObject->brand->translation->first()->name }} ({{ $trackedObject->identification_number }})</option>
                    @else
                        <option value="{{ $trackedObject->id }}">{{ $trackedObject->brand->translation->first()->name }} ({{ $trackedObject->identification_number }})</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 pull-right m-r">
            <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            <button class="inline btn btn-primary" type="submit">{{ trans('general.save') }}</button>
        </div>
    </div>
</form>

<script>
    $(".js-example-basic-multiple").select2({
        width: '100%',
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
</script>
