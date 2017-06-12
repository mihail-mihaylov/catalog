
<script type="text/javascript">
var defMap = $.parseJSON('{!! $map !!}');
console.log(defMap);
/*
 * Define all map related vars/config vars
 */
var map,bounds;


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

	if(defMap['drawingControl'])
	{
		var drawnItems = L.featureGroup().addTo(map);
		map.addControl(new L.Control.Draw(
		{
			edit: {
				featureGroup: drawnItems
			}
		}));

		map.on('draw:created', function(event)
		{
			var layer = event.layer;
			drawnItems.addLayer(layer);
		// console.log(layer['_latlngs'][0]['lat']);
		});
	}

	/*
	 * Fullscreen control (uses leaflet.fullscreen.js)
	 */
	if (defMap['fullScreenControl'])
	{
	    var fullScreen = new L.Control.FullScreen();
	    map.addControl(fullScreen);
	}

	/*
	 * Measure control (uses leaflet.measure.js)
	 */
	if (defMap['measureControl'])
	{
	    var measureControl = L.Control.measureControl();
	    map.addControl(measureControl);
	}

	renderMarkers();
	/*
	 * Markers Layer
	 */
	 function renderMarkers()
	 {
	 	if(defMap['markers'] && defMap['markers'].length)
		{
		    var markers = defMap['markers'];
		    var markersArray = [];

		    for (var n in markers) {

		    	/*
				 * Define icon
				 */
		    	var markerIcon = L.icon({
				    iconUrl: markers[n]['icon']['iconUrl'],
				    iconRetinaUrl: markers[n]['icon']['iconRetinaUrl'],
				    iconSize: [markers[n]['icon']['iconSize'][0], markers[n]['icon']['iconSize'][1]],
				    iconAnchor: [markers[n]['icon']['iconAnchor'][0], markers[n]['icon']['iconAnchor'][1]],
				    popupAnchor: [markers[n]['icon']['popupAnchor'][0], markers[n]['icon']['popupAnchor'][1]],
				    shadowUrl: markers[n]['icon']['shadowRetinaUrl'],
				    shadowRetinaUrl: markers[n]['icon']['shadowRetinaUrl'],
				    shadowSize: [markers[n]['icon']['shadowSize'][0], markers[n]['icon']['shadowSize'][1]],
				    shadowAnchor: [markers[n]['icon']['shadowAnchor'][0], markers[n]['icon']['shadowAnchor'][1]]
				});

		        var marker = L.marker([markers[n]['latLng']['lat'], markers[n]['latLng']['lng']],
		            {
		                icon: markerIcon,
		                title: markers[n]['title']
		            });
		        markersArray.push(marker);
		    }

		    var markersLayer = L.layerGroup(markersArray);
		    map.addLayer(markersLayer);
		}
	 }


	/*
	 * Shapes Layer
	 */
	var shapes = defMap['shapes'];
	var shapesArray = [];
	// console.log(shapes['rectangles'][0]['coordinates']);
	renderShapes();

	function renderShapes(){

	 	for (var n in shapes) {

	 		switch (n) {
				case 'polylines':
					if(shapes['polylines'] && shapes['polylines'].length){
						renderPolylines();
					}
					break;
				case 'polygons':
					if(shapes['polygons'] && shapes['polygons'].length){
						renderPolygons();
					}
					break;
				case 'rectangles':
					if(shapes['rectangles'] && shapes['rectangles'].length){
						renderRectangles();
					}
					break;
				case 'circles':
					if(shapes['circles'] && shapes['circles'].length){
						renderCircles();
					}
					break;
			}

		}

		// console.log(shapesArray);
		var shapesLayer = L.layerGroup(shapesArray);
	    map.addLayer(shapesLayer);
	}

	function renderPolylines(){
			for (var n in shapes['polylines']) {
			var polyline = L.polyline(shapes['polylines'][n]['coordinates'],
	        {
	            weight: shapes['polylines'][n]['shapeOptions']['weight'],
	            color: shapes['polylines'][n]['shapeOptions']['color'],
	            opacity: shapes['polylines'][n]['shapeOptions']['opacity']
	        });
			shapesArray.push(polyline);
		}
	}

	function renderPolygons(){
			for (var n in shapes['polygons']) {
			var polygon = L.polygon(shapes['polygons'][n]['coordinates'],
	        {
	            weight: shapes['polygons'][n]['shapeOptions']['weight'],
	            color: shapes['polygons'][n]['shapeOptions']['color'],
	            opacity: shapes['polygons'][n]['shapeOptions']['opacity']
	        });
			shapesArray.push(polygon);
		}
	}

	function renderRectangles(){
			for (var n in shapes['rectangles']) {
			var rectangle = L.rectangle(shapes['rectangles'][n]['coordinates'],
	        {
	            weight: shapes['rectangles'][n]['shapeOptions']['weight'],
	            color: shapes['rectangles'][n]['shapeOptions']['color'],
	            opacity: shapes['rectangles'][n]['shapeOptions']['opacity']
	        });
			shapesArray.push(rectangle);
		}
	}

	function renderCircles(){
			for (var n in shapes['circles']) {
			var circle = L.circle(shapes['circles'][n]['coordinates'], shapes['circles'][n]['radius'],
	        {
	            weight: shapes['circles'][n]['shapeOptions']['weight'],
	            color: shapes['circles'][n]['shapeOptions']['color'],
	            opacity: shapes['circles'][n]['shapeOptions']['opacity']
	        });
			shapesArray.push(circle);
		}
	}

	// drawSubtrip();
	console.log($.parseJSON('{!! $trips !!}'));
	// alert(moment.unix('1448431593').format('HH:mm'));

	function drawSubtrip() {  //subtrip, i

		var data = $.parseJSON('{!! $trips !!}');
		// Polyline points for the current subtrip
	    var polypoints = [];

		$.each(data.markers, function(index, marker)
		{
		    console.log(data.markers);
		    var loc = new L.LatLng(marker.latLng.lat, marker.latLng.lng);

		    // Push location to polyline points array
            polypoints.push(loc);

            // var time = new Date(parseInt(point.gps_timestamp)*1000);

            // var time_m = moment.unix(parseInt(point.gps_timestamp));

            bounds.extend(loc);

            // If the point is a parking point
            if(point.parking==1)
            {

            }
		})


	}

});

</script>
