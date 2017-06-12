@extends('backend.wrapper')

@section('page_title')
    {{ trans_choice('reminders.all_reminders', 2) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="all_reminders_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-globe"></i>
                            {{ trans('general.list_of') }} {{ trans_choice('reminders.all_reminders', 2) }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        <button class='btn btn-custom btn-sm addNewSharedReminder' data-action="{{route('reminders.create')}}" data-title="{{trans('reminders.add_new')}}" data-get>
                            <i class="fa fa-plus-circle"></i>&nbsp;
                            {{trans('reminders.add_new')}}
                        </button>
                        <div class="all_reminders_search inline"></div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class='table table-hover table-striped table-bordered data-table table-condensed' id='sharedRemindersTable'>
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{trans('general.name')}}</th>
                                <th>{{trans('general.priority')}}</th>
                                <th>{{trans('general.type')}}</th>
                                <th>{{trans('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{trans('general.name')}}</th>
                                <th>{{trans('general.priority')}}</th>
                                <th>{{trans('general.type')}}</th>
                                <th>{{trans('general.actions')}}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($sharedReminders as $sharedReminder)
                                @include('backend.sharedReminders.partials.row', [ 'sharedReminder' => $sharedReminder, 'company'=>$company])
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
    {!! Html::script('/js/modules/sharedReminders.js') !!}
    {!! Html::script('/js/data-tables.js') !!}
@endsection
