var app = app || {};
var violationNotificationMapper = undefined;

$(document).ready(function()
{
    var requester = app.requester.load();
});

$(document).delegate('.violation_notification_count > a', 'click', function (e) {
    e.preventDefault();
    $('.violation_notifications').html('');

    requester.get(window.location.protocol + '//' + location.hostname + '/violationNotifications').then(
        function (success) {
            $('.violation_notifications').html(success.html);
        },
        function (fail) {
            console.log('fail');
        }
    );
});

$(document).delegate('#view_violation_data', 'click', function (ev)
{
    ev.preventDefault();
    var violationId = $(this).data('id');
    displayViolation(violationId);
});

$(document).delegate('.view_violation', 'click', function (ev)
{
    ev.preventDefault();
    var id = $(this).data('violation');

    displayViolation(id);
});

function displayViolation(id)
{
    requester.get('/getViolation/' + id).then(function (success)
    {
        $('#view_violation_modal').modal('show');

        if (violationNotificationMapper != undefined)
        {
            violationNotificationMapper.clearAreas();
            violationNotificationMapper.map.remove();
        }

        violationNotificationMapper = app.mapper.load('view_violation_map', false);
        var violationData = success.violationData;
        var latLngs = [];
        var trackedObjectRouteLatLngs = [];
        // console.log(violationData);

        /**
         * Draw restriction area
         * Sometimes area is deleted, but violation exists
         */
        if (violationData.isArea && violationData.area && violationData.area.area_points)
        {
            $.each(violationData.area.area_points, function (n, point) {
                var latLngPoint = [parseFloat(point.latitude), parseFloat(point.longitude)];
                latLngs.push(latLngPoint);
            });

            if (violationData.area.area_type == 'circle')
            {
                violationNotificationMapper.drawCircle(latLngs, parseFloat(violationData.area.radius));
            }
            else
            {
                violationNotificationMapper.drawPolygon(latLngs);
            }
        }

        // Draw violation speed/area
        if (violationData.trackedObjectPositions.length > 0)
        {
            $.each(violationData.trackedObjectPositions, function (n, point)
            {
                // Create point objects
                var latLngPoint = [parseFloat(point.latitude), parseFloat(point.longitude)];

                // If speed is violated
                if (violationData.isSpeed && parseFloat(point.speed) > parseFloat(violationData.speed))
                {
                    // Assign marker if speed is violated
                    var marker = L.marker(latLngPoint,
                            {
                                icon: speed_violated
                            })
                            .addTo(violationNotificationMapper.map);
                    violationNotificationMapper.featureGroup.addLayer(marker);
                    marker.bindPopup(
                    translations.allowed_speed + ": " + violationData.speed + "<br/>" +
                    translations.current_speed + ": " + point.speed);
                }

                // If area is violated
                if (violationData.isArea)
                {
                    trackedObjectRouteLatLngs.push(latLngPoint);
                }
            });

            // Add area violation line to map
            violationNotificationMapper.drawPolyline(trackedObjectRouteLatLngs);
        }

        // Fit Bounds
        if(violationNotificationMapper.featureGroup.getLayers().length != 0)
        {
            setTimeout(function (){
                violationNotificationMapper.map.fitBounds(
                    violationNotificationMapper.featureGroup.getBounds(),
                    {padding: [50, 50]}
                );
            }, 100);
        }
    });
}

