<tr class="gradeX restriction_{{ $restriction->id }}" id="restriction_{{ $restriction->id }}">
    <td></td>
    <td>
        @if ( ! $restriction->translation->isEmpty())
            {{ $restriction->translation->first()->name }}
        @endif
    </td>
    <td>
        @foreach ($restriction->trackedObjects as $trackedObject)
            {{ $trackedObject->identification_number }}
        @endforeach
    </td>
    @if (($restriction->area_id !== null) && ($restriction->speed != 0))
        <td>
            {{ trans('restrictions.speed_and_area') }}
        </td>
    @elseif($restriction->area_id !== null)
        <td>
            {{ trans('restrictions.area') }}
        </td>
    @else
        <td>
            {{ trans('restrictions.speed') }}
        </td>
    @endif
    <td class="center">{{ $restriction->speed }}</td>
    <td>
        @if ($restriction->deleted)
            @can ('deleteRestriction', $company)
            <button class='btn btn-success btn-xs' data-action='{{
                                            route('restrictions.restore', [
                                                'restriction' => $restriction->id
                                            ]) }}' data-update data-id="{{ $restriction->id }}" data-update-table='violations_table'>
                <i class="fa fa-refresh"></i>&nbsp;
                {{ trans('general.restore') }}
            </button>
            @endcan
        @else
            @can ('updateRestriction', $company)
            <button class="inline btn btn-xs btn-warning" id="restriction-edit" role="button" data-title="{{ trans('general.edit') }}" data-id="{{ $restriction->id }}" data-action="{{ route('restrictions.edit', ['restrictions' => $restriction->id]) }}" data-get>
                <i class="fa fa-pencil-square-o"></i>
                {{trans('general.edit')}}
            </button>
            @endcan
            @can ('deleteRestriction', $company)
            <button class='btn btn-danger btn-xs' data-action='{{ route('restrictions.destroy', ['id' => $restriction->id]) }}' data-delete data-id="{{ $restriction->id }}" data-update-table='violations_table'>
                <i class="fa fa-trash-o"></i>&nbsp;
                {{trans('general.delete')}}
            </button>
            @endcan
        @endif
    </td>
</tr>
