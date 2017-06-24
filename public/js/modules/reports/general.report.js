$(function() {

var map, bounds, drawnPois, trip = [];
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

$(document).ready(function(){

    mapper = app.mapper.load('map', false);
    mapper.toggleFullscreenControl(true);
    mapper.toggleMeasureControl(true);

    drawnPois = new L.layerGroup();
    bounds = new L.LatLngBounds();

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

        loadTrip(tripdate, deviceId);

        // Scroll to the map
        $('html, body').animate({
            scrollTop: $("#map").offset().top
        }, 700);

    });

    // Load first day if exists, if not - load last position
    console.log($('.change-map-to').first().length);
    if($('.change-map-to').first().length)
    {
        $('.change-map-to').first().click();
    }
    else
    {
        addLastLocation();
    }
});

function loadTrip(tripdate, deviceId)
{
    // Clear all data from map
    removeTripFromMap();
    mapper.clearMarkers();

    // Get trips by day
    requester.get('/reports/general/trips/'+tripdate+'/'+deviceId).then(function (data)
    {
        drawTrip(data.events);

        // Fit bounds after trip has loaded
        setTimeout(function()
            {
                mapper.map.fitBounds(bounds, { padding: [50, 50] });
            }, 250);
    },
    function (httperror) {

        if(typeof httperror.status != "undefined" && httperror.status == 401) {
            console.log('failed');
            // window.location = "/auth/login?expired=1";
        }
    });
}

function drawTrip(events)
{
    trip = [];
    trip['polyline_points'] = [];
    trip['polyline'] = null;
    trip['first_last_points'] = [];
    trip['first_last_points_layer'] = null;
    trip['drawn'] = true;

    $.each(events, function(gpsEventNumber, gpsEvent)
    {
        var location = new L.LatLng(gpsEvent.latitude, gpsEvent.longitude);

        // Push location to polyline_points array
        trip['polyline_points'].push(location);
        bounds.extend(location);
        assignMarker(gpsEventNumber, trip, location, events, gpsEvent);
    });

    var polyline = new L.Polyline(trip['polyline_points'], {
        color: "#ed5565",
        weight: 6,
        opacity: 1,
        smoothFactor: 1
    });

    // Add polyline to the global polylines array
    trip['polyline'] = polyline;

    // Create markers groups from the arrays
    trip['first_last_points_layer'] = L.layerGroup(trip['first_last_points']);
    // Add polyline to map
    mapper.map.addLayer(polyline);

    // Add the points group to the map
    mapper.map.addLayer(trip['first_last_points_layer']);
}

function removeTripFromMap()
{
    if (trip['polyline'] != undefined) {
        mapper.map.removeLayer(trip['first_last_points_layer']);
        mapper.map.removeLayer(trip['polyline']);
        trip['drawn'] = false;
    }
}

function assignMarker(gpsEventNumber, trip, location, events, gpsEvent)
{
    if(gpsEventNumber == 0)
    {
        var firstpoint = new L.Marker(location, {
            icon: begin_trip,
            zIndexOffset: 1300
        });
        getAddresses(gpsEvent.latitude, gpsEvent.longitude, firstpoint);
        trip['first_last_points'].push(firstpoint);
    }
    else if(gpsEventNumber == events.length - 1)
    {
        var lastpoint = new L.Marker(location, {
            icon: end_trip,
            zIndexOffset: 1300
        });
        getAddresses(gpsEvent.latitude, gpsEvent.longitude, lastpoint);
        trip['first_last_points'].push(lastpoint);
    }
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

function getAddresses(latitude, longitude, point)
{
    var lat = parseFloat(latitude);
    var lng = parseFloat(longitude);

    var url = 'http://nominatim.openstreetmap.org/reverse?json_callback=?&accept-language=en)';

    $.getJSON( url, {
        format: "json",
        lat: lat,
        lon: lng,
        zoom: 27,
        addressdetails: 1
    })
    .done(function( json )
    {
        // Update the data array and return the value
        point.bindLabel(json.display_name);
    })
    .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        console.log( "Request Failed: " + err );
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

            mapper.addMarker(latLng, {icon:stopped_no_signal});
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

//# sourceMappingURL=general.report.js.map
