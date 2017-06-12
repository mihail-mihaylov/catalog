@extends('backend.wrapper')

@section('page_title')
    {{ trans('tasks.all_tasks') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="all_tasks_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-tasks"></i>
                            {{ trans('general.list_of') }} {{ trans('tasks.all_tasks') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        @can('createSharedTask',$company)
                            <button class='btn btn-custom btn-sm addNewSharedTask' data-action="{{route('shared_tasks.create')}}" data-get data-title="{{trans('tasks.add_new')}}">
                                <i class="fa fa-plus"></i>
                                {{ trans('tasks.add_new') }}
                            </button>
                        @endcan
                        <div class="all_tasks_search inline"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class='table table-hover table-bordered table-striped data-table table-condensed' id='sharedTasksTable'>
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.priority') }}</th>
                                <th>{{ trans('general.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.priority') }}</th>
                                <th>{{ trans('general.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($sharedTasks as $task)
                                @include('backend.sharedTasks.partials.shared_task_row', ['task' => $task, 'company' => $company])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.modal')
@endsection

@section('javascript')
    {{--{!! Html::script('/js/modules/sharedTasks.js') !!}--}}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
