<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary custom-color" href="#">
            <i class="fa fa-bars" id="collapse_menu"></i>
        </a>
    </div>

    <ul class="nav navbar-top-links navbar-right">

        <!-- See Violations -->
        {{-- @include('backend.violations.partials.violation_notification_count') --}}


        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ auth()->user()->email }}
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-menu animated fadeInRight m-t-xs">
                {{-- The user can view your own profile, only if managed company is equal to own company --}}
                <li><a href="{{--{{ route('profile.index') }}--}}">{{ trans_choice('profile.profile', 1) }}</a></li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        {{ trans('general.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>