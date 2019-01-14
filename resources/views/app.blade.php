<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mihail Mihaylov">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Catalog</title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{!! asset('dist/css/sb-admin-2.css') !!}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{!! asset('vendor/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css">

</head>
<body>

<div id="wrapper">

    @yield('wrapper')

</div>

<!-- jQuery -->
<script src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{!! asset('vendor/metisMenu/metisMenu.min.js') !!}"></script>

<!-- Morris Charts JavaScript -->
<script src="{!! asset('vendor/raphael/raphael.min.js') !!}"></script>
<script src="{!! asset('vendor/morrisjs/morris.min.js') !!}"></script>
<script src="{!! asset('data/morris-data.js') !!}"></script>

<!-- Custom Theme JavaScript -->
<script src="{!! asset('dist/js/sb-admin-2.js') !!}"></script>

@yield('javascript')

</body>

</html>