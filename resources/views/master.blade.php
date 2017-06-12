{{-- Sockets bullshits wants to be first --}}

<!DOCTYPE html>
<html>
    <head>
        <title>Tracker</title>

        <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}" type="text/css">

        @yield('head')

        <!-- JS -->
        <script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
    </head>

    <body>
        <input id="csrf_token_master" type='hidden' name='csrf_token' value="{{ csrf_token() }}">
        <div id="wrapper">
            @yield('wrapper')
        </div>

        @include('partials/translations')
        {!! Html::script ('js/leaflet_dependencies.js') !!}
        {!! Html::script('js/define-icons.js') !!}

        @yield('javascript')
        {{--{!! Html::script('js/socket_event_handler.js') !!}--}}
        {{--{!! Html::script('js/show_notification_violation.js') !!}--}}
    </body>
</html>