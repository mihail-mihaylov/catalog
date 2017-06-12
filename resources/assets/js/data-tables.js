$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
} );

var datatable = $('.data-table').dataTable({
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
        { "responsivePriority": 2, "targets": -1 }
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

$("#dashboard_shared_tasks_list .dataTables_filter").appendTo($(".dashboard_shared_tasks_search"));
$("#tracked_objects_to_list .dataTables_filter").appendTo($(".tracked_objects_search"));
$("#tracked_objects_devices_list .dataTables_filter").appendTo($(".devices_search"));
$("#users_list .dataTables_filter").appendTo($(".users_search"));
$("#users_groups_list .dataTables_filter").appendTo($(".users_groups_search"));
$("#trips_reports_list .dataTables_filter").appendTo($(".trips_reports_search"));
$("#restrictions_list .dataTables_filter").appendTo($(".restrictions_search"));
$("#violations_list .dataTables_filter").appendTo($(".violations_search"));
$("#drivers_list .dataTables_filter").appendTo($(".drivers_search"));
$("#personal_tasks_list .dataTables_filter").appendTo($(".personal_tasks_search"));
$("#all_tasks_list .dataTables_filter").appendTo($(".all_tasks_search"));
$("#personal_reminders_list .dataTables_filter").appendTo($(".personal_reminders_search"));
$("#all_reminders_list .dataTables_filter").appendTo($(".all_reminders_search"));
$("#groups_list .dataTables_filter").appendTo($(".groups_search"));
$("#pois_list .dataTables_filter").appendTo($(".pois_search"));
$("#companies_list .dataTables_filter").appendTo($(".companies_search"));
$("#poi_report_list .dataTables_filter").appendTo($(".poi_report_search"));



$.fn.appendRow = function ($rows) {
    if ($(this).parent().hasClass("dataTables_wrapper")) {
        var dt = $(this).dataTable().api();
        $rows.each(function () {
            dt.row.add(this);
        });
        dt.draw('full-hold');
    } else {
        $(this).append($rows);
    }
}

$(document).delegate('button[data-delete-all]', 'click', function ()
{
    var button = $(this);
    var action = button.data('action');
    var table_name = button.data('table-name');

    requester.get(action).then(function (data)
    {
        $('#'+table_name).dataTable().fnClearTable();
    },
    function (error) {
        console.log(error);
    });
});

