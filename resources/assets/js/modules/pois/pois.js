var marker = false, drawnPois = [], drawnItems, bounds;
// var mapper = undefined;
var mapper_modal = undefined;

$(function(){

    mapper = app.mapper.load('map', false);
    mapper.toggleFullscreenControl(true);
    mapper.toggleMeasureControl(true);

    bounds = new L.LatLngBounds();
    drawnPois = new L.featureGroup();

    loadPois();

});

$(document).on('click', '.reload_action', function (e)
{
    setTimeout(function(){
        drawnPois.clearLayers();
        loadPois();
    }, 500);
});

$(document).on('modal_form_submited', function (e)
{
    drawnPois.clearLayers();
    loadPois();
});

/**
 * Fit one poi on map
 */
$(document).delegate('.see_poi_on_map', 'click', function(e)
{
    var poi_id = $(this).data('poi-id');
    var drawnPoi = getPoi(poi_id);

    if(drawnPoi)
    {
        var tempGroup = new L.featureGroup().addLayer(drawnPoi);
        setTimeout(function (){
            mapper.map.fitBounds(tempGroup.getBounds(), {padding: [50, 50]});
        }, 100);
    }
});

/*
 * Fit pois in map button action
 */
$(document).delegate('#fit-pois', 'click', function(e)
{
    if(drawnPois.getLayers().length > 0)
    {
        setTimeout(function()
        {
            mapper.map.fitBounds(drawnPois.getBounds(), {padding: [50, 50]});
        }, 100);
    }
});

$(document).on('modal_form_loaded', function (e)
{

    setTimeout(function()
    {
        // Initialize map
        mapper_modal = app.mapper.load('map_modal', false);
        mapper_modal.toggleFullscreenControl(true);
        mapper_modal.toggleMeasureControl(true);
        drawnItems = new L.featureGroup();


        // Get Poi for edit and put it in feature group
        if($('.response_coordinates').val() != undefined){
            var poi = JSON.parse($('.response_coordinates').val());

            // Creates drawn object
            var drawnObject = createObject(poi);

            // Add coordinates to hidden input, for update by php
            loadCoordinatesField(drawnObject);

            // Add drawn objects to feature group for edit
            drawnItems.addLayer(drawnObject);

            // Add object to map
            mapper_modal.map.addLayer(drawnItems);

            // Fit bounds (settimeout because polygon breaks otherwise)
            setTimeout(function (){
                mapper_modal.map.fitBounds(drawnItems.getBounds());
            }, 100);
        }

        // Initialize draw options for creating Poi
        var drawControlOptions =
        {
            position: 'topleft',
            draw: {
                marker: true,
                polygon: {
                    allowIntersection: false, // Restricts shapes to simple polygons
                    drawError: {
                        color: '#e1e100', // Color the shape will turn when intersects
                        message: '<strong>A drawing error has occured</strong>',
                        timeout: 1500
                    },
                    shapeOptions: {
                        color: '#BD2A84'
                    },
                    showArea: true
                },
                rectangle: {
                    shapeOptions: {
                        color: '#BD2A84'
                    }
                },
                circle: {
                    shapeOptions: {
                        color: '#BD2A84'
                    }
                },
                polyline: false,
            },
            edit: {
                featureGroup: drawnItems
            }
        };

        // Add options to to the map
        var drawControl = new L.Control.Draw(drawControlOptions);
        mapper_modal.map.addControl(drawControl);

        // Events for create, edit, delete on drawn items
        mapper_modal.map.on('draw:created', function(event)
        {
            var layer = event.layer;
            loadCoordinatesField(layer);
            drawnItems.addLayer(layer);
        });

        mapper_modal.map.on('draw:edited', function (event)
        {
            var layers = event.layers;
            layers.eachLayer(function (layer)
            {
                loadCoordinatesField(layer);
                drawnItems.addLayer(layer);
            });
        });

        mapper_modal.map.on('draw:deleted', function(event)
        {
            drawnItems.clearLayers();
            $('#baseModal').find('#locationvalue').val("");
        });

        mapper_modal.map.on('draw:drawstart', function(event)
        {
            drawnItems.clearLayers();

            // Refresh coordinate input field
            $('#baseModal').find('#locationvalue').val("");
        });

        mapper_modal.map.on('geosearch_showlocation', function (event)
        {
            var layer = event.Marker;
            loadCoordinatesField(layer);
            drawnItems.addLayer(layer);
        });

        mapper_modal.map.on('geosearch_error',function (event)
        {
            drawnItems.clearLayers();
            $('#baseModal').find('#locationvalue').val("");
        });

        /**
         * GeoSearch control
         * TODO: add to mapper_modal
         */
        var googleGeocodeProvider = new L.GeoSearch.Provider.Google();
        var geoSearchControl = new L.Control.GeoSearch(
        {
            // provider: new L.GeoSearch.Provider.OpenStreetMap()
            provider: googleGeocodeProvider,
            position: 'topcenter',
            showMarker: true,
            retainZoomLevel: false,
            draggable: false,
            placeholder: translations.searchAddressPlaceholder,
            //TODO: for other providerss too
        });

        mapper_modal.map.addControl(geoSearchControl);
        $('#baseModal').find('#leaflet-control-geosearch-qry').attr('placeholder', translations.searchAddressPlaceholder );

        }, 300);
        // 300 because the fadeout effect of html dynamically loaded
        // into the modal
});

