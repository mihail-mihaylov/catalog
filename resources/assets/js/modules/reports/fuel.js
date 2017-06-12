var mapper = undefined;
$(document).ready(function()
{
    $('#fuelReportTable').DataTable({
        buttons:[
            {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            $('#travel-list').html()
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
                className: 'btn btn-custom btn-sm pull-right',
                text: '<i class="glyphicon glyphicon-print"></i> ' + translations.print,
                title: '',
                exportOptions: {
                    columns: ':visible :not(:first-child)',
                    stripHtml: false
                }
            },
            {
                extend: 'colvis',
                className: 'btn btn-custom btn-sm pull-right',
                text: '<i class="fa fa-eye"></i> ' + translations.colvis,
                columns: ':not(:first-child)'
            }
        ],
        "sDom": 'B ft<"row"<"col-md-5"l><"col-md-7"p>>',
        "aaSorting": [],
        "info": false,
        "responsive" : {
            "details": {
                "type": 'column'
            }
        },
        "columnDefs": [
            {
                "className": 'control ',
                "orderable": false,
                "targets":   0
            }
        ],
        "paging": true,
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
        },
    });

    $("#fuelReportTable_wrapper .dt-button").appendTo($("#data-tables-actions"));
    $("#fuel_reports_list .dataTables_filter").appendTo($(".fuel_reports_search"));

    // Remove datatables styles
    $(".buttons-colvis, .buttons-print").removeClass('dt-button');

    $(document).delegate('#see_fuel_level', 'click', function (event)
    {
        // Change button color
        $(".see_fuel_level").not(this).removeClass('btn-success');
        $(".see_fuel_level").not(this).addClass('btn-default');

        $(this).removeClass('btn-default');
        $(this).addClass('btn-success');

        event.preventDefault();

        var data = $('#from, #to').serialize()+'&deviceId='+$(this).data('deviceid');

        requester.post($(this).data('fuel'), null, data).then(function (success)
        {
            // $('.form-control').removeClass('error');
            $('.graphs').html('');
            // $('.validation_errors').html('');

            var div_id = 'div_g';

            console.log(success.reports);
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
            console.log(fail);
        });
    });

    $(document).delegate('#clear_fuel_diagrams', 'click', function (event)
    {
        $('.graphs').html('');
    });
});

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
