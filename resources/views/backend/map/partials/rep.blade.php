<script type="text/javascript">
/*
 * Define all map related vars/config vars
 */
var map;


$(function(){

    /*
     * Create a map object
     */
    map = new L.Map('map',
    {
        center: new L.LatLng(defMap['center']['lat'], defMap['center']['lng']),
        zoom: defMap['zoom'],
    });

    /*
     * Setup tile layers
     */
    var osm_roadmap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution:'Map data &copy; <a href="http://openstreetmap.org">OSM</a>',
            maxZoom: 18
        });
    var ggl_roadmap = L.tileLayer('https://mt{s}.google.com/vt/v=w2.106&x={x}&y={y}&z={z}',
        {
            subdomains:'0123', attribution:'&copy; Google'
        });
    var ggl_satellite = L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}',
        {
            subdomains:'0123',
            attribution:'&copy; Google'
        });
    var mapbox_roadmap = L.tileLayer("https://{s}.tiles.mapbox.com/v3/ptodorov.j665bhnm/{z}/{x}/{y}.png");
    var mapbox_satellite = L.tileLayer("https://{s}.tiles.mapbox.com/v3/ptodorov.j6691pdp/{z}/{x}/{y}.png",
        {
            maxZoom: 18
        });

    var defaultTileLayer = osm_roadmap;
    map.addLayer(defaultTileLayer);




    var baseMaps = {
        'Пътна карта':osm_roadmap,
        'Google Пътна':ggl_roadmap,
        'Google Сателитна':ggl_satellite,
        'Mapbox Пътна':mapbox_roadmap,
        'Mapbox Сателитна':mapbox_satellite
    };

    /*
     * Layers control
     */
    if (defMap['layersConrol'])
    {
        map.addControl(new L.Control.Layers(baseMaps, false,
        {
            collapsed: true
        }));
    }


</script>
