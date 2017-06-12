@extends('backend.wrapper')

@section('page_title')
    {{ trans('reminders.scope_personal') }}&nbsp;
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="personal_reminders_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-globe"></i>
                            {{ trans('general.list_of') }} {{ trans('reminders.scope_personal') }}&nbsp;
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        @can('admin')
                        <a href='{{ route('reminders.all') }}' class='btn btn-custom btn-sm'>
                            <i class="fa fa-th-large"></i>
                            {{ trans('reminders.show_all') }}
                        </a>
                        @endcan
                        <div class="personal_reminders_search inline"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class='table table-hover table-striped table-bordered data-table table-condensed' id='sharedRemindersTable'>
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
                            @foreach ($sharedReminders as $sharedReminder)
                                @can('viewReminder', $sharedReminder)
                                    @include('backend.sharedReminders.partials.row', [ 'sharedReminder' => $sharedReminder, 'company'=>$company])
                                @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    {!! Html::script('/js/modules/sharedReminders.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection


