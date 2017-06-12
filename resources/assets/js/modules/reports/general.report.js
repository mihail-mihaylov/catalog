$(function() {

var map, points=[], allpoints=[], allpolylines=[], polygroup, pointgroup, allpointsgroup, bounds, drawnPois, all30thpoints=[], all30thpointsgroup, all10thpointsgroup, all10thpoints=[], idlingDonut = false, trips = [];
var deviceId = $('.device_id').attr('device-id');
var state = 0;
var visible_trips = [];
var tripstable = $('#tripstable').dataTable({
    "sDom": 'ft<"row"<"col-md-5"l><"col-md-7"p>>',
    "info": false,
    "paging": true,
    "aaSorting": [],
    "responsive" : {
        "details": {
            "type": 'column'
        }
    },
    "columnDefs": [
        {
            "className": 'control',
            "orderable": false,
            "targets":   0
        },
        {
            "orderable": false,
            "targets":   1
        }
    ],
    "language":
        {
            "search": translations.search,
            "searchPlaceholder":translations.searchPlaceholder,
            "lengthMenu": translations.lengthMenu,
            "zeroRecords": translations.zeroRecords,
            "info": translations.info,
            "infoEmpty": translations.infoEmpty,
            "infoFiltered": translations.infoFiltered,
            "paginate": {
              "previous": translations.previous,
              "next": translations.next
            }
        }
    });

var generalreportstable = $('#generalreportstable').dataTable({
    "sDom": 'ft<"row"<"col-md-5"l><"col-md-7"p>>',
    "info": false,
    "paging": true,
    "aaSorting": [[0,'desc']],
    "responsive" : {
        "details": {
            "type": 'column'
        }
    },
    "columnDefs": [
        {
            "className": 'control',
            "orderable": false,
            "targets":   0
        },
        { "responsivePriority": 1, "targets": 1 },
        { "responsivePriority": 2, "targets": -1 }
    ],
    "language":
        {
            "search": translations.search,
            "searchPlaceholder":translations.searchPlaceholder,
            "lengthMenu": translations.lengthMenu,
            "zeroRecords": translations.zeroRecords,
            "info": translations.info,
            "infoEmpty": translations.infoEmpty,
            "infoFiltered": translations.infoFiltered,
            "paginate": {
              "previous": translations.previous,
              "next": translations.next
            }
        }
    });
$("#general_reports_trips_list .dataTables_filter").appendTo($(".general_reports_trips_search"));
$("#general_reports_list .dataTables_filter").appendTo($(".general_reports_search"));


var polyColors = new Array("#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565", "#1ab394", "#f8ac59", "#23c6c8", "#1c84c6", "#ed5565");

// var polyColors = ['#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d', '#dc4756', '#14edc1', '#fce652', '#57f7f9', '#1b618d'];

var polyBadges = new Array("danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger", "primary", "warning", "info", "success", "danger");

$(document).ready(function(){

    mapper = app.mapper.load('map', false);
    mapper.toggleFullscreenControl(true);
    mapper.toggleMeasureControl(true);

    mapper.map.on('zoomend', function()
    {
        var zoom = mapper.map.getZoom();
        switch (true) {
            case (0 <= zoom && zoom < 8):
                state = 200;
                break;
            case (8 <= zoom && zoom < 10):
                state = 100;
                break;
            case (10 <= zoom && zoom < 12):
                state = 50;
                break;
            case (12 <= zoom && zoom < 14):
                state = 10;
                break;
            case (14 <= zoom && zoom < 16):
                state = 5;
                break;
            case (16 <= zoom && zoom <= 18):
                state = 2;
                break;
        }
        redrawMotionPoints();
    });

    drawnPois = new L.layerGroup();
    bounds = new L.LatLngBounds();
    // getAddresses('generalreportstable', generalreportstable);

    var switch_elem = document.querySelector('#showpois');
    var switch_init = new Switchery(switch_elem);

    switch_elem.onchange = function() {

        if(switch_elem.checked) {
            loadPois();
        } else {
            hidePois();

            // TODO
            // setTimeout(function()
            // {
            //     mapper.map.fitBounds(bounds, { padding: [50,50] });
            // }, 250);
        }
    };

    // Load Trips on Click
    $(document).on('click', '.change-map-to',function(e)
    {
        // Change button color
        $(".change-map-to").not(this).removeClass('btn-success');
        $(".change-map-to").not(this).addClass('btn-default');

        $(this).removeClass('btn-default');
        $(this).addClass('btn-success');

        e.preventDefault();

        // Get the trip date from the id attribute of the link
        var tripdate = $(this).attr('tripdate');

        // console.log(deviceId);
        loadTrips(tripdate, deviceId);
        reloadStats(tripdate);

        // Scroll to the map
        $('html, body').animate({
            scrollTop: $("#map").offset().top
        }, 700);

    });

    $(document).on('change', '#check_all_trips',function(e)
    {
        if($('#check_all_trips').prop('checked'))
        {
            // Clear all data from map
            clearObjects();
            mapper.clearMarkers();

            // Load all trips
            $("input.trips-visibility", tripstable.fnGetNodes()).each(function(){
                drawTrip(trips[$(this).attr('tripNumber')]['trip'],$(this).attr('tripNumber'));
            });

            tripstable.$('input.trips-visibility').prop('checked', true);
        } else {
            // Clear all data from map
            clearObjects();
            mapper.clearMarkers();
            tripstable.$('input.trips-visibility').prop('checked', false);
        }
    });

    $(document).on('change', "input.trips-visibility", function(e)
    {
        if ($(this).prop('checked'))
        {
            drawTrip(trips[$(this).attr('tripNumber')]['trip'], $(this).attr('tripNumber'));
        }
        else
        {
            removeTripFromMap($(this).attr('tripNumber'));
        }
    });

    // Load first day if exists, if not - load last position
    if($('.change-map-to').first().length)
    {
        $('.change-map-to').first().click();
    }
    else
    {
        addLastLocation();
    }
});

function loadTrips(tripdate, deviceId)
{
    // add spinner while loading
    $("table#tripstable tbody").html("<tr><td colspan='9 text-center'><div class='sk-spinner sk-spinner-three-bounce'><div class='sk-bounce1'></div><div class='sk-bounce2'></div><div class='sk-bounce3'></div></div></td></tr>");

    // Clear all data from map
    clearObjects();
    mapper.clearMarkers();

    // Get trips by day
    requester.get('/reports/general/trips/'+tripdate+'/'+deviceId).then(function (data)
    {
        // Clear table and map before reloading the new trips
        tripstable.fnClearTable();
        var tripNumber = 1;
        trips = [];

        // Iterating the trips
        $.each(data.trips, function(i, trip)
        {
            loadTrip(trip, tripdate, tripNumber);
            tripNumber++;
        });

        // Fit bounds after trip has loaded
        setTimeout(function()
            {
                mapper.map.fitBounds(bounds, { padding: [50, 50] });
            }, 250);

        // Add geoaddresses to columns
        // getAddresses('tripstable', tripstable);
    },
    function (httperror) {

        if(typeof httperror.status != "undefined" && httperror.status == 401) {
            console.log('failed');
            // window.location = "/auth/login?expired=1";
        }
    });
}

function loadTrip(trip, tripdate, tripNumber)
{
    // Undefined variables handling
    if (trip.end_time == null) {
        trip.end_time = "-";
    }

    if (trip.driver == null) {
        trip.driver = "-";
    } else {
        trip.driver = trip.driver.translation[0].first_name + ' ' + trip.driver.translation[0].last_name
    }

    if (trip.translation[0]) {
        trip.start_address = trip.translation[0].start_address;
        trip.end_address = trip.translation[0].end_address;
    } else {
        trip.start_address = '-';
        trip.end_address = '-';
    }

    if (trip.distance == null) {
        trip.distance = '0.0';
    }

    if (trip.distance_can == null) {
        trip.distance = '0.0';
    }


    var row = "";
    drawTrip(trip, tripNumber);

    //Adding row to the trips table
    tripstable.fnAddData([
        null,
        '<input type="checkbox" checked data-tripdate="' + tripdate + '" tripNumber="' + tripNumber + '" class="trips-visibility" />',
        '<span class="badge badge-' + polyBadges[tripNumber] + '">' + tripNumber + '</span>',
        trip.driver,
        toDate(trip.start_time, 'HH:mm') + ' ' + translations.hours,
        toDate(trip.end_time, 'HH:mm') + ' ' + translations.hours,
        getTripTravelTime(trip) + ' ' + translations.hours,
        trip.start_address,
        trip.end_address,
        (parseFloat(trip.distance)).toFixed(1) + ' ' + translations.km,
        (parseFloat(trip.distance_can)).toFixed(1) + ' ' + translations.km
    ]);
}

function drawTrip(trip, tripNumber)
{
    console.log(trip);
    trips[tripNumber] = [];
    trips[tripNumber]['trip'] = trip;
    trips[tripNumber]['motion_points'] = [];
    // trips[tripNumber]['motion_points']['all_points'] = [];
    // trips[tripNumber]['motion_points']['all_points_layer'] = null;
    trips[tripNumber]['motion_points']['every_2th_point'] = [];
    trips[tripNumber]['motion_points']['every_2th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_5th_point'] = [];
    trips[tripNumber]['motion_points']['every_5th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_10th_point'] = [];
    trips[tripNumber]['motion_points']['every_10th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_30th_point'] = [];
    trips[tripNumber]['motion_points']['every_30th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_50th_point'] = [];
    trips[tripNumber]['motion_points']['every_50th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_100th_point'] = [];
    trips[tripNumber]['motion_points']['every_100th_point_layer'] = null;
    trips[tripNumber]['motion_points']['every_200th_point'] = [];
    trips[tripNumber]['motion_points']['every_200th_point_layer'] = null;
    trips[tripNumber]['motion_points_layer'] = null;
    trips[tripNumber]['stop_points'] = [];
    trips[tripNumber]['stop_points_layer'] = null;
    trips[tripNumber]['rest_points'] = [];
    trips[tripNumber]['rest_points_layer'] = null;
    trips[tripNumber]['first_last_points'] = [];
    trips[tripNumber]['first_last_points_layer'] = null;
    trips[tripNumber]['polyline_points'] = [];
    trips[tripNumber]['polyline'] = null;
    trips[tripNumber]['drawn'] = true;

    $.each(trip.gps_events, function(gpsEventNumber, gpsEvent)
    {
        var location = new L.LatLng(gpsEvent.latitude, gpsEvent.longitude);

        // Push location to polyline_points array
        trips[tripNumber]['polyline_points'].push(location);

        bounds.extend(location);
        assignMarker(gpsEventNumber, gpsEvent, tripNumber, trip, location);
    });

    var polyline = new L.Polyline(trips[tripNumber]['polyline_points'], {
        color: polyColors[tripNumber],
        weight: 6,
        opacity: 1,
        smoothFactor: 1
    });


    // Assign label
    var label = "<strong>"+translations.course_number+" "+tripNumber+"</strong><br/>";

    label += translations.tookoff + ": " + toDate(trip.start_time, 'D.MM.YYYY H:mm') + "<br/>";
    label += translations.arrivedat + ": " + toDate(trip.end_time, 'D.MM.YYYY H:mm') + "<br/>";
    label += translations.run + "<sup>" + translations.gps + "</sup>: " + parseFloat(trip.distance).toFixed(1) + " " + translations.km + "<br/>";
    label += translations.run + "<sup>" + translations.can + "</sup>: " + parseFloat(trip.distance_can).toFixed(1) + " " + translations.km + "<br/>";
    label += translations.driver + ": " + trip.driver;


    polyline.bindLabel(label);

    // Add polyline to the global polylines array
    trips[tripNumber]['polyline'] = polyline;

    // Create markers groups from the arrays
    trips[tripNumber]['first_last_points_layer'] = L.layerGroup(trips[tripNumber]['first_last_points']);
    trips[tripNumber]['rest_points_layer'] = L.layerGroup(trips[tripNumber]['rest_points']);
    trips[tripNumber]['stop_points_layer'] = L.layerGroup(trips[tripNumber]['stop_points']);
    // trips[tripNumber]['motion_points']['all_points_layer'] =
    //     L.layerGroup(trips[tripNumber]['motion_points']['all_points']);


    trips[tripNumber]['motion_points']['every_2th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_2th_point']);

    trips[tripNumber]['motion_points']['every_5th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_5th_point']);

    trips[tripNumber]['motion_points']['every_10th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_10th_point']);

    trips[tripNumber]['motion_points']['every_30th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_30th_point']);

    trips[tripNumber]['motion_points']['every_50th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_50th_point']);

    trips[tripNumber]['motion_points']['every_100th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_100th_point']);

    trips[tripNumber]['motion_points']['every_200th_point_layer'] =
        L.layerGroup(trips[tripNumber]['motion_points']['every_200th_point']);

    // Add polyline to map
    mapper.map.addLayer(polyline);

    // Add the points group to the map
    mapper.map.addLayer(trips[tripNumber]['first_last_points_layer']);
    mapper.map.addLayer(trips[tripNumber]['rest_points_layer']);
    mapper.map.addLayer(trips[tripNumber]['stop_points_layer']);


    var zoom = mapper.map.getZoom();
    switch (true) {
        case (0 <= zoom && zoom < 8):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_200th_point_layer']);
            break;
        case (8 <= zoom && zoom < 10):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_100th_point_layer']);
            break;
        case (10 <= zoom && zoom < 12):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_50th_point_layer']);
            break;
        case (12 <= zoom && zoom < 14):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_10th_point_layer']);
            break;
        case (14 <= zoom && zoom < 16):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_5th_point_layer']);
            break;
        case (16 <= zoom && zoom <= 18):
            mapper.map.addLayer(trips[tripNumber]['motion_points']['every_2th_point_layer']);
            break;
    }
}

