var mapper = undefined;
window.onload = function () {
    var trackedObjectsList = $('#tracked_objects_parametric');
    var trackedObjectsParameters = $('#tracked_objects_parameters');

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

    var toggleSpinner = function() {
        var spinner = $('#spiner-inputs');
        if (spinner.hasClass('hidden')) {
            spinner.removeClass('hidden');
        } else {
            spinner.addClass('hidden');
        }
    };

    trackedObjectsList.on('change', function (event) {
        //toggleSpinner();
        requester.get($(this).find(':selected').data('get')).then(
            function (success) {
                //toggleSpinner();
                $(trackedObjectsParameters).select2("destroy");
                trackedObjectsParameters.find('option').remove();
                $(trackedObjectsParameters).select2({data: success.parameters});
            },
            function (fail) {
                //toggleSpinner();
            }
        )
    });

    trackedObjectsList.select2('val', $('#tracked_objects_parametric option:eq(0)').val());
        $('#end_date').datepicker({
            todayBtn: 'linked',
            calendarWeeks: true,
            autoclose: true,
            language: $('.data-locale').data('locale'),
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        var chartContainer = $('<div></div>');

       var selector = $('#morris-inputs-chart');
    /**
     * Parse and show errors
     */
    var parseErrorsToForm = function (errors) {
        // Remove error class from input fields
        // $('.form-control').removeClass('error');

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

    $(document).delegate('#get_parametric_report', 'click', function (event)
    {
        event.preventDefault();
        var data = $('#end_date, #tracked_objects_parameters, #periodInput, #hiddenLastDate').serialize();

        requester.post($(this).data('post'), null, data).then(function (success)
        {
            // $('.form-control').removeClass('error');
            $('.graphs').html('');
            $('.validation_errors').html('');

            if(success.data != null)
            {
                $.each(success.data, function (inputId, events)
                {
                    var points = [];
                    var div_id = 'input_'+inputId;
                    var temp_translations = [];
                    $('.results').removeClass('hidden');

                    if (events[0].device_input_event_id != null)
                    {
                        $.each(events, function (n, event)
                        {
                            if (event.type == 'digital' && !(parseInt(event.input_event_value) in temp_translations))
                            {
                                var key = parseInt(event.input_event_value);
                                temp_translations[key] = (event.graphValue);
                            }

                            points.push([new Date(moment(event.gps_utc_time).format("YYYY/MM/DD HH:mm:ss")), event.input_event_value, n]);
                        });

                        // Append div for the current graph
                        $('.graphs').append('<div id="' + div_id + '"></div><br/><br/><br/>');

                        var g = new Dygraph(document.getElementById(div_id),
                        points,
                        {
                            title: events[0].name + (events[0].measurement_unit ? ' (' + events[0].measurement_unit + ')' : ''),
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
                                    axisLabelFormatter: function (y)
                                    {
                                        if(events[0].type == 'digital')
                                        {
                                            return temp_translations[parseInt(y)];
                                        }
                                        return parseFloat(y).toFixed(1);
                                    },
                                    valueFormatter: function (y)
                                    {
                                        if(events[0].type == 'digital')
                                        {
                                            return temp_translations[parseInt(y)];
                                        }
                                        return parseFloat(y).toFixed(1);
                                    }
                                }
                            },
                            axisLabelWidth: 72,
                            labels: [ 'Date', 'Value', 'ID' ],
                            pointClickCallback: function(event, p)
                            {
                                displayOnMap(this.getValue(p.idx, 2), events);
                            }
                        });

                        g.resize();

                    } else {
                        $('.graphs').append("<b>" + events[0].name + "</b> - " + translations.no_data + "<br /><br />");
                    }

                    // Scroll to the results
                    window.scrollTo(0, 500);
                });
            }
        },
        function (fail) {
            parseErrorsToForm(fail);
        });
    });

    $(document).delegate('#clear_parametric_diagrams', 'click', function (event)
    {
        $('.graphs').html('');
    });
};

function displayOnMap(id, events)
{
    for(var key in events)
    {
        if(id == key)
        {
            // Create map container
            if ($("#parametric_point_map").length === 0)
            {
                var div = document.createElement('div');
                div.id = 'parametric_point_map';
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
            mapper = app.mapper.load('parametric_point_map', false);
            $(".modal-body-loading").hide();

            // Create marker and add it to map
            var gps_event = events[key];
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

//# sourceMappingURL=parametric.js.map
