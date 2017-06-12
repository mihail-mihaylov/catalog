@extends('backend.wrapper')

@section('page_title')
    {{trans('tasks.personal_tasks')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="personal_tasks_list">
                <div class="ibox-title fic ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-tasks"></i>
                            {{ trans('general.list_of') }} {{ trans('tasks.personal_tasks') }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        @can('createSharedTask',$company)
                            <a href='{{route('shared_tasks.all')}}' class='btn btn-custom btn-sm'>
                                <i class="fa fa-th-large"></i>
                                {{ trans('tasks.show_all') }}
                            </a>
                        @endcan
                        <div class="personal_tasks_search inline"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class='table table-hover table-striped table-bordered data-table table-condensed' id='sharedTasksTable'>
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
                            @foreach ($tasks as $task)
                                @include('backend.sharedTasks.partials.shared_task_row', ['task' => $task, 'company' => $company])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('/js/modules/sharedTasks.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
