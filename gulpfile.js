process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.scripts(
        [
            // jquery and plugins
            'plugins/jquery/jquery-1.11.3.min.js',
            'plugins/jquery/jquery-migrate-1.2.1.min.js',
            'plugins/metisMenu/jquery.metisMenu.js',
            'plugins/slimscroll/jquery.slimscroll.min.js',
            'plugins/switchery/switchery.js',
            'plugins/datapicker/bootstrap-datepicker.js',
            'plugins/datapicker/datepicker-bg.js',
            'plugins/clockpicker/clockpicker.js',
            'plugins/nouslider/nouislider.min.js',
            'plugins/dataTables/jquery.dataTables.js',
            'plugins/dataTables/dataTables.tableTools.min.js',
            'plugins/dataTables/dataTables.buttons.min.js',
            'plugins/dataTables/buttons.print.min.js',
            'plugins/dataTables/buttons.colVis.min.js',
            'plugins/dataTables/dataTables.responsive.js',
            'plugins/dataTables/dataTables.bootstrap.js',
            'plugins/toastr/toastr.min.js',
            'plugins/tableExport/Blob.js',
            'plugins/tableExport/FileSaver.js',
            'plugins/tableExport/tableexport-3.1.js',
            'plugins/tableExport/xlsx.core.min.js',
            'plugins/select2/select2.full.min.js',
            'plugins/easypiechart/jquery.easypiechart.js',
            'plugins/easypiechart/easypiechart.js',
            'plugins/morris/morris.js',
            'plugins/morris/raphael-2.1.0.min.js',
            'plugins/nv.d3/d3.v3.js',
            'plugins/nv.d3/nv.d3.min.js',
            'plugins/chartist/chartist.min.js',
            'plugins/dygraph/dygraph-combined.js',
            // bootstrap
            'bootstrap.min.js',
            'bootstrap-modal.js',
            // moment lib
            'moment.min.js',
            'moment-duration-format.js',
            // theme
            'inspinia.js',
            // helpers
            'q.js',
            'requester.js',
            'app-notifications.js',
            'mapper.js',
            // global js
            'app.js',
            // misc helper functions
            'helpers.js'
//           'socket/socket.io.event.handler.js'

        ],
        'public/js/plugins.js'
    );

    mix.scripts(
        [
            '../leaflet/libs/leaflet-src.js',
            '../leaflet/src/Leaflet.draw.js',
            '../leaflet/src/Toolbar.js',
            '../leaflet/src/Tooltip.js',
            '../leaflet/src/ext/GeometryUtil.js',
            '../leaflet/src/ext/LatLngUtil.js',
            '../leaflet/src/ext/LineUtil.Intersect.js',
            '../leaflet/src/ext/Polygon.Intersect.js',
            '../leaflet/src/ext/Polyline.Intersect.js',
            '../leaflet/src/draw/DrawToolbar.js',
            '../leaflet/src/draw/handler/Draw.Feature.js',
            '../leaflet/src/draw/handler/Draw.SimpleShape.js',
            '../leaflet/src/draw/handler/Draw.Polyline.js',
            '../leaflet/src/draw/handler/Draw.Circle.js',
            '../leaflet/src/draw/handler/Draw.Marker.js',
            '../leaflet/src/draw/handler/Draw.Polygon.js',
            '../leaflet/src/draw/handler/Draw.Rectangle.js',
            '../leaflet/src/edit/EditToolbar.js',
            '../leaflet/src/edit/handler/EditToolbar.Edit.js',
            '../leaflet/src/edit/handler/Edit.Marker.js',
            '../leaflet/src/edit/handler/EditToolbar.Delete.js',
            '../leaflet/src/edit/handler/Edit.Poly.js',
            '../leaflet/src/edit/handler/Edit.SimpleShape.js',
            '../leaflet/src/edit/handler/Edit.Circle.js',
            '../leaflet/src/edit/handler/Edit.Rectangle.js',
            '../leaflet/libs/leaflet.measurecontrol.js',
            '../leaflet/libs/leaflet.fullscreen.js',
            '../leaflet/src/Control.Draw.js',
            '../leaflet/addons/labels/js/Label.js',
            '../leaflet/addons/labels/js/BaseMarkerMethods.js',
            '../leaflet/addons/labels/js/Marker.Label.js',
            '../leaflet/addons/labels/js/CircleMarker.Label.js',
            '../leaflet/addons/labels/js/Path.Label.js',
            '../leaflet/addons/labels/js/Map.Label.js',
            '../leaflet/addons/labels/js/FeatureGroup.Label.js',
            '../leaflet/addons/geosearch/js/l.control.geosearch.js',
            '../leaflet/addons/geosearch/js/l.geosearch.provider.google.js',
            '../leaflet/addons/geosearch/js/l.geosearch.provider.openstreetmap.js'
        ],
        'public/js/leaflet_dependencies.js'
    );

    /**
     * Dashboard
     */
    mix.scripts(
        [
            'dashboard.js',
        ],
        'public/js/modules/dashboard/dashboard.js'
    );

    /**
     * GeneralReport
     */
    mix.scripts(
        [
            'modules/reports/general.report.js',
        ],
        'public/js/modules/reports/general.report.js'
    );

    /**
     * FuelReport
     */
    mix.scripts(
        [
            'modules/reports/fuel.js',
        ],
        'public/js/modules/reports/fuel.js'
    );

    /**
     * Pois
     */
    mix.scripts(
        [
            'modules/pois/pois.js',
        ],
        'public/js/modules/pois/pois.js'
    );

    mix.scripts(
        [
            'modules/pois/loadPois.js',
        ],
        'public/js/modules/pois/loadPois.js'
    );


    /**
     * TrackedObjects
     */

    mix.scripts(
        [
            // 'modules/tracked_objects/trackedObjects.js',
            'modules/tracked_objects/trackedObjectsGroups.js',
            // 'modules/tracked_objects/devices.js'
        ],
        'public/js/modules/trackedObjectsGroups.js'
    );
    mix.scripts(
        [
            // 'modules/tracked_objects/trackedObjects.js',
            'modules/reports/parametric.js',
            // 'modules/tracked_objects/devices.js'
        ],
        'public/js/modules/parametric.js'
    );
    mix.scripts(
        [
            // 'modules/tracked_objects/trackedObjects.js',
            'modules/reports/canbus.js',
            // 'modules/tracked_objects/devices.js'
        ],
        'public/js/modules/canbus.js'
    );
    mix.scripts(
        [
            'modules/users/main.js',
            'modules/users/groups.js',
            'modules/users/users.js'
        ],
        'public/js/users.js'
    );

    /**
     * Restrictions
     */
    mix.scripts(
        [
            'modules/restrictions/main.js',
        ],
        'public/js/modules/restrictions.js'
    );

    /**
     * Violations
     */
    mix.scripts(
        [
            'modules/violations/violations.js',
        ],
        'public/js/modules/violations.js'
    );

    mix.scripts(
        [
            'show_notification_violation.js',
        ],
        'public/js/show_notification_violation.js'
    );

    mix.scripts(
        [
            'modules/companies/main.js',
        ],
        'public/js/modules/companies.js'
    );
    mix.scripts(
        [
            'modules/tracked_objects/drivers.js',
        ],
        'public/js/modules/drivers.js'
    );

    mix.scripts(
        [
            'modules/installer/installer.js',
        ],
        'public/js/modules/installer.js'
    );

    mix.scripts(
        [
            'modules/profile/main.js',
        ],
        'public/js/modules/profile.js'
    );
    mix.scripts(
        [
            'locale/set_locale.js',
        ],
        'public/js/set_locale.js'
    );

    /**
     * Data-tables
     */
    mix.scripts(
        [
            'data-tables.js',
        ],
        'public/js/data-tables.js'
    );

    // =========
    mix.scripts(
        [
            'modules/sharedReminders/sharedReminders.js',
        ],
        'public/js/modules/sharedReminders.js'
    );

    /**
     * Define marker icons
     */
    mix.scripts(
        [
            'define-icons.js'
        ],
        'public/js/define-icons.js'
    );


    mix.stylesIn(
        'resources/assets/css', // source folder on server
        'public/css/app.css'    // destination folder
    );

    mix.styles([
        "../leaflet/libs/leaflet.css",
        "../leaflet/css/popup.css",
        "../leaflet/css/fullscreen.css",
        "../leaflet/dist/leaflet.draw.css",
        "../leaflet/addons/geosearch/css/l.geosearch.css",
        "../leaflet/addons/labels/css/leaflet.label.css"
        ],
        'public/css/leaflet.css'
    );

    mix.copy('resources/assets/css/patterns/', 'public/css/patterns/');
    mix.copy('resources/assets/img/', 'public/img/');
    mix.copy('resources/assets/font-awesome', 'public/font-awesome/');
    mix.copy('resources/assets/leaflet', 'public/leaflet/');

    mix.scripts(
        ['../../../node_modules/socket.io/node_modules/socket.io-client/socket.io.js'],
        'public/js/socket.io.js'
    );

    mix.scripts(
        ['socket.js'],
        'public/js/socket.js'
    );

    mix.scripts(['socket/socket.io.event.handler.js'], 'public/js/socket_event_handler.js');

    mix.scripts(['moment.min.js', 'moment-duration-format.js'])

    elixir(function(mix) {
        mix.browserSync(
            {proxy: 'netfleet.dev'}
        );
    });
});