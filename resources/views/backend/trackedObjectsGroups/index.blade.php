@extends('backend.wrapper')

@section('page_title')
   {{trans('trackedObjects.tracked_objects')}}
@endsection

@section('content')
{{-- <div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Идент</th>
                            <th class="text-center">Марка/модел</th>
                            <th class="text-center">Рег. номер</th>
                            <th class="text-center">Екстри</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trackedObjects as $trackedObject)
                        @if($trackedObject->deleted_at == null)
                        <tr>
                            <td class="text-center">
                                <span class="label label-default">{{$trackedObject->id	}}</span>
                            </td>
                            <td class="text-center">
                                {{{$trackedObject->brand->translation[0]->name}}}
                            </td>
                            <td class="text-center">
                                {{{$trackedObject->identification_number}}}
                            </td>
                            <td class="text-center">
                                ---
                            </td>
                            <td class="text-center">
                                @can('assignGroup',$company)
                                <button class="btn btn-outline btn-info getTrackedObjectGroups" type="button" data-href="{{route('trackedObject.groups.index',$trackedObject->id)}}">
                                    Управление на групи
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5">Няма добавени следени обекти</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
<div class='row'>
    <div class='col-md-12'>
        <h1 class='page-header'>
            <i class="fa fa-table"></i>
            {{trans_choice('groups.group', 2)}}
            @can('createGroup',$company)
            <button type="button" class="btn btn-primary btn-outline btn-md pull-right createTrackedObjectGroup" data-href="{{route('trackedobjects.groups.create')}}">
                <i class="fa fa-plus"></i>&nbsp; {{trans('groups.create')}}
            </button>
            @endcan
        </h1>
        <div id="groupsHolder">
            @forelse($groups as $group)
                @include('backend.trackedObjectsGroups.partials.row_group', ['group'=>$group])
            @empty
                {{trans("groups.groups_no_data")}}
            @endforelse
        </div>
    </div>
</div>
@include('backend.partials.modal')
<script src='/js/modules/trackedObjects.js'></script>
@endsection
