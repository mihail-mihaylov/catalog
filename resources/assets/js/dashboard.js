var app = app || {};
var mapper = undefined;
var bounds, markers = [], tempMarkers = [], markergroup, followmarker = false, popup, popupcontent, firstiteration=1;
var devicesTable = $('#devicesTable').dataTable({
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
        { "responsivePriority": 1, "targets": 1 },
        { "responsivePriority": 2, "targets": 4 }
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
var devicesTableApi = devicesTable.api();


$("#dashboard_devices_list .dataTables_filter").appendTo($(".dashboard_devices_search"));

// Locations refresh rate (milliseconds)
var locationsrefreshrate = 8000;  // 8s

$(document).ready(function() {

    mapper = app.mapper.load('map', false);
    mapper.toggleFullscreenControl(true);
    mapper.toggleMeasureControl(true);

    popup = new L.Popup({
        offset: new L.Point(-5, -30),
        'maxWidth': '350',
        'className' : 'custom-popup'
    });

    /*
     * Initial data load
     */
    bounds = new L.LatLngBounds();

    reloadLocations(1);

    // When we click somewhere on the map
    mapper.map.on('click', function(){

       // Stop following a marker
       followmarker = false;

       // Close the popup
       // mapper.map.closePopup(popup);
    });

    // When we drag the map
    mapper.map.on('dragstart', function(){

       // Stop following a marker
       followmarker = false;
       // mapper.map.closePopup(popup);
    });

    /*
     * Follow a car buttons action
     */
    $(document).delegate('.follow-device', 'click', function(e)
    {
        e.preventDefault();

        // Scroll to the map
        window.scrollTo(0, 100);

        // Start following a marker
        followmarker = $(this).data('device-id');

        var mapmarker = getMarker(followmarker);

        if(mapmarker)
        {
            // popup.setContent(mapmarker.pop);
            // popup.setLatLng(mapmarker.getLatLng());
            // mapper.map.openPopup(popup);

            // Center the map to the chosen vehicle
            mapper.map.panTo(mapmarker.getLatLng());
        }
        // followdevice($(this).attr('device-id'), mapmarker);
    });

    /*
     * Fit points in map button action
     */
    $(document).delegate('#fit-points', 'click', function(e)
    {
        e.preventDefault();

        // Stop following a marker
        followmarker = false;

        // Close the popup
        // mapper.map.closePopup(popup);

        setTimeout(function()
        {
            mapper.map.fitBounds(bounds, {padding: [50, 50]});
        }, 100);

        if(markers.length < 2)
        {
            mapper.map.setZoom(mapper.map.getZoom() - 5);
        }

    });

    // Refresh data every 8 seconds
    locationsreloadtimer = setInterval(reloadLocations, locationsrefreshrate);
    // statisticsreloadtimer = setInterval(reloadStatistics, statisticsrefreshrate);

}); // end document ready

function followdevice(deviceId, mapMarker)
{
    followmarker = deviceId;

    if(mapmarker)
    {
        // mapper.map.openPopup(popup);

        // Center the map to the chosen vehicle
        mapper.map.panTo(mapmarker.getLatLng());
    }
}

function reloadLocations(initial)
{
    bounds = new L.LatLngBounds();
    requester.post('dashboard/json/getLastData').then(function (data)
    {
        if(data.devicesLastData.length != 0)
        {
            // Iterate devices
            $.each(data.devicesLastData, function(i, device)
            {
                if(device.last_gps_event_id &&
                    device.last_gps_event.latitude != null &&
                    device.last_gps_event.longitude != null &&
                    device.last_gps_event.latitude != 0 &&
                    device.last_gps_event.longitude != 0)
                {
                    var location = new L.LatLng(device.last_gps_event.latitude, device.last_gps_event.longitude);
                    var popupcontent = null;//loadPopupInfo(i, device);

                    bounds.extend(location);
                    device.last_gps_event['azimuth'] = 200;
                    device.last_gps_event['device_status'] = 'ignition_on_motion';
                    assignMarker(i, device, location, popupcontent);
                }

                // Modify devices  table row
                updateDeviceTableRow(device);
            });
        }

        // Store markers in a layerGroup
        markergroup = L.layerGroup(markers);

        // Add the markers layerGroup to map
        mapper.map.addLayer(markergroup);

        // Fit bounds on initial load
        if(initial == 1)
        {
            mapper.map.fitBounds(bounds, {padding: [50, 50]});
        }
    },
    function (httperror) {

        if(typeof httperror.status != "undefined" && httperror.status == 401) {
            console.log('failed');
            // window.location = "/auth/login?expired=1";
        }
    });
}

function updateDeviceTableRow(device)
{
    var row = devicesTableApi.row('tr.device-'+device.id).node();
    var actions = '<a href="#" data-device-id="'+device.id+'" class="btn btn-xs btn-info follow-device"><i class="fa fa-map-marker"></i> ' + translations.view_on_map + '</a> ';
    var last_communication_cell = 3;

    if ($(devicesTableApi.rows().nodes()).filter('tr.device-' + device.id).length == 1)
    {
        if (device.last_gps_event != null)
        {
            actions += '<a href="https://maps.google.com/?cbll=' + trackedObject.last_gps_event.latitude + ',' + trackedObject.last_gps_event.longitude + '&cbp=12,,0,0,10&layer=c" class="btn btn-xs btn-success streetview-link" target="_blank"><i class="fa fa-eye"></i> ' + translations.view_on_street_view;

            // Update row's actions
            devicesTableApi
                .cell(row, 4)
                .data(actions);

            // Streetview link
            $('tr.device-' + device.id).find('a.streetview-link').attr('href', "https://maps.google.com/?cbll=" + device.last_gps_event.latitude + "," + device.last_gps_event.longitude + "&cbp=12,,,0,5&layer=c");
        }

        if (device.last_gps_event != null) {

            // Update row's last communication field
            devicesTableApi
                .cell(row, last_communication_cell)
                .data('<span class="badge" >' + toDate(device.last_gps_event.gps_utc_time, 'HH:mm / DD.MM.YYYY') + '</span>');
        }
        else
        {
            devicesTableApi
                .cell(row, last_communication_cell)
                .data(translations.no_data);
        }
    }
}

function assignMarker(i, device, location, popupcontent)
{
    if(device.last_gps_event.latitude != 0.00 || device.last_gps_event.longitude != 0.00) {

        var existingMarker = getMarker(device.id);

        if (existingMarker != false)
        {
            updateMarker(existingMarker, device, popupcontent);
        }
        else // Marker does not exist so create it
        {
            createMarker(device, location, popupcontent);
        }
    }
}

function updateMarker(existingMarker, device, popupcontent)
{
    // Update position
    existingMarker.setLatLng([device.last_gps_event.latitude, device.last_gps_event.longitude]).update();

    // Update icon
    assignIcon(existingMarker, device.last_gps_event.device_status, device.last_gps_event.azimuth);

    // Update popupcontent
    // existingMarker.pop = popupcontent;

    // Update opened popup
    if(followmarker && followmarker == device.id)
    {
        // popup.setLatLng([device.last_gps_event.latitude, device.last_gps_event.longitude]);
        // popup.setContent(popupcontent);

        // mapper.map.openPopup(popup);
        mapper.map.panTo(existingMarker.getLatLng());

    }
}

function createMarker(device, location, popupcontent)
{
    // Create marker
    var marker =  new L.Marker(location);

    // Set icon for the new marker
    assignIcon(marker, device.last_gps_event.device_status, device.last_gps_event.azimuth);

    // Set device_id as key for marker
    marker.key = device.id;

    // Set popupcontent
    // marker.pop = popupcontent;

    // Set label for the new marker
    marker.bindLabel(device.identification_number);

    // Add marker to markers array
    markers.push(marker);

    // Set click event for newly created marker
    marker.on('click', function(e)
    {
        // popup.setContent(e.target.pop);
        // popup.setLatLng(e.latlng);
        // mapper.map.openPopup(popup);
        mapmarker = getMarker(device.id);
        followdevice(device.id, mapmarker);
    });

}

function loadPopupInfo(i, device)
{
    var today_date_string = moment().format('YYYY-MM-DD');
    var todayLastDateWithHour = moment().format('YYYY-MM-DD') + ' 23:59:59';
    var yesterday_date_string = moment().subtract(1, 'days').format('YYYY-MM-DD');
    var yesterdayLastDateWithHour = moment().subtract(1, 'days').format('YYYY-MM-DD') + ' 23:59:59';

    var subdetails = "";

    if(device.last_gps_event.start_time != null) {
        subdetails = "<td><i class='glyphicon glyphicon-play'></i> "+translations.took_off_at+": </td><td colspan='2'>"+toDate(device.start_time, 'HH:mm')+"</td>";
    }
    else
    {
        subdetails = "<td><i class='glyphicon glyphicon-play'></i> "+translations.took_off_at+": </td><td colspan='2'>"+translations.no_data+"</td>";
    }

    if(device.last_gps_event.end_time != null) {
        subdetails = "<td><i class='glyphicon glyphicon-pause'></i> "+translations.stopped_at+": </td><td colspan='2'>"+toDate(device.end_time, 'HH:mm')+"</td>";
    }

    var enginestatus = "";

    if(device.last_gps_event.device_status == 'ignition_on_motion' || device.last_gps_event.device_status == 'ignition_on_rest')
    {
        enginestatus = translations.engine_on;
    }
    else
    {
        enginestatus = translations.engine_off;
    }

    var driverstatus = "";

    if(device.last_gps_event.driver != null)
    {
        driverstatus = "<td><i class='fa fa-truck'></i> "+translations.driver+":</td><td colspan='2'><strong>"+device.last_gps_event.driver+"</strong></td>";
    } else {

        driverstatus = "<td><i class='fa fa-truck'></i> "+translations.driver+":</td><td colspan='2'><strong> "+translations.unknown_driver+" </strong></td>";
    }

    var quickactions = translations.general_report +
                       "&nbsp;<a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       device.id +
                       "&hiddenLastDate=" +
                       todayLastDateWithHour +
                       "&driver=&lastDate=" +
                       today_date_string +
                       "&periodInput=1'>" +
                       translations.report_today +
                       "</a><a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       device.device_id +
                       "&hiddenLastDate=" +
                       yesterdayLastDateWithHour +
                       "&driver=&lastDate=" +
                       yesterday_date_string +
                       "&periodInput=1'>" +
                       translations.report_yesterday +
                       "</a><a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       device.device_id +
                       "&hiddenLastDate=" +
                       todayLastDateWithHour +
                       "&driver=&lastDate=" +
                       today_date_string +
                       "&periodInput=7'>" +
                       translations.report_seven_days+"</a>";

    return "<div class='ibox' style='margin:0'><div class='ibox-title-custom'><strong>"+device.name+" ("+device.identification_number+")</strong></div><div class='ibox-content no-padding'><table class='popup-table'><tr><td><i class='fa fa-dashboard'></i> "+Math.round(device.speed)+" "+translations.km_hours+"</td><td><i class='fa fa-rss'></i> 24</td><td><i class='fa fa-plug'></i> "+enginestatus+"</td></tr><tr>"+subdetails+"</tr><tr>"+driverstatus+"</tr></table></div><div class='ibox-footer ibox-footer-fix'>"+quickactions+"</div></div>";
}

function getMarker(deviceId)
{
    for(var i in markers)
    {
        if(markers[i].key == deviceId){
            return markers[i];
        }
    }
    return false;
}

function  toDate(date, format)
{
    // var localTime  = moment(date).toDate();
    var localTime = moment(date.date).format(format);
    return localTime;
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


