@foreach($notifications as $notification)
    <div class="notification_list">
        <li>
            <div class="dropdown-messages-box">
                <div class="media-body m-l-md">
                    <a href="#" id="view_violation_data" class="pull-right" data-id="{{$notification->violation->id}}">
                        <i class="fa fa-map-marker fa-2x"></i>
                    </a>

                    <strong>
                        {{$notification
                            ->violation
                            ->device
                            ->trackedObject
                            ->identification_number}}
                    </strong> <br />
                    <strong>
                        {{ trans('violations.violation_of') }}
                    </strong>
                    @if ($notification->violation->is_area_violated)
                        {{ trans('violations.by_area') }}
                    @endif
                    @if ($notification->violation->is_speed_violated)
                        {{ trans('violations.by_speed') }}
                    @endif
                    .
                    <small class="pull-right">{{ \Carbon\Carbon::parse($notification->violation->start_time)->format('Y-m-d H:i') }}</small>
                </div>
            </div>
        </li>
        <li class="divider"></li>
    </div>
@endforeach

<li>
    <div class="text-center link-block">
        <a href="{{ URL::to('restrictions#violations') }}">
            <strong>{{ trans('header.show_all') }}</strong>
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</li>

@if (count($notifications) > 0)
    <li class="divider"></li>

    <li>
        <div class="text-center link-block">
            <a href="javascript:void(0);" id="clear_violations" data-action="{{ route('violations.clear') }}">
                <strong>{{ trans('header.clear_all') }}</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </li>
@endif
