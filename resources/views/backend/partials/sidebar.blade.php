<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <a href="{{ route('dashboard.index') }}"><a>
                    </span>
                </div>
                <div class="logo-element">
                    <span>
                        <a href="{{ route('dashboard.index') }}">
                        </a>
                    </span>
                </div>
            </li>
            <li {{ Request::is('dashboard') ? 'class=active' : '' }}>
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="nav-label">
                        {{ trans_choice('sidebar.dashoard', 1) }}
                    </span>
                </a>
            </li>
            <li {{ Request::is('reports/general')  ? 'class=active' : '' }}>
                <a href="{{ route('general.index') }}">
                    <i class="glyphicon glyphicon-flash"></i>&nbsp;
                    <span class="nav-label">
                        {{ trans('reports.general_report') }}
                    </span>
                </a>
            </li>

            <li {{ Request::is('pois') ? 'class=active' : '' }}>
                <a href="{{ route('pois.index') }}">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    <span class="nav-label">
                        {{ trans_choice('sidebar.poi', 2) }}
                    </span>
                </a>
            </li>

            <li {{ Request::is('devices') ||
                    Request::is('user')
                    ? 'class=active' : '' }}>
                <a href="#">
                    <i class="glyphicon glyphicon-stats"></i>
                    <span class="nav-label">
                        {{ trans_choice('sidebar.administration', 2) }}
                    </span>
                    <span class="fa arrow"></span>
                </a>

                <ul class="nav nav-second-level collapse">

                    <li {{ Request::is('devices') ? 'class=active' : '' }}>
                        <a href="{{ route('device.index') }}">
                            <i class="fa fa-car"></i>
                            <span class="nav-label">
                                {{ trans('devices.devices') }}
                            </span>
                        </a>
                    </li>

                    <li {{ Request::is('user') ? 'class=active' : '' }}>
                        <a href="{{ route('user.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">
                                {{ trans_choice('sidebar.user', 2) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
