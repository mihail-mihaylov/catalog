var modal = $('#baseModal');
var opened_map = 'list_map';

var requester = undefined;
mapper = undefined;

$(function (){
    initializeRequester();
    initializeMapper();
    mapper.map.on('draw:deleted', function(event)
    {
        $('.delete_area').prop('checked', true);
    });

    mapper.map.on('draw:created', function(event)
    {
        $('.delete_area').prop('checked', false);
    });
});

function initializeMapper() {
    if (mapper === undefined) {
        mapper = app.mapper.load('map', false);
        L.control.attribution();
    }

    return mapper;
}

function initializeRequester() {
    if (requester === undefined) {
        requester = app.requester.load();
    }
}

function getCoordinates(areaPoints)
{
    var coordinates = [];

    if (areaPoints.length == 1) {
        var coordinates = [
            (areaPoints.children('.area_point_latitude').data("latitude")),
            (areaPoints.children('.area_point_longitude').data("longitude"))
        ];

        return coordinates;
    }

    $.each(areaPoints, function(n, point) {
        var latLng = [
            ($(this).children('.area_point_latitude').data("latitude")),
            ($(this).children('.area_point_longitude').data("longitude"))
        ];

        coordinates.push(latLng);
    });

    return coordinates;
}

function refreshAreas() {
    mapper.featureGroup.clearLayers();
}

function moveMap(opened_map)
{
    if(opened_map == 'create_map')
    {
        mapper.toggleDrawControl(true);
    }

    if(opened_map == 'edit_map')
    {
        mapper.toggleDrawControl(true);
    }

    $('#'+opened_map).append($('#map'));
    mapper.clearAreas();

    $(document).trigger('map-container-resize', mapper.map);
}

$(document).delegate('.restriction_store_button', 'click', function (e) {
    e.preventDefault();
    toggleFormSpinner();
    var formAction = $(this).attr('action');
    var areaData = mapper.getAreaFormData();
    appendAreaFormData(areaData, $(this));
    $('.restriction_store_form').submit();
});

$(document).on('modal_form_loaded', function (e)
{
    setTimeout(function()
    {
        if($('#edit_map').length == 1)
        {
            opened_map = 'edit_map';
            moveMap(opened_map);
        }

        if($('.area_data').html() != undefined  && $('.area_data').html().trim() != "")
        {
            var areaPoints = $('.area_points');
            var coordinates = [];
            var radius = parseFloat($('.area_radius').data('radius'));
            var areaType = $('.area_type').data('areatype');

            if(areaType == 'rectangle') {areaType = 'polygon'}

            areaType = ucfirst(areaType);
            method = 'draw' + areaType;

            $.each(areaPoints, function (n, elem) {
                coordinates.push(L.latLng([parseFloat($(elem).data('latitude')), parseFloat($(elem).data('longitude'))]));
            });

            mapper[method](coordinates, radius);

            setTimeout(function (){
                    mapper.map.fitBounds(
                        mapper.featureGroup.getBounds(),
                        {padding: [50, 50]}
                    );
                }, 100);
        }

        if($('#create_map').length == 1)
        {
            opened_map = 'create_map';
            moveMap(opened_map);
        }

        // mapper.displayFitAreas();
    }, 300); // 300 because the fadeout effect of html dynamically loaded
});

$(document).delegate('.restriction_update_button', 'click', function (ev) {
    ev.preventDefault();
    toggleFormSpinner();
    var formAction = $(this).attr('action');

    mapper.processAreaFormData(mapper.featureGroup);
    var areaData = mapper.getAreaFormData();
    // if($('.area_point').val() != undefined){
        appendAreaFormData(areaData, $(this));
    // }
    // $( "button:last" ).click(function() {
    //   $( "button:first" ).trigger( "click" );
    //   update( $( "span:last" ) );
    // });
     $('.restriction_update_form').submit();
});

modal.on('hidden.bs.modal', function(e) {
    $('#list_map').append($('#' + opened_map).find('#map'));

    $(document).trigger('map-container-resize', mapper.map);

    if(opened_map != 'violation_map')
    {
        mapper.toggleDrawControl(false);
    }

    if (mapper.featureGroup.getLayers().length > 0) {
        mapper.featureGroup.eachLayer(function(layer) {
            mapper.map.removeLayer(layer);
        })
    }
});

function appendAreaFormData(data, container)
{
    container.find('input.hidden.area_data').remove();

    if (data.length) {
        var areaType = 'polygon';
        $.each(data, function(n, area) {

            if (area.radius !== undefined) {
                var radiusInput = $(document.createElement("input"));
                var centerLatInput = $(document.createElement("input"));
                var centerLngInput = $(document.createElement("input"));

                radiusInput.attr('class', 'hidden area_data');
                radiusInput.attr('name', 'radius');
                radiusInput.attr('value', area.radius);

                centerLatInput.attr('class', 'hidden area_points area_data');
                centerLatInput.attr('name', 'area_point[0][lat]');
                centerLatInput.attr('value', area.lat);

                centerLngInput.attr('class', 'hidden area_points area_data');
                centerLngInput.attr('name', 'area_point[0][lng]');
                centerLngInput.attr('value', area.lng);

                container.append(radiusInput);
                container.append(centerLatInput);
                container.append(centerLngInput);

                areaType = 'circle';
            } else {
                $.each(area, function(n, latLngObj) {
                    var latInput= $(document.createElement("input"));
                    var lngInput= $(document.createElement("input"));

                    latInput.attr('class', 'hidden area_points area_data');
                    latInput.attr('name', 'area_point[' + n + '][lat]');
                    latInput.attr('value', latLngObj.lat);

                    lngInput.attr('class', 'hidden area_points area_data');
                    lngInput.attr('name', 'area_point[' + n + '][lng]');
                    lngInput.attr('value', latLngObj.lng);

                    container.append(latInput);
                    container.append(lngInput);
                    // console.log('1');
                });
            }


        });

        var areaTypeInput = $(document.createElement("input"));
        areaTypeInput.attr('class', 'hidden area_data');
        areaTypeInput.attr('name', 'area_type');
        areaTypeInput.attr('value', areaType);
        container.append(areaTypeInput);
    }
}

