<div class="ibox float-e-margins" id="group-{{$group->id}}">
    <div class="ibox-title">
        <h5>
        {{-- <h5>{{{$group->translation->first()->name}}} --}}

        </h5>

                <!--<span class="label label-primary">IN+</span>-->
        <div class="ibox-tools">
            <a class="collapse-link" data-toggle="tooltip" data-placement="top" title="{{trans('general.collapse')}}">
                <i class="fa fa-chevron-up"></i>
                [{{trans('general.collapse')}}]
            </a>
            @can('editGroup',$company)

            <button data-group-id="{{$group->id}}" class="editGroupName" data-toggle="tooltip" data-placement="top" title="{{trans('general.edit')}}">
                <i class="fa fa-wrench"></i>
                [{{trans('general.edit')}}]
            </button>
            @endcan
            @can('deleteGroup',$company)
            @if($group->deleted_at == null)
            <button class="deleteTrackedObjectGroup" data-href="{{route('trackedobjects.groups.destroy',['id' => $group->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('general.delete')}}" >
                <i class="fa fa-times"></i>
                [{{trans('general.delete')}}]
            </button>
            @else
            <button class="restoreTrackedObjectGroup" data-href="{{ route('trackedobjects.groups.restore', ['id' => $group->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('general.restore')}}">
                <i class="fa fa-undo"></i>
                [{{trans('general.restore')}}]
            </button>
            @endif
            @endcan
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <!--            <div class="col-lg-12">
                            <div class="btn-group pull-left" role="group" aria-label="...">
                                <button type="button" class="btn btn-default editGroupName">Edit</button>
                                <button type="button" class="btn btn-default deleteGroup">Delete</button>
                                <button type="button" class="btn btn-default restoreGroup">Restore</button>
                            </div>
                        </div>-->
            <div class="col-lg-12">
                <br>
                @include('backend.trackedObjects.groups.partials.list_group_tracked_objects',['group'=>$group,'company'=>$company])
            </div>
        </div>
    </div>
</div>