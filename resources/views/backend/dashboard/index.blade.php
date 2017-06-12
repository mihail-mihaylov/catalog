@extends('backend.wrapper')

@section('page_title')
    {{ trans("dashboard.panel_title") }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-6 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-map-marker"></i>
                            {{ trans("dashboard.panel_subtitle") }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button class="btn btn-custom btn-sm" type="button" id="fit-points">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            &nbsp; {{ trans('dashboard.focus') }}
                        </button>
                    </div>
                </div>

                @include('backend.dashboard.partials.map')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="dashboard_tracked_objects_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('dashboard.list') }}
                        </h5>
                    </div>

                    <div class="ibox-tools">
                        <div class="dashboard_tracked_objects_search inline"></div>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="trackedObjectsTable">
                        <thead class="">
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans("dashboard.name") }}</th>
                                <th>{{ trans("dashboard.identification_number") }}</th>
                                <th>{{ trans("dashboard.last_event")}}</th>
                                <th>{{ trans("dashboard.actions") }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans("dashboard.name") }}</th>
                                <th>{{ trans("dashboard.identification_number") }}</th>
                                <th>{{ trans("dashboard.last_event")}}</th>
                                <th>{{ trans("dashboard.actions") }}</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @if ( ! empty($devicesLastData))
                                @foreach ($devicesLastData as $key => $device)
                                    @include ('backend.dashboard.partials.tracked_objects_row')
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-7">
            <div class="ibox" id="dashboard_shared_tasks_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-7 fix-title">
                        <h5>
                            <i class="glyphicon glyphicon-list"></i>
                            {{ trans('dashboard.recent_unfinished_tasks') }}
                            (<a href="{{ route('shared_tasks.all') }}">{{ trans('tasks.show_all') }}</a>)
                        </h5>
                    </div>

                    <div class="ibox-tools">
                        @can ('createSharedTask', $company)
                            <button class="btn btn-custom btn-sm" type="button" data-get data-action="{{ route('shared_tasks.create') }}" data-title="{{ trans('dashboard.new_task') }}">
                                <i class="fa fa-plus"></i>
                                &nbsp;{{ trans('dashboard.new_task') }}
                            </button>
                            <div class="dashboard_shared_tasks_search inline"></div>
                        @endcan
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered table-striped table-hover data-table table-condensed" id='sharedTasksTable'>
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.priority') }}</th>
                                <th>{{ trans('general.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th></th>
                                <th>{{ trans('general.name') }}</th>
                                <th>{{ trans('general.priority') }}</th>
                                <th>{{ trans('general.type') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @foreach ($sharedTasks as $task)
                                @can ('read_company_shared_tasks')
                                    @include ('backend.sharedTasks.partials.shared_task_row', ['task' => $task, 'company' => $company])
                                @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>
                        <i class="fa fa-rss"></i>
                        {{ trans('dashboard.last_active') }}
                    </h5>
                </div>

                <div class="ibox-content">
                    @forelse ($lastVisited as $poiVisitsDateTime => $poiVisits)
                        @foreach ($poiVisits as $poiVisit)
                            <p>
                                <strong>
                                    {{ $poiVisit->brand_name }}&nbsp;
                                    {{ $poiVisit->model_name }}&nbsp;
                                    ({{ $poiVisit->identification_number }})
                                </strong>

                                @if ($poiVisitsDateTime == $poiVisit->start_time)
                                    {{ trans('dashboard.entered_into') }}
                                @else
                                    {{ trans('dashboard.exit_from') }}
                                @endif
                                <strong>{{ $poiVisit->poi_name }}</strong>

                                {{ trans('dashboard.at') }}
                                {{ \Carbon\Carbon::parse($poiVisitsDateTime)->format('H:i d.m.Y') }}
                            </p>
                        @endforeach
                    @empty
                        <p>{{ trans('general.no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('javascript')
    {!! Html::script('js/modules/dashboard/dashboard.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