function toggleFormSpinner()
{
    $('#sk-restriction-spinner').toggle();
}

function parseErrors(errors)
{
    $('.restriction-errors').html('');

    $.each(errors, function(n, error) {
        var errCont = $(document.createElement("h3"));
        // errCont.attr('class', 'label label-warning');//
        errCont.html(error[0]);
        $('.restriction-errors').append(errCont);
    });
}

function displayExistingAreaLimit()
{
    var areaDataContainer = $('.area_data');
    var restrictionAreaPoints = $('.area_points');
    if (restrictionAreaPoints.length) {
        var radius = areaDataContainer.find('.area_radius').data('radius');
        var areaType = areaDataContainer.find('.area_type').data('areatype');
        if (radius != 0) {
            var newLayer = L.circle([parseFloat(restrictionAreaPoints.first().data('latitude')), parseFloat(restrictionAreaPoints.first().data('longitude'))], parseFloat(radius));
        } else {
            var obj = [];
            $.each(restrictionAreaPoints, function(n, point) {
                // var polygonPoint = L.latLng(42.7234017, 42.7234017);

                var polygonPoint = L.latLng($(point).data('latitude'), $(point).data('longitude'));
                obj[n] = polygonPoint;
            });
            var newLayer = L.polygon(obj);
        }
        mapper.displayArea(newLayer);
        mapper.map.fitBounds(mapper.featureGroup.getBounds());
    }
}

var drawTrackedObjectRoute = function (data) {
    var routeLatLngs = [];
    $.each(data.trackedObjectPositions, function(n, position) {
        var position = L.latLng(parseFloat(position.latitude), parseFloat(position.longitude));
        var marker = L.marker(position)
        routeLatLngs.push(position);

    });

    var route = mapper.drawPolyline(routeLatLngs, {color:'red'});
    mapper.map.fitBounds(route.getBounds());
};

var drawSpeedViolation = function (data) {
    $.each(data.trackedObjectPositions, function(n, elem) {
        var position = L.latLng(parseFloat(elem.latitude), parseFloat(elem.longitude));
        var marker = L.marker(position, {title:'Позволена скорост: ' + data.speed +'<br>' +
            $('#trans_speed').data('translation') + elem.speed}).addTo(mapper.map);

        mapper.markers.push(marker);
    });

};

var drawAreaViolation = function (data) {
    var coordinates = [];
    $.each(data.areaPoints, function(n, point) {
        var coordinate = [point.latitude, point.longitude];
        coordinates.push(coordinate);
    });

    if (data.area.radius == 0) {
        mapper.drawPolygon(coordinates);
    } else {
        mapper.drawCircle(coordinates[0], data.area.radius)
    }

    mapper.fitFeatureGroupBounds();
}

/**
 * Updating violations table when a restriction is deleted/restored
 * @author Mihail Mihaylov <mmihaylov@neterra.net>
 * @copyright 2016-05-04
 */
$(document).delegate('button[data-delete]', 'click', function ()
{
    // On data delete
    var button = $(this);
    var table = button.data('update-table');
    var restriction_id = button.data('id');

    // Delete row
    $('#'+table).dataTable().fnDeleteRow('.restriction-'+restriction_id);

});

$(document).delegate('button[data-update]', 'click', function ()
{
    // On data update
    var button = $(this);
    var table = button.data('update-table');
    var action = button.data('action');
    var restriction_id = button.data('id');

    requester.get('violations/getViolationsByRestriction/'+restriction_id)
    .then(function (data)
    {
        var violations = jQuery.parseJSON( data.violations );
        var table_object = $('#'+table).dataTable();

        $.each(violations, function(index, violation)
        {
            var new_row = table_object.fnAddData([
                null,
                violation.device.tracked_object.identification_number,
                ((violation.is_speed_violated) ? translations.by_speed : '')+"<br/>"+((violation.is_area_violated) ? translations.by_area : ''),
                toDate(violation.start_time.date, 'YYYY-MM-DD HH:mm:ss'),
                toDate(violation.end_time.date, 'YYYY-MM-DD HH:mm:ss'),
                '<button type="button" class="btn btn-xs btn-info" data-title="'+translations.view_violation+'" data-id="'+violation.id+'" data-action="'+window.location.protocol + '//' + location.hostname + '/violations/'+violation.id+'" data-get><i class="fa fa-map-marker"></i> '+translations.view_on_map+'</button>'
            ]);
            var last_added_row = table_object.fnSettings().aoData[ new_row[0] ].nTr;
            last_added_row.className = 'restriction-'+violation.limit_id;
        });
    },
    function (error) {
        console.log(error);
    });

});

function  toDate(date, format)
{
    var localTime  = moment(date).toDate();
    localTime = moment(localTime).format(format);
    return localTime;
}

//# sourceMappingURL=restrictions.js.map