function removeTripFromMap(tripNumber)
{
    mapper.map.removeLayer(trips[tripNumber]['polyline']);
    mapper.map.removeLayer(trips[tripNumber]['first_last_points_layer']);
    mapper.map.removeLayer(trips[tripNumber]['rest_points_layer']);
    mapper.map.removeLayer(trips[tripNumber]['stop_points_layer']);
    // mapper.map.removeLayer(trips[tripNumber]['motion_points']['all_points_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_2th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_5th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_10th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_30th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_50th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_100th_point_layer']);
    mapper.map.removeLayer(trips[tripNumber]['motion_points']['every_200th_point_layer']);
    trips[tripNumber]['drawn'] = false;
}

function redrawMotionPoints()
{
    if(trips.length > 0)
    {
        for(var n in trips){
            if(trips[n]['drawn'])
            {
                if(state == 200)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_200th_point_layer']);

                }

                if(state == 100)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }

                if(state == 50)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }

                if(state == 30)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }

                if(state == 10)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }

                if(state == 5)
                {
                    mapper.map.removeLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.addLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }

                if(state == 2)
                {
                    mapper.map.addLayer(trips[n]['motion_points']['every_2th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_5th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_10th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_30th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_50th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_100th_point_layer']);
                    mapper.map.removeLayer(trips[n]['motion_points']['every_200th_point_layer']);
                }
            }
        }
    }
}

