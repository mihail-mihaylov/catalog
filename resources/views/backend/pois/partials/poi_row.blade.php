<tr id='poi{{ $poi->id }}' class="gradeX">
    <td></td>
    <td>{{ $poi->translation->isEmpty() ? ' - ' : $poi->translation->first()->name }}</td>
    <td>
        <img src='{{ "images/pois/" . trans("$poi->icon").".png" }}'/> {{ trans("poi." . $poi->icon) }}
    </td>
    <td class="pull-left">
        <a href="#" data-poi-id="{{ $poi->id }}" class="btn btn-xs btn-info see_poi_on_map">
            <i class="fa fa-map-marker"></i>
            {{trans('general.view_on_map')}}
        </a>
        <a href="https://maps.google.com/?cbll={!! $poi->poiPoints->first()->latitude !!},{!! $poi->poiPoints->first()->longitude !!}&cbp=12,0,0,0,10&layer=c" class="btn btn-xs btn-success streetview-link" target="_blank">
            <i class="fa fa-eye"></i>
            {{ trans('poi.see_in_google_street') }}
        </a>

        @if ($poi->deleted_at !== null)
            @can ('deletePoi', $company)
                <button type="button" class="btn btn-xs btn-success restore_user reload_action" data-action="{{ route('pois.restore', $poi->id) }}" data-update>
                    <i class="fa fa-refresh"></i>
                    {{ trans('general.restore') }}
                </button>
            @endcan
        @else
            @can ('updatePoi',$company)
                <button class="edit_user btn btn-xs btn-warning" data-id="{{ $poi->id }}" data-title="{{ trans('poi.edit_poi') }}" data-action="{{ route('pois.edit', ['id' => $poi->id]) }}" data-get>
                    <i class="fa fa-pencil-square-o"></i>
                    {{ trans('general.edit') }}
                </button>
            @endcan
            @can ('deletePoi', $company)
                <button type="button" class="btn btn-xs btn-danger reload_action" data-action="{{ route('pois.destroy', ['id' => $poi->id]) }}" data-delete>
                    <i class="fa fa-trash-o"></i>
                    {{ trans('general.delete') }}
                </button>
            @endcan
        @endif
    </td>
</tr>
