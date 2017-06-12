<tr id="driverRow{{$driver->id}}" class="gradeX">
    <td></td>
    <td class="text-left">
        @if ( ! $driver->translation->isEmpty())
            {{ $driver->translation->first()->first_name }}
        @endif
    </td>
    <td class="text-left">
        @if ( ! $driver->translation->isEmpty() && $driver->translation->first()->middle_name != null)
            {{ $driver->translation->first()->middle_name }}
        @endif
    </td>
    <td class="text-left">
        @if ( ! $driver->translation->isEmpty())
            {{ $driver->translation->first()->last_name }}
        @endif
    </td>
    <td class="text-left">{{$driver->phone}}</td>
    <td class="text-left">{{$driver->identification_number}}</td>
    <td class="text-left">
        @can('deleteDriver',$company)
            @if($driver->deleted_at == null)
                @can('updateDriver',$company)
                    <button data-action='{{route('drivers.edit',$driver->id)}}' class="btn btn-warning btn-xs editDriver" data-title="{{trans('general.edit')}}" data-get>
                        <i class="fa fa-edit"></i>&nbsp;
                        {{trans('general.edit')}}
                    </button>
                @endcan
                <button class="btn btn-danger btn-xs deleteDriver" data-action="{{route('drivers.destroy',$driver->id)}}" data-delete>
                    <i class="fa fa-trash-o"></i>&nbsp;
                    {{trans('general.delete')}}
                </button>
            @else
                <button class="btn btn-success btn-xs restoreDriver" data-action="{{route('drivers.restore',$driver->id)}}" data-update>
                    <i class="fa fa-refresh"></i>&nbsp;
                    {{trans('general.restore')}}
                </button>
            @endif
        @endcan
    </td>
</tr>
