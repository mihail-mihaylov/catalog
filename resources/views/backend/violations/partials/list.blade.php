<table class="table table-striped table-bordered table-hover data-table table-condensed text-left" id="violations_table">
    <thead>
        <tr class="gradeX">
            <th></th>
            <th>{{ trans('trackedObjects.tracked_objects') }}</th>
            <th>{{ trans('general.details') }}</th>
            <th>{{ trans('general.from') }}</th>
            <th>{{ trans('general.to') }}</th>
            <th>{{ trans('general.actions') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="gradeX">
            <th></th>
            <th>{{ trans('trackedObjects.tracked_objects') }}</th>
            <th>{{ trans('general.details') }}</th>
            <th>{{ trans('general.from') }}</th>
            <th>{{ trans('general.to') }}</th>
            <th>{{ trans('general.actions') }}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($restrictions as $restriction)
            @foreach ($restriction->violations as $violation)
                @if ( ! is_null($violation->device) &&
                      ! is_null($violation->device->trackedObject) &&
                      ! empty(array_intersect($violation->device->trackedObject->groups->lists('id')->all(), $userGroupsIds)))
                    <tr class="restriction-{{$restriction->id}}">
                        <td></td>
                        <td>{{ $violation->device->trackedObject->identification_number }}</td>
                        <td >
                            @if ($violation->is_speed_violated)
                                {{ trans('violations.by_speed') }}
                            @endif
                            <br>
                            @if ($violation->is_area_violated)
                                {{ trans('violations.by_area') }}
                            @endif
                        </td>
                        <td>{{ $violation->start_time }}</td>
                        <td>{{ $violation->end_time }}</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-info" data-title="{{ trans('violations.view_violation') }}" data-id="{{ $violation->id }}" data-action="{{ route('violations.show', ['id' => $violation->id])}}" data-get>

                                <i class="fa fa-map-marker"></i>
                                {{ trans('general.view_on_map') }}
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
<div class="hidden" id="trans_speed" data-translation="{{ trans('general.speed') }}"></div>
<div class="hidden" id="trans_allowed_speed" data-translation="{{ trans('general.allowed_speed') }}"></div>