function assignMarker(gpsEventNumber, gpsEvent, tripNumber, trip, location)
{
    if(gpsEventNumber == 0)
    {
        var firstpoint = new L.Marker(location, {
            icon: begin_trip,
            zIndexOffset: 1300
        });
        firstpoint.bindLabel(createLabel(tripNumber, gpsEvent, trip));
        trips[tripNumber]['first_last_points'].push(firstpoint);
    }
    else if(gpsEventNumber == trip.gps_events.length - 1)
    {
        var lastpoint = new L.Marker(location, {
            icon: end_trip,
            zIndexOffset: 1300
        });
        lastpoint.bindLabel(createLabel(tripNumber, gpsEvent, trip));
        trips[tripNumber]['first_last_points'].push(lastpoint);
    }
    else
    {
        if(gpsEvent.device_status == 'ignition_on_motion')
        {
            var motionpoint = new L.rotatedMarker(location, {
                icon: arrow_move,
                angle: parseInt(gpsEvent.azimuth)
            });

            motionpoint.bindLabel(createLabel(tripNumber, gpsEvent, trip));

            if(gpsEventNumber % 200 == 0)
            {
                trips[tripNumber]['motion_points']['every_200th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 100 == 0)
            {
                trips[tripNumber]['motion_points']['every_100th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 50 == 0)
            {
                trips[tripNumber]['motion_points']['every_50th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 30 == 0)
            {
                trips[tripNumber]['motion_points']['every_30th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 10 == 0)
            {
                trips[tripNumber]['motion_points']['every_10th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 5 == 0)
            {
                trips[tripNumber]['motion_points']['every_5th_point'].push(motionpoint);
            }

            if(gpsEventNumber % 2 == 0)
            {
                trips[tripNumber]['motion_points']['every_2th_point'].push(motionpoint);
            }

            // trips[tripNumber]['motion_points']['all_points'].push(motionpoint);
        }

        if(gpsEvent.device_status == 'ignition_on_rest')
        {
            if(trip.gps_events[gpsEventNumber - 1].device_status != 'ignition_on_rest')
            {
                var restpoint = new L.Marker(location);
                assignIcon(restpoint, gpsEvent.device_status, gpsEvent.azimuth);
                restpoint.bindLabel(createLabel(tripNumber, gpsEvent, trip));
                trips[tripNumber]['rest_points'].push(restpoint);
            }
        }

        if (gpsEvent.device_status == 'ignition_off_rest')
        {
            var stoppoint = new L.marker(location, {
                zIndexOffset: 1200
            });

            assignIcon(stoppoint, gpsEvent.device_status, gpsEvent.azimuth);
            stoppoint.bindLabel(createLabel(tripNumber, gpsEvent, trip));
            trips[tripNumber]['stop_points'].push(stoppoint);
        }

        if( gpsEvent.device_status == 'tow' ||
            gpsEvent.device_status == 'fake_tow' ||
            gpsEvent.device_status == 'ignition_off_motion')
        {
            var towedpoint = new L.Marker(location);
            assignIcon(towedpoint, gpsEvent.device_status, gpsEvent.azimuth);
        }

        if(gpsEvent.device_status == 'sensor_rest')
        {
            var sensorRestPoint = new L.Marker(location);
            assignIcon(sensorRestPoint, gpsEvent.device_status, gpsEvent.azimuth);
        }

        if(gpsEvent.device_status == 'sensor_motion')
        {
            var sensorMotionPoint = new L.Marker(location);
            assignIcon(sensorMotionPoint, gpsEvent.device_status, gpsEvent.azimuth);
        }

        if(gpsEvent.device_status == 'undefined')
        {
            var undefinedPoint = new L.Marker(location);
            assignIcon(undefinedPoint, gpsEvent.device_status, gpsEvent.azimuth);
        }
    }
}

function createLabel(tripNumber, gpsEvent, trip)
{
    return translations.course_number+": <strong>"+tripNumber+"</strong>   |   "+
    translations.time+": <strong>"+toDate(gpsEvent.gps_utc_time, "H:mm")+translations.hours+"</strong><br/>"+
    translations.speed+": <strong>"+
    parseFloat(gpsEvent.speed).toFixed(1)+" "+translations.km_hours+"</strong><br/>"+
    translations.first_movement+": <strong>"+toDate(trip.start_time, 'D.MM.YYYY H:mm')+"</strong>";

}

function reloadStats(tripdate)
{
    tripdate = tripdate.substring(0, tripdate.indexOf('+'));

    var work_hours = $('#report-'+tripdate+' .work_hours').val();
    var move_time = $('#report-'+tripdate+' .move_time').val();
    var stop_time = parseInt(work_hours) - parseInt(move_time);

    if(move_time == '')
    {
        move_time = 0;
    }

    if(work_hours != '')
    {
        var moveTimeValue = parseFloat((move_time*100)/work_hours).toFixed(1);
        var stopTimeValue = parseFloat((stop_time*100)/work_hours).toFixed(1);

        if(!idlingDonut) {

            idlingDonut = Morris.Donut({
                element: 'efective-work',
                data: [
                    {label: translations.motion_hours, value: moveTimeValue },
                    {label: translations.stop_hours, value: stopTimeValue }],
                resize: true,
                colors: ['#87d6c6', '#54cdb4'],
                formatter: function (y, data) { return y + "%" }
            });
        }
        else
        {
            idlingDonut.setData([
                {label: translations.motion_hours, value: moveTimeValue },
                {label: translations.stop_hours, value: stopTimeValue }
            ]);
        }
    }

}

function clearObjects()
{
    for(var n in trips)
    {
        removeTripFromMap(n);
    }
}

function getTripTravelTime(trip)
{
    var start_time = moment(trip.start_time.date);
    var end_time = moment(trip.end_time.date);

    var milliseconds = moment.duration(end_time.diff(start_time));
    var duration = moment.duration(milliseconds, "milliseconds")
        .format("hh:mm", { trim: false });

   return duration;
}

function  toDate(date, format)
{
    var localTime  = moment(date.date).toDate();
    localTime = moment(localTime).format(format);
    return localTime;
}

function toMinutes(seconds)
{
    return moment.duration(seconds, "seconds").format("hh:mm", { trim: false });
}

L.RotatedMarker = L.Marker.extend({
    options: {
        angle: 0
    },
    statics: {
        // determine the best and only CSS transform rule to use for this browser
        bestTransform: L.DomUtil.testProp([
            'transform',
            'WebkitTransform',
            'msTransform',
            'MozTransform',
            'OTransform'
        ])
    },
    _setPos: function (pos) {
        L.Marker.prototype._setPos.call(this, pos);

        var rotate = ' rotate(' + this.options.angle + 'deg)';
        if (L.RotatedMarker.bestTransform) {
            // use the CSS transform rule if available
            this._icon.style[L.RotatedMarker.bestTransform] += rotate;
        } else if(L.Browser.ie) {
            // fallback for IE6, IE7, IE8
            var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
                costheta = Math.cos(rad),
                sintheta = Math.sin(rad);
            this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
                costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
        }
    }
});

L.rotatedMarker = function (pos, options) {
    return new L.RotatedMarker(pos, options);
};

function getAddresses(tablename, tableobject)
{
    var locale = $('.data-locale').data('locale');
    $(tableobject.fnGetNodes()).each(function(n, tr){
        $(tr).find('.coord-address').each(function(p, coordAddress)
        {
            var lat = parseFloat($(coordAddress).find('.lat-lng .lat').html());
            var lng = parseFloat($(coordAddress).find('.lat-lng .lng').html());

            var url = 'http://nominatim.openstreetmap.org/reverse?json_callback=?&accept-language='+locale+')';

            $.getJSON( url, {
                format: "json",
                lat: lat,
                lon: lng,
                zoom: 27,
                addressdetails: 1
            })
            .done(function( json )
            {

                var pos = tableobject.fnGetPosition( coordAddress );
                // Update the data array and return the value
                tableobject.fnUpdate(json.address.road+', '+json.address.city+', '+json.address.country, pos[0], pos[1]);
            })
            .fail(function( jqxhr, textStatus, error ) {
                var err = textStatus + ", " + error;
                console.log( "Request Failed: " + err );
                $(coordAddress).find('.address').html('Unknown');
            });
        });
    });
}


function addLastLocation()
{
    requester.get('/reports/general/lastEvent/'+deviceId).then(function (data)
    {
        var lastEvent = data.lastEvent;
        if(lastEvent != null)
        {
            var latLng = new L.LatLng(lastEvent.latitude, lastEvent.longitude);

            mapper.addMarker(latLng);
            bounds.extend(latLng);

            setTimeout(function()
            {
                mapper.map.fitBounds(bounds, { padding: [50, 50] });
            }, 250);
        }
    },
    function (httperror) {

        if(typeof httperror.status != "undefined" && httperror.status == 401) {
            console.log('failed lastEvent');
            // window.location = "/auth/login?expired=1";
        }
    });
}

});
