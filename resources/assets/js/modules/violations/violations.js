// var violation_mapper = undefined;
var requester = undefined;

$(function () {
    requester = app.requester.load();
});

$(document).delegate('.violation_notification_count > a', 'click', function(e) {
    e.preventDefault();
    $('.violation_notifications').html('');

    requester.get('violationNotifications').then(
        function(success) {
            // console.log($('.violation_notifications').length);return false;
            $('.violation_notifications').html(success.html);
        },
        function(fail) {
            console.log('fail');
        }
    );
});

$(document).on('modal_form_loaded', function (e)
{
    setTimeout(function()
    {
        if($('.response_violation_data').val() != undefined)
        {
            opened_map = 'violation_map';
            moveMap(opened_map);

            var violationData = JSON.parse($('.response_violation_data').val());
            var latLngs = [];
            var trackedObjectRouteLatLngs = [];

            /**
             * Draw restriction area
             * Sometimes area is deleted, but violation exists
             */
            if(violationData.isArea && violationData.area && violationData.area.area_points)
            {
                 $.each(violationData.area.area_points, function (n, point){
                    var latLngPoint = [parseFloat(point.latitude), parseFloat(point.longitude)];
                    latLngs.push(latLngPoint);
                });

                if (violationData.area.area_type == 'circle')
                {
                    mapper.drawCircle(latLngs, parseFloat(violationData.area.radius));
                }
                else
                {
                    mapper.drawPolygon(latLngs);
                }
            }

            // Draw violation speed/area
            if(violationData.trackedObjectPositions.length > 0)
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
                        .addTo(mapper.map);
                        mapper.featureGroup.addLayer(marker);
                        marker.bindPopup($('#trans_allowed_speed').data('translation') + ": " + violationData.speed + "<br>" + $('#trans_speed').data('translation') + ": " + point.speed);
                    }

                    // If area is violated
                    if(violationData.isArea)
                    {
                        trackedObjectRouteLatLngs.push(latLngPoint);
                    }
                });

                // Add area violation line to map
                mapper.drawPolyline(trackedObjectRouteLatLngs);
            }

            // Fit Bounds
            if(mapper.featureGroup.getLayers().length != 0)
            {
                setTimeout(function (){
                    mapper.map.fitBounds(
                        mapper.featureGroup.getBounds(),
                        {padding: [50, 50]}
                    );
                }, 100);
            }
        }
        // console.log([$('#edit_map'),$('#create_map'),$('#violation_map'), opened_map]);
    }, 300);
});

//# sourceMappingURL=global_show_violation.js.map
