var app = app || {};
var mapper = undefined;
var bounds, markers = [], tempMarkers = [], markergroup, followmarker = false, popup, popupcontent, firstiteration=1;
var trackedObjectsTable = $('#trackedObjectsTable').dataTable({
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
var trackedObjectsTableApi = trackedObjectsTable.api();


$("#dashboard_tracked_objects_list .dataTables_filter").appendTo($(".dashboard_tracked_objects_search"));

// Locations refresh rate (milliseconds)
var locationsrefreshrate = 8000;  // 8s
var statisticsrefreshrate = 30000; // 30s


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
    // reloadStatistics(1);

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
            // Iterate tracked Objects
            $.each(data.devicesLastData, function(i, trackedObject)
            {
                if(trackedObject.last_gps_event_id && 
                    trackedObject.last_gps_event.latitude != null &&
                    trackedObject.last_gps_event.longitude != null &&
                    trackedObject.last_gps_event.latitude != 0 &&
                    trackedObject.last_gps_event.longitude != 0)
                {
                    var location = new L.LatLng(trackedObject.last_gps_event.latitude, trackedObject.last_gps_event.longitude);
                    var popupcontent = null;//loadPopupInfo(i, trackedObject);

                    bounds.extend(location);
                    assignMarker(i, trackedObject, location, popupcontent);
                }

                // Modify tracked objects table row
                updateTrackedObjectTableRow(trackedObject);
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

function updateTrackedObjectTableRow(trackedObject)
{
    var row = trackedObjectsTableApi.row('tr.trackedObject-'+trackedObject.id).node();
    var actions = '<a href="#" data-device-id="'+trackedObject.id+'" class="btn btn-xs btn-info follow-device"><i class="fa fa-map-marker"></i> ' + translations.view_on_map + '</a> ';
    var last_communication_cell = 3;

    if ($(trackedObjectsTableApi.rows().nodes()).filter('tr.trackedObject-' + trackedObject.id).length == 1)
    {
        if (trackedObject.last_gps_event != null)
        {
            // Check for module 'trains'
            // if (trackedObject.readTrain) {
            //     actions += ' <button class="manage_train btn btn-xs btn-success" data-id="' + trackedObject.tracked_object_id + '" data-title="' + translations.manage_train + '" data-action="' + location.protocol + '//' + location.hostname + '/trains/' + trackedObject.tracked_object_id + '/manage" data-get><i class="fa fa-pencil-square-o"></i> ' + translations.manage_train + '</button> ';

            //     last_communication_cell = 4;

            //     // Update row's speed
            //     // trackedObjectsTableApi
            //     //     .cell(row, 3)
            //     //     .data(parseFloat(trackedObject.speed).toFixed(0) + ' ' + translations.km_hours);

            //     // Update train name
            //     // trackedObjectsTableApi
            //     //     .cell(row, 5)
            //     //     .data(trackedObject.train_name ? trackedObject.train_name : '-');

            //     // Update train role
            //     // trackedObjectsTableApi
            //     //     .cell(row, 6)
            //     //     .data(trackedObject.train_role ? trackedObject.train_role : '-');

            //     // Update driver
            //     // trackedObjectsTableApi
            //     //     .cell(row, 7)
            //     //     .data(trackedObject.driver ? trackedObject.driver : '-');
            // } else {
            //     actions += '<a href="https://maps.google.com/?cbll=' + trackedObject.last_gps_event.latitude + ',' + trackedObject.last_gps_event.longitude + '&cbp=12,' + trackedObject.last_gps_event.azimuth + ',0,0,10&layer=c" class="btn btn-xs btn-success streetview-link" target="_blank"><i class="fa fa-eye"></i> ' + translations.view_on_street_view;

            //     // Update row's status
            //     // trackedObjectsTableApi
            //     //     .cell(row, 3)
            //     //     .data(translations[trackedObject.last_gps_event.device_status]);

            //     // Update row's speed
            //     // trackedObjectsTableApi
            //     //     .cell(row, 4)
            //     //     .data(parseFloat(trackedObject.speed).toFixed(0) + ' ' + translations.km_hours);
            // }

            // Update row's actions
            trackedObjectsTableApi
                .cell(row, 4)
                .data(actions);

            // Streetview link
            $('tr.trackedObject-' + trackedObject.id).find('a.streetview-link').attr('href', "https://maps.google.com/?cbll=" + trackedObject.last_gps_event.latitude + "," + trackedObject.last_gps_event.longitude + "&cbp=12," + trackedObject.last_gps_event.azimuth + ",,0,5&layer=c");
        }

        if (trackedObject.last_gps_event != null) {
            var communication = moment(toDate(trackedObject.last_gps_event.gps_utc_time, 'YYYY-MM-DD HH:mm'));
            var now = moment();
            var diff = now.diff(communication, 'minutes');
            var badge = 'badge-danger';

            if (diff <= 5) {
                badge = 'badge-primary';
            } else if (diff > 5 && diff < 60) {
                badge = 'badge-warning';
            }

            // Update row's last communication field
            trackedObjectsTableApi
                .cell(row, last_communication_cell)
                .data('<span class="badge ' + badge + '" >' + toDate(trackedObject.last_gps_event.gps_utc_time, 'HH:mm / DD.MM.YYYY') + '</span>');
        }
        else
        {
            trackedObjectsTableApi
                .cell(row, last_communication_cell)
                .data(translations.no_data);
        }
    }
}

function assignMarker(i, trackedObject, location, popupcontent)
{
    if(trackedObject.last_gps_event.latitude != 0.00 || trackedObject.last_gps_event.longitude != 0.00) {

        var existingMarker = getMarker(trackedObject.id);

        if (existingMarker != false)
        {
            updateMarker(existingMarker, trackedObject, popupcontent);
        }
        else // Marker does not exist so create it
        {
            createMarker(trackedObject, location, popupcontent);
        }
    }
}

function updateMarker(existingMarker, trackedObject, popupcontent)
{
    // Update position
    existingMarker.setLatLng([trackedObject.last_gps_event.latitude, trackedObject.last_gps_event.longitude]).update();

    // Update icon
    assignIcon(existingMarker, trackedObject.last_gps_event.device_status, trackedObject.last_gps_event.azimuth);

    // Update popupcontent
    // existingMarker.pop = popupcontent;

    // Update opened popup
    if(followmarker && followmarker == trackedObject.id)
    {
        // popup.setLatLng([trackedObject.last_gps_event.latitude, trackedObject.last_gps_event.longitude]);
        // popup.setContent(popupcontent);

        // mapper.map.openPopup(popup);
        mapper.map.panTo(existingMarker.getLatLng());

    }
}

function createMarker(trackedObject, location, popupcontent)
{
    // Create marker
    var marker =  new L.Marker(location);

    // Set icon for the new marker
    assignIcon(marker, trackedObject.last_gps_event.device_status, trackedObject.last_gps_event.azimuth)

    // Set device_id as key for marker
    marker.key = trackedObject.id;

    // Set popupcontent
    // marker.pop = popupcontent;

    // Set label for the new marker
    marker.bindLabel(trackedObject.identification_number);

    // Add marker to markers array
    markers.push(marker);

    // Set click event for newly created marker
    marker.on('click', function(e)
    {
        // popup.setContent(e.target.pop);
        // popup.setLatLng(e.latlng);
        // mapper.map.openPopup(popup);
        mapmarker = getMarker(trackedObject.id);
        followdevice(trackedObject.id, mapmarker);
    });

}

function loadPopupInfo(i, trackedObject)
{
    var today_date_string = moment().format('YYYY-MM-DD');
    var todayLastDateWithHour = moment().format('YYYY-MM-DD') + ' 23:59:59';
    var yesterday_date_string = moment().subtract(1, 'days').format('YYYY-MM-DD');
    var yesterdayLastDateWithHour = moment().subtract(1, 'days').format('YYYY-MM-DD') + ' 23:59:59';

    var subdetails = "";

    if(trackedObject.last_gps_event.start_time != null) {
        subdetails = "<td><i class='glyphicon glyphicon-play'></i> "+translations.took_off_at+": </td><td colspan='2'>"+toDate(trackedObject.start_time, 'HH:mm')+"</td>";
    }
    else
    {
        subdetails = "<td><i class='glyphicon glyphicon-play'></i> "+translations.took_off_at+": </td><td colspan='2'>"+translations.no_data+"</td>";
    }

    if(trackedObject.last_gps_event.end_time != null) {
        subdetails = "<td><i class='glyphicon glyphicon-pause'></i> "+translations.stopped_at+": </td><td colspan='2'>"+toDate(trackedObject.end_time, 'HH:mm')+"</td>";
    }

    var enginestatus = "";

    if(trackedObject.last_gps_event.device_status == 'ignition_on_motion' || trackedObject.last_gps_event.device_status == 'ignition_on_rest')
    {
        enginestatus = translations.engine_on;
    }
    else
    {
        enginestatus = translations.engine_off;
    }

    var driverstatus = "";

    if(trackedObject.last_gps_event.driver != null)
    {
        driverstatus = "<td><i class='fa fa-truck'></i> "+translations.driver+":</td><td colspan='2'><strong>"+trackedObject.last_gps_event.driver+"</strong></td>";
    } else {

        driverstatus = "<td><i class='fa fa-truck'></i> "+translations.driver+":</td><td colspan='2'><strong> "+translations.unknown_driver+" </strong></td>";
    }

    var quickactions = translations.general_report +
                       "&nbsp;<a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       trackedObject.id +
                       "&hiddenLastDate=" +
                       todayLastDateWithHour +
                       "&driver=&lastDate=" +
                       today_date_string +
                       "&periodInput=1'>" +
                       translations.report_today +
                       "</a><a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       trackedObject.device_id +
                       "&hiddenLastDate=" +
                       yesterdayLastDateWithHour +
                       "&driver=&lastDate=" +
                       yesterday_date_string +
                       "&periodInput=1'>" +
                       translations.report_yesterday +
                       "</a><a class='btn btn-custom btn-xs' href='/reports/general/report?deviceId=" +
                       trackedObject.device_id +
                       "&hiddenLastDate=" +
                       todayLastDateWithHour +
                       "&driver=&lastDate=" +
                       today_date_string +
                       "&periodInput=7'>" +
                       translations.report_seven_days+"</a>";

    return "<div class='ibox' style='margin:0'><div class='ibox-title-custom'><strong>"+trackedObject.name+" ("+trackedObject.identification_number+")</strong></div><div class='ibox-content no-padding'><table class='popup-table'><tr><td><i class='fa fa-dashboard'></i> "+Math.round(trackedObject.speed)+" "+translations.km_hours+"</td><td><i class='fa fa-rss'></i> 24</td><td><i class='fa fa-plug'></i> "+enginestatus+"</td></tr><tr>"+subdetails+"</tr><tr>"+driverstatus+"</tr></table></div><div class='ibox-footer ibox-footer-fix'>"+quickactions+"</div></div>";
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
    console.log(date);
    // var localTime  = moment(date).toDate();
    var localTime = moment(date.date).format(format);
    return localTime;
}


function reloadStatistics(initial)
{
    var start = $('#hidden_date_day_start').val();
    var end   = $('#hidden_date_day_end').val();
    
    var payload = { start : start, end : end };
    
    requester.post('dashboard/json/getDailyToStatistics', null, payload).then(
    function (data)
    {
        if(data.dailyToStatistics.length != 0)
        {
            $.each(data.dailyToStatistics, function(n, trackedObject)
            {
                if( $(trackedObjectsTableApi.rows().nodes()).filter('tr.trackedObject-' + trackedObject.device_id).length == 1 )
                {
                    var row = trackedObjectsTableApi.row('tr.trackedObject-'+trackedObject.device_id).node();
                    // Check for module 'trains'
                    if (trackedObject.readTrain) {
                        var data = '';
                        $.each(trackedObject, function(param, value) {
                            if (jQuery.inArray( param, ['readTrain', 'device_id'] ) == -1) {
                                data += param + ': ' + value + '<br /><br />';
                            }
                        });
                        // Update row's digital inputs
                        trackedObjectsTableApi
                            .cell(row, 8)
                            .data(data);
                    } else {
                        // Update row's max speed
                        trackedObjectsTableApi
                            .cell(row, 6)
                            .data(parseFloat(trackedObject.max_speed).toFixed(0) + ' ' + translations.km_hours);

                        // Update row's daily distance
                        trackedObjectsTableApi
                            .cell(row, 7)
                            .data(parseFloat(trackedObject.daily_distance).toFixed(0) + ' ' + translations.km);

                        // Update row's daily distance can
                        trackedObjectsTableApi
                            .cell(row, 8)
                            .data(parseFloat(trackedObject.daily_distance_can).toFixed(0) + ' ' + translations.km);
                    }
                }
            });
        }

    },
    function (httperror)
    {
        console.log('fail');
    });
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


