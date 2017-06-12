var mapper = undefined;
window.onload = function () {
    var parseErrorsToForm = function (errors) {
        // Remove error class from input fields
        $('.form-control').removeClass('error');

        $('.validation_errors').html('');

        // Create alert with error messages
        var div = $(document.createElement('div'));
        div.addClass('alert alert-danger alert-dismissable col-md-12');
        div.html('<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>');

        // Loop errors
        $.each(errors.responseJSON, function (key, value) {
            // Replace names of the fields which are named with array format (.1 with [1]). Example: first_name.1 to first_name[1]
            if (key.indexOf('.') !== -1) {
                key = key.split('.').join('][');
                key = key.replace(/\./g, '][');
                key = key.replace(']', '');
                key += ']';
            }

            // Add error class to fields with mistake
            $("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").addClass('error');
            // Add error to alert
            div.append('<div class="text-left">' + value + '</div>');
        });

        $('.validation_errors').append(div);
    }
    var trackedObjectsList = $('#tracked_objects');
    var trackedObjectsParameters = $('#can_bus_parameters');
    var submitButton = $('#get_canbus_report');

    trackedObjectsList.select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });
    trackedObjectsParameters.select2({
        width: "100%",
        language: {
           "noResults": function(){
               return translations.no_data;
           }
        }
    });

    $(document).delegate('#get_canbus_report', 'click', function (event) {
    	event.preventDefault();

    	data = $("#tracked_objects, #can_bus_parameters, #last_date, #periodInput, #hiddenLastDate").serialize();

    	requester.post($(this).data('canbus'), null, data).then(
    		function (success) {

                $('.form-control').removeClass('error');
                $('.graphs').html('');
                $('.validation_errors').html('');

                var div_id = 'div_g';

                $.each(success.reports, function (n, items) {
                    var events = "";
                    var graphLabel = items.reportName;
                    var temp_translations = [];
                    var temp_key = 0;

                    $.each(items.data, function (m, item) {
                        var graphPoint = item[n];

                        // Skip points
                        if (m > 0 && graphPoint == items.data[m-1][n] && (m != items.data.length - 1 && graphPoint == items.data[m+1][n])) {
                            return true;
                        }

                        // Translations
                        var key = n + '.' + graphPoint;
                        if (translations[key] && ! temp_translations[key]) {
                            temp_key ++;
                            temp_translations[key] = temp_key;
                            graphPoint = temp_key;
                        } else if (translations[key]) {
                            graphPoint = temp_translations[key];
                        }

                        events += new Date(moment(item['gps_utc_time']).format("YYYY/MM/DD HH:mm:ss")) + "," + graphPoint + ","+ m +"\n";
                    });

                    for (var x in temp_translations) {
                        temp_translations[temp_translations[x]] = x;
                    }

                    $('.results').removeClass('hidden');

                    if (items.data.length > 0) {
                        // Append div for the current graph
                        $('.graphs').append('<div id="' + div_id + '"></div><br /><br />');

                        var g = new Dygraph(document.getElementById(div_id),
                            events,
                            {
                                title: graphLabel + (items.label ? ' (' + items.label + ')' : ''),
                                visibility: [true, false],
                                axes: {
                                    x: {
                                        axisLabelFormatter: function(x) {
                                            return x.getFullYear() + '.' +
                                                    (x.getMonth() + 1 < 10 ? '0' : '') + (x.getMonth() + 1)  + '.' +
                                                    (x.getDate() < 10 ? '0' : '') + x.getDate() + ' ' +
                                                    (x.getHours() < 10 ? '0' : '') + x.getHours() + ':' +
                                                    (x.getMinutes() < 10 ? '0' : '') + x.getMinutes() + ':' +
                                                    (x.getSeconds() < 10 ? '0' : '') + x.getSeconds();
                                        }
                                    },
                                    y: {
                                        axisLabelFormatter: function (y) {
                                            var response = y;
                                            if (temp_translations.length > 0) {
                                                response = translations[temp_translations[y]] ? translations[temp_translations[y]] : '';
                                            }

                                            return response;
                                        },
                                        valueFormatter: function (y) {
                                            var response = y;
                                            if (temp_translations.length > 0) {
                                                response = translations[temp_translations[y]] ? translations[temp_translations[y]] : '';
                                            }

                                            return response;
                                        }
                                    }
                                },
                                axisLabelWidth: 72,
                                labels: ["X", "Y", "ID"],
                                pointClickCallback: function(event, p)
                                {
                                    displayOnMap(this.getValue(p.idx, 2), items);
                                }
                            });

                        g.resize();

                        div_id = div_id + '1';
                    } else {
                        $('.graphs').append("<b>" + graphLabel + "</b> - " + $('#no_data_translation').data('translation') + "<br /><br />");
                    }

                    // Scroll to the results
                    window.scrollTo(0, 500);
                });
            },
    		function (fail) {
    			parseErrorsToForm(fail);
    		}
		);
    });

    $(document).delegate('#clear_canbus_diagrams', 'click', function (event)
    {
        $('.graphs').html('');
    });
};

function displayOnMap(id, items)
{
    for(var key in items.data)
    {
        if(id == key)
        {
            // Create map container
            if ($("#canbus_point_map").length === 0)
            {
                var div = document.createElement('div');
                div.id = 'canbus_point_map';
                div.style.width = "100%";
                div.style.height = "500px";
            }

            // Show modal
            $('#baseModal').modal('show');

            if (mapper != undefined)
            {
                mapper.clearMarkers();
                mapper.map.remove();
            }

            // Prepare modal
            $('#baseModalTitle').html(translations.view_location);
            $('#baseModal .modal-body .modal-body-content').append(div);
            mapper = app.mapper.load('canbus_point_map', false);
            $(".modal-body-loading").hide();

            // Create marker and add it to map
            var gps_event = items.data[key];
            var latLngPoint = [parseFloat(gps_event.latitude), parseFloat(gps_event.longitude)];
            var marker = L.marker(latLngPoint);
            assignIcon(marker, gps_event.device_status, gps_event.azimuth);
            marker.addTo(mapper.map);

            // Fit bounds
            setTimeout(function ()
            {
                mapper.map.fitBounds(
                    [latLngPoint],
                    {padding: [50, 50]}
                );
            }, 100);
        }
    }
}

//# sourceMappingURL=canbus.js.map
