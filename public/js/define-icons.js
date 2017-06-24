
/**
 * Define icons
 */

// Moving_east
var move_e = L.icon({
    iconUrl: '/leaflet/images/markers/move_e.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_north
var move_n = L.icon({
    iconUrl: '/leaflet/images/markers/move_n.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_north_east
var move_ne = L.icon({
    iconUrl: '/leaflet/images/markers/move_ne.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_north_west
var move_nw = L.icon({
    iconUrl: '/leaflet/images/markers/move_nw.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_south
var move_s = L.icon({
    iconUrl: '/leaflet/images/markers/move_s.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_south_east
var move_se = L.icon({
    iconUrl: '/leaflet/images/markers/move_se.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_south_west
var move_sw = L.icon({
    iconUrl: '/leaflet/images/markers/move_sw.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_west
var move_w = L.icon({
    iconUrl: '/leaflet/images/markers/move_w.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Moving_no_signal
var move_no_signal = L.icon({
    iconUrl: '/leaflet/images/markers/move_no_signal.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Stopped
var stopped = L.icon({
    iconUrl: '/leaflet/images/markers/stop.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Stopped_engine_on
var stopped_engine_on = L.icon({
    iconUrl: '/leaflet/images/markers/stop_eng_on.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Stopped_no_signal
var stopped_no_signal = L.icon({
    iconUrl: '/leaflet/images/markers/stop_no_signal.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Towed
var towed = L.icon({
    iconUrl: '/leaflet/images/markers/towed.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Arrow_move
var arrow_move = L.icon({
    iconUrl: '/leaflet/images/markers/arr_move.png',
    iconSize:     [14, 14],
    iconAnchor:   [7, 7],
    popupAnchor:  [0, -17],
    labelAnchor:  [3, 0]
});

// Arrow_tow
var arrow_tow = L.icon({
    iconUrl: '/leaflet/images/markers/arr_tow.png',
    iconSize:     [14, 14],
    iconAnchor:   [7, 7],
    popupAnchor:  [0, -17],
    labelAnchor:  [3, 0]
});

// Arrow_white
var arrow_white = L.icon({
    iconUrl: '/leaflet/images/markers/arr_white.png',
    iconSize:     [14, 14],
    iconAnchor:   [7, 7],
    popupAnchor:  [0, -17],
    labelAnchor:  [3, 0]
});

// Violated speed
var speed_violated = L.icon({
    iconUrl: '/leaflet/images/markers/speed_violated.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Begin trip
var begin_trip = L.icon({
    iconUrl: '/leaflet/images/markers/begin_trip.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// End trip
var end_trip = L.icon({
    iconUrl: '/leaflet/images/markers/end_trip.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

// Undefined
var undefined_pin = L.icon({
    iconUrl: '/leaflet/images/markers/undefined.png',
    iconSize:     [31, 40],
    iconAnchor:   [15.5, 40],
    popupAnchor:  [-2, -39],
    labelAnchor:  [5, -26]
});

function assignIcon(marker, status, azimuth)
{
    if(status == 'ignition_on_rest')
    {
        marker.setIcon(stopped_engine_on);
    }

    if(status == 'ignition_on_motion')
    {
        marker.setIcon(getIconByAzimuth(azimuth));
    }

    if(status == 'ignition_off_rest')
    {
        marker.setIcon(stopped);
    }

    if(status == 'ignition_off_motion')
    {
        marker.setIcon(towed);
    }

    if(status == 'tow' || status == 'fake_tow')
    {
        marker.setIcon(towed);
    }

    if(status == 'sensor_rest')
    {
        marker.setIcon(stopped_no_signal);
    }

    if(status == 'sensor_motion')
    {
        marker.setIcon(move_no_signal);
    }

    if(status == 'undefined' || status == null)
    {
        marker.setIcon(move_n);
    }

    return marker;
}

function getIconByAzimuth(azimuth)
{
    var icon = null;

    if((azimuth >= 0 && azimuth < 67.7) || (azimuth > 337,5 && azimuth <= 359))
    {
        icon = move_n;
    }

    if(azimuth > 22.5 && azimuth < 67.5)
    {
        icon = move_ne;
    }

    if(azimuth > 67.5 && azimuth < 112.5)
    {
        icon = move_e;
    }

    if(azimuth > 112.5 && azimuth < 157.5)
    {
        icon = move_se;
    }

    if(azimuth > 157.5 && azimuth < 202.5)
    {
        icon = move_s;
    }

    if(azimuth > 202.5 && azimuth < 247.5)
    {
        icon = move_sw;
    }

    if(azimuth > 247.5 && azimuth < 292.5)
    {
        icon = move_w;
    }

    if(azimuth > 292.5 && azimuth < 337.5)
    {
        icon = move_nw;
    }

    return icon;
}

//# sourceMappingURL=define-icons.js.map
