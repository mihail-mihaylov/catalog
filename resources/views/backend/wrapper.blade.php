@extends('master')

@section('wrapper')
	<!-- Left SideBar -->
	@include('backend.partials.sidebar')

	<!-- Main Page -->
	<div id="page-wrapper" class="gray-bg">

		<!-- Language -->
		{{--<div class="data-locale" data-locale="{{ App::getLocale() }}"></div>--}}

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

		<!-- Right SideBar -->
		<!-- <div id="right-sidebar"></div> -->
	</div>

	<!-- Modals -->
    @include('backend.partials.modal')
{{--	@include('backend.global_partials.view_violation_modal')--}}

	<!-- Authenticated user id, managaed_company id -->
    {{--<input type='hidden' id="hidden_date_day_start" value="{{ Carbon\Carbon::now()->setTimezone(Session::get('system_timezone')['string_format'])--}}
    {{--->format('Y-m-d 00:00:00') }}">--}}
    {{--<input type='hidden' id="hidden_date_day_end" value="{{ Carbon\Carbon::now()->setTimezone(Session::get('system_timezone')['string_format'])--}}
    {{--->format('Y-m-d 23:59:59') }}">--}}
    {{--<input type="hidden" id="company_id" value="{{ Session::get('managed_company')->id }}">--}}
    <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
@endsection
