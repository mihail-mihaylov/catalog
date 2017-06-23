    @forelse($group->trackedObjects as $trackedObject)

        @if($trackedObject->deleted_at != null)
            <span class="btn btn-white ">
                {{{$trackedObject->brand->translation->first()->name}}} &nbsp; / &nbsp; <label class="badge badge-danger"> {{{$trackedObject->identification_number}}}</label>
                &nbsp;
                {{--@if($group->deleted_at == null)
                    @can('assignGroup',$company)
                        <button type="submit" class='btn btn-white btn-xs' data-update
                         data-action="{{route('trackedObjects.groups.remove.trackedObject',['trackedObjectId'=>$trackedObject->id,'groupId'=>$group->id])}}">
                           <i class="fa fa-remove"></i>
                        </button>
                    @endcan
                @endif--}}
            </span>
        @else
            <span class="btn btn-white ">
                {{{$trackedObject->brand->translation->first()->name}}} &nbsp; / &nbsp; <label class="badge badge-success"> {{{$trackedObject->identification_number}}}</label>
                &nbsp;
                {{--@if($group->deleted_at == null)
                    @can('assignGroup',$company)
                        <button type="submit" class='btn btn-white btn-xs' data-update
                         data-action="{{route('trackedObjects.groups.remove.trackedObject',['trackedObjectId'=>$trackedObject->id,'groupId'=>$group->id])}}">
                           <i class="fa fa-remove"></i>
                        </button>
                    @endcan
                @endif--}}
            </span>
        @endif
    @empty
        {{trans('trackedObjects.none_found')}}
    @endforelse
@else
    @forelse($group->withDeletedTrackedObjects as $trackedObject)

        @if($trackedObject->deleted_at != null)
            <span class="btn btn-white ">
                {{{$trackedObject->brand->translation->first()->name}}} &nbsp; / &nbsp; <label class="badge badge-danger"> {{{$trackedObject->identification_number}}}</label>
                &nbsp;
                {{--@if($group->deleted_at == null)
                    @can('assignGroup',$company)
                        <button type="submit" class='btn btn-white btn-xs' data-update
                         data-action="{{route('trackedObjects.groups.remove.trackedObject',['trackedObjectId'=>$trackedObject->id,'groupId'=>$group->id])}}">
                           <i class="fa fa-remove"></i>
                        </button>
                    @endcan
                @endif--}}
            </span>
        @else
            <span class="btn btn-white ">
                {{{$trackedObject->brand->translation->first()->name}}} &nbsp; / &nbsp; <label class="badge badge-success">	{{{$trackedObject->identification_number}}}</label>
                &nbsp;
                {{--@if($group->deleted_at == null)
                    @can('assignGroup',$company)
                        <button type="submit" class='btn btn-white btn-xs' data-update
                         data-action="{{route('trackedObjects.groups.remove.trackedObject',['trackedObjectId'=>$trackedObject->id,'groupId'=>$group->id])}}">
                           <i class="fa fa-remove"></i>
                        </button>
                    @endcan
                @endif--}}
            </span>
        @endif
    @empty
        {{trans('trackedObjects.none_found')}}
    @endforelse
@endif
