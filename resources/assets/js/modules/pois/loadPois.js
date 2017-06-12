/*
 * Add POIs to map
 */
function loadMarker(poi, loc)
{
    var icon = L.icon({
        iconUrl: '/images/pois/'+poi.icon+'.png',
        iconSize:     [32, 32],
        iconAnchor:   [16, 31],
        popupAnchor:  [0, -30],
        labelAnchor:  [14, -14]
    });

    var poiMarker = L.marker(loc, {
        icon: icon
    });
    poiMarker.key = poi.id;

    poiMarker.bindLabel(poi.translation[0].name);

    return poiMarker;
}

function loadCircle(poi, radius, loc)
{

    var poiCircle = L.circle(loc, radius,{color: '#BD2A84'});
    poiCircle.key = poi.id

    poiCircle.bindLabel(poi.translation[0].name);

    return poiCircle;
}

function loadPolygon(poi, polyCoords)
{
    var poiPolygon = L.polygon([polyCoords]);
    poiPolygon.key = poi.id

    poiPolygon.bindLabel(poi.translation[0].name);

    return poiPolygon;
}

function loadPois()
{
    requester.get('/pois/json').then(function (data)
    {
        var pois = jQuery.parseJSON(data.pois);

        if(pois.length > 0) {

            // Iterate through all passed pois
            $.each(pois, function(k, poi){

                if(poi.poi_type == 'marker') {

                    // Location
                    var loc = new L.LatLng(parseFloat(poi.poi_points[0].latitude), parseFloat(poi.poi_points[0].longitude));
                    bounds.extend(loc);

                    var poiMarker = loadMarker(poi, loc);
                    drawnPois.addLayer(poiMarker);

                }
                else if (poi.poi_type == 'polygon' || poi.poi_type == 'rectangle')
                {

                    var polyCoords = [];

                    $.each(poi.poi_points, function(n, point)
                    {
                        polyCoords.push([parseFloat(point.latitude), parseFloat(point.longitude)]);
                        bounds.extend(polyCoords);
                    });

                    var poiPolygon = loadPolygon(poi, polyCoords);
                    drawnPois.addLayer(poiPolygon);
                }
                else if (poi.poi_type == 'circle')
                {
                    var radius = poi.radius;
                    var loc = new L.LatLng(
                        parseFloat(poi.poi_points[0].latitude),
                        parseFloat(poi.poi_points[0].longitude)
                        );
                    bounds.extend(loc);

                    var poiCircle = loadCircle(poi, radius, loc);
                    drawnPois.addLayer(poiCircle);
                }

            });

            drawnPois.addTo(mapper.map);

            setTimeout(function() {
                mapper.map.fitBounds(bounds, { padding: [50, 50] });
            }, 50);


        }
    },
    function (httperror) {

        if(typeof httperror.status != "undefined" && httperror.status == 401) {
            console.log('failed');
            // window.location = "/auth/login?expired=1";
        }
    });
}

/*
 * Remove POIs from map
 */
function hidePois()
{
     drawnPois.clearLayers();
}
