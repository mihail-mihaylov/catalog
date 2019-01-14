<div class="navbar-header">
    <a class="navbar-brand" href="#">Catalog</a>
</div>

<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            {{ Auth::user()->email }} <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
        </ul>
    </li>
</ul>