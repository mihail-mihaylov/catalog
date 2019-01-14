@extends('app')

@section('wrapper')
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        @include('partials.header')
        @include('partials.sidebar')
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>

@endsection