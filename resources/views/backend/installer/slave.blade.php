@extends('master')

@section('slave')

    <!-- Left SideBar -->
	@include('backend.installer.partials.sidebar')

    <!-- Main Page -->
	<div id="page-wrapper" class="gray-bg installer-1">

        <!-- Language -->
        <div class="data-locale" data-locale="{{App::getLocale()}}"></div>

		<!-- Page Header -->
        <div class="row border-bottom gray-bg">
            @include ('backend.partials.header')
        </div>

        <!-- Page Heading -->
        <div class="row wrapper border-bottom white-bg page-heading">
            @include('backend.partials.page_title')
        </div>

		<!-- Page Content -->
        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>

		<!-- Page Footer -->
        @include('backend.partials.footer')
	</div>
@endsection