function loadCoordinatesField(layer)
{
    // Create an object of coordinates
    var coordinates = {
        'poi_points': [],
        'poi_shape': '',
        'radius': null
    };

    // Fill the coordinates values
    if (layer instanceof L.Rectangle)
    {
        $.each(layer.getLatLngs(), function(k,v)
        {
            coordinates.poi_points.push({
                'latitude': parseFloat(v.lat).toFixed(7),
                'longitude': parseFloat(v.lng).toFixed(7)
            });
        });
        coordinates.poi_shape = 'rectangle';
    }
    else if (layer instanceof L.Polygon)
    {
        $.each(layer.getLatLngs(), function(k,v)
        {
            coordinates.poi_points.push({
                'latitude': parseFloat(v.lat).toFixed(7),
                'longitude': parseFloat(v.lng).toFixed(7)
            });
        });
        coordinates.poi_shape = "polygon";
    }
    else if (layer instanceof L.Polyline)
    {
        $.each(layer.getLatLngs(), function(k,v)
        {
            coordinates.poi_points.push({
                'latitude': parseFloat(v.lat).toFixed(7),
                'longitude': parseFloat(v.lng).toFixed(7)
            });
        });
        coordinates.poi_shape = "polyline";
    }
    else if (layer instanceof L.Circle)
    {
        coordinates.poi_points.push({
            'latitude': parseFloat(layer.getLatLng().lat).toFixed(7),
            'longitude': parseFloat(layer.getLatLng().lng).toFixed(7)
        });
        coordinates.radius = parseFloat(layer.getRadius()).toFixed(12);
        coordinates.poi_shape = "circle";
    }
    else if (layer instanceof L.Marker)
    {
        coordinates.poi_points.push({
            'latitude': parseFloat(layer.getLatLng().lat).toFixed(7),
            'longitude': parseFloat(layer.getLatLng().lng).toFixed(7)
        });
        coordinates.poi_shape = "marker";
    }
    else
    {
        coordinates.poi_points.push({
            'latitude': parseFloat(layer.getLatLng().lat).toFixed(7),
            'longitude': parseFloat(layer.getLatLng().lng).toFixed(7)
        });
        coordinates.poi_shape = null;
    }


    $('#baseModal').find('#locationvalue').val(JSON.stringify(coordinates));
    // console.log($('#baseModal').find('#locationvalue').val());

}

function createObject(poi)
{
    // console.log(poiType, coordinates, radius);
    if(poi.poi_type == 'polygon' || poi.poi_type == 'rectangle')
    {
        var coordinates = [];
        $.each(poi.poi_points, function (n, point) {
            var coordinate = [point.latitude, point.longitude];
            coordinates.push(coordinate);
            // coordinates.push([parseFloat(point.latitude), parseFloat(point.longitude)]);
        });

        return new L.polygon(coordinates);
    }


    if(poi.poi_type == 'circle')
    {
        return new L.Circle(L.latLng([parseFloat(poi.poi_points[0].latitude), parseFloat(poi.poi_points[0].longitude)]), poi.radius);
    }


    if(poi.poi_type == 'marker')
    {
        return new L.Marker(L.latLng([parseFloat(poi.poi_points[0].latitude), parseFloat(poi.poi_points[0].longitude)]));
    }
}

function getPoi(poi_id)
{
    var poi = false;

    drawnPois.eachLayer(function (layer)
    {
        if(layer.key == poi_id)
        {
            poi = layer;
        }
    });
    return poi;
}
