<tr class="read" id="trackedObjectRow{{$trackedObject->id}}">
    <td>{{{$trackedObject->brand->translation->first()->name}}}</td>
    <td>{{{$trackedObject->identification_number}}}</td>
    <td>
    </td>
    <td>n/a</td>
    <td>n/a</td>
    <td>
        <a href="" class="btn btn-md btn-info btn-outline">
            <i class="fa fa-map-marker"></i>
            {{trans('general.view_on_map')}}
        </a>
        <a href="" class="btn btn-md btn-success btn-outline">
            <i class="fa fa-eye"></i>
            {{trans('general.view_on_google_street')}}
        </a>
        @can('updateTrackedObject',$company)
        <button class="btn btn-md btn-primary btn-outline editTrackedObject" type="button" data-href="{{route('trackedobjects.edit',$trackedObject->id)}}">
            <i class="fa fa-edit"></i>
            {{trans('general.edit')}}
        </button>
        @endcan
        @can('deleteTrackedObject',$company)
        @if($trackedObject->deleted_at !== null)
        <button class="btn btn-info btn-outline btn-md restoreTrackedObjectButton" type="button"  data-href="{{ route('trackedobjects.restore', ['id' => $trackedObject->id]) }}" >
            {{trans('general.restore')}}
        </button>
        @else
        <button type="button" class="btn btn-danger btn-outline btn-md removeTrackedObject" data-href="{{route('trackedobjects.destroy', ['id' => $trackedObject->id])}}">
            <i class="fa fa-trash-o"></i>
            {{trans('general.delete')}}
        </button>
        @endif
        @endcan
    </td>
</tr>