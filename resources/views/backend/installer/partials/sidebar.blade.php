<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <a href="{{route('dashboard.index')}}">
                            <img alt="NetFleet-Logo" class="img-responsive" src="{{ asset('img/NetFleet-logo-small.png') }}" />
                        </a>
                    </span>
                </div>
                <div class="logo-element">
                    <span>
                        <a href="{{route('dashboard.index')}}">
                            <img alt="NetFleet-Logo" class="img-responsive" src="{{ asset('img/NF-logo.png') }}" />
                        </a>
                    </span>
                </div>
            </li>
            <li>
                <a href="{{ route('installer.index') }}">
                    <i class="fa fa-gears">
                    </i>
                    <span class="nav-label">
                        {{trans_choice('sidebar.installer', 1)}}
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>
