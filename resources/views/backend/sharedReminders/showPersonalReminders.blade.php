@extends('backend.wrapper')

@section('page_title')
    <i class=" fa fa-bell"></i>
    {{trans("reminders.reminder")}}
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{trans_choice('reminders.reminder', 2)}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    {{-- <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul> --}}
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @can('createSharedReminder',$company)
                <a href='{{route('reminders.all')}}' class='btn btn-success pull-left'>
                    {{trans('reminders.show_all')}}
                </a>
                @endcan
                <table class='table table-hover' id='sharedRemindersTable'>
                    <thead>
                        <tr>
                            <th>{{trans('general.number')}}</th>
                            <th>{{trans('general.name')}}</th>
                            <th>{{trans('general.priority')}}</th>
                            <th>{{trans('general.type')}}</th>
                            <th>{{trans('general.actions')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{trans('general.number')}}</th>
                            <th>{{trans('general.name')}}</th>
                            <th>{{trans('general.priority')}}</th>
                            <th>{{trans('general.type')}}</th>
                            <th>{{trans('general.actions')}}</th>
                        </tr>
                    </tfoot>    
                    <tbody>
                        @foreach($reminders as $reminder)
                        @include('backend.sharedReminders.partials.row',[
                        'reminder'=>$reminder,
                        'company'=>$company,
                        ])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('backend.partials.modal')

{!! Html::script('/js/modules/sharedReminders.js'); !!}
@endsection


