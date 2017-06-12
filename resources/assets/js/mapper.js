var app = app || {};

app.mapper = (function (selector, multipleAreas) {
    Mapper.prototype.mapControls  = [];
    Mapper.prototype.markers = [];
    Mapper.prototype.areaFormData = false;
    Mapper.prototype.multipleAreas = false;
    Mapper.prototype.tileLayers = {
        osm_roadmap: {
            tile: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            options: {
                attribution:'Map data &copy; <a href="http://openstreetmap.org">OSM</a>',
                maxZoom: 18
            },
            restrictionMapName: "Open Street Map Roadmap"
        },
        mapbox_roadmap: {
            tile: "https://{s}.tiles.mapbox.com/v3/ptodorov.j665bhnm/{z}/{x}/{y}.png",
            options: {},
            restrictionMapName: "MapBox Roadmap"
        },
        ggl_roadmap: {
            tile: 'https://mt{s}.google.com/vt/v=w2.106&x={x}&y={y}&z={z}',
            options: {
                subdomains:'0123', attribution:'&copy; Google'
            },
            restrictionMapName: "Google Roadmap"
        },
        ggl_satellite: {
            tile: 'https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}',
            options: {
                subdomains:'0123', attribution:'&copy; Google'
            },
            restrictionMapName: "Google Satellite"
        }
    };

    Mapper.prototype.drawControl = false;
    Mapper.prototype.fullscreenControl = false;
    Mapper.prototype.toggleMeasureControl = false;

    /**
     * Mapper constructoer
     * @param {string} selector      Unique map selector
     * @param {boolean} multipleAreas Allow multiple areas on the map
     */
    function Mapper(selector, multipleAreas) {
        this.initMap(selector, this.tileLayers, this.mapControls, multipleAreas);
    }

    Mapper.prototype.delegateMapDrawEvents = function (featureGroup, multiple) {
        this.map.on('draw:created', function(event)
        {
            var layer = event.layer;
            featureGroup.addLayer(layer);
            Mapper.prototype.processAreaFormData(featureGroup);
        });
        this.map.on('draw:edited', function (event)
        {
            var layers = event.layers;
            layers.eachLayer(function (layer)
            {
                // loadCoordinatesField(layer);
                featureGroup.addLayer(layer);
            });
            Mapper.prototype.processAreaFormData(featureGroup);
        });

        this.map.on('draw:deleted', function(event)
        {
            if (!multiple) {
                featureGroup.clearLayers();
            }
            Mapper.prototype.processAreaFormData(featureGroup);
        });

        this.map.on('draw:drawstart', function(event)
        {
            if (!multiple) {
                featureGroup.clearLayers();
            }
        });
    };

    Mapper.prototype.map = false;
    Mapper.prototype.mapCenter = [42.687865366313616, 23.31452786922455];
    Mapper.prototype.mapZoom = 13;
    Mapper.prototype.featureGroup = false;


    Mapper.prototype.initMap = function (selector, tileLayers, mapControls, multipleAreas) {
        this.setMap(selector);
        this.addTiles(this.map, tileLayers);
        this.addTileControl(this.map, tileLayers, mapControls);
        this.setFeatureGroup();
        this.multipleAreas = multipleAreas;
        this.delegateMapDrawEvents(this.featureGroup, multipleAreas);
        this.handleMapResizeEvents();
        this.initRemoveAllDrawnLayers();
    };

    Mapper.prototype.processAreaFormData = function (featureGroup) {
        var areaFormData = [];

        var layers =  featureGroup.getLayers();

        $.each(layers, function(n, layer) {
            var latLng = [];
            if (layer["getRadius"] != undefined) {
                var circleLatLng = layer.getLatLng();
                areaFormData.push({lat : circleLatLng.lat, lng : circleLatLng.lng, radius: layer.getRadius()});
                return;
            }
            if (layer["getLatLngs"] != undefined) {
                areaFormData.push(layer.getLatLngs());
            } else {
                areaFormData.push(layer.getLatLng());
            }
        });

        return this.areaFormData = areaFormData;
    };
    Mapper.prototype.displayFitAreas = function () {
        if (this.featureGroup.getLayers().length > 0) {
            this.map.fitBounds(this.featureGroup.getBounds());
        }
    }
    Mapper.prototype.handleMapResizeEvents = function () {
        $(document).on('map-container-resize', function (e, map) {
            if (map) {
                map.invalidateSize();
            }
        });
    }
    Mapper.prototype.initRemoveAllDrawnLayers = function () {
        L.Control.RemoveAll = L.Control.extend({
            options: {
                position: 'topleft',
            },

            onAdd: function (map) {
                var controlDiv = L.DomUtil.create('div', 'leaflet-control-remove-all');
                L.DomEvent
                    .addListener(controlDiv, 'click', L.DomEvent.stopPropagation)
                    .addListener(controlDiv, 'click', L.DomEvent.preventDefault)
                .addListener(controlDiv, 'click', function () {
                    drawnItems.clearLayers();
                });

                var controlUI = L.DomUtil.create('div', 'leaflet-control-remove-all-interior', controlDiv);
                controlUI.title = 'Remove All Polygons';
                return controlDiv;
            }
        });

        var removeAllControl = new L.Control.RemoveAll();
        this.map.addControl(removeAllControl);
    }

    Mapper.prototype.drawControlOptions = function (featureGroup) {
        return {
            position: 'topleft',
            draw: {
                marker: false,
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
                featureGroup: featureGroup
            }
        };
    }

    Mapper.prototype.setFeatureGroup = function () {
        featureMap = this.map;
        this.featureGroup = this.featureGroup || L.featureGroup().addTo(featureMap);
    }

    /**
     * [toggles drawing options on the map]
     * @param  {boolean} on turn it on or off
     * @return {L.Control.Layers}    layer control
     */
    Mapper.prototype.toggleDrawControl = function (on) {
        if (on) {
            this.drawControl = new L.Control.Draw(this.drawControlOptions(this.featureGroup), {
                edit: {
                    featureGroup: this.featureGroup
                }
            });

            this.map.addControl(this.drawControl);
        } else if (this.drawControl && !on) {
            this.map.removeControl(this.drawControl);
            this.drawControl = false;
        }

        return this.drawControl;
    }

    Mapper.prototype.toggleFullscreenControl = function (on) {
        if (on) {
            this.fullscreenControl = new L.Control.FullScreen();
            this.map.addControl(this.fullscreenControl);
        } else if (this.fullscreenControl || !on) {
            this.map.removeControl(this.fullscreenControl);
        }

        return this.fullscreenControl;
    }

    Mapper.prototype.toggleMeasureControl = function (on) {
        if (on) {
            this.measureControl = new L.Control.measureControl();
            this.map.addControl(this.measureControl);
        } else if (this.measureControl || !on) {
            this.map.removeControl(this.measureControl);
        }

        return this.measureControl;
    }

    Mapper.prototype.setMap = function(selector) {
        this.map = L.map(selector).setView(this.mapCenter, this.mapZoom);
    }

    Mapper.prototype.addTiles = function(mapObject, tileLayers) {
        var baseMaps = [];

        $.each(tileLayers, function (n, elem) {
            var newLayer = L.tileLayer(elem.tile, elem.options);

            baseMaps[elem.restrictionMapName] = newLayer;
        });
        mapObject.addLayer(baseMaps['Open Street Map Roadmap']);
        this.mapControls = baseMaps;
    }

    Mapper.prototype.addTileControl = function (map, tileLayers) {
        map.addControl(new L.Control.Layers(this.mapControls, false,
        {
            collapsed: true
        }));
    }

    Mapper.prototype.drawPolygon = function (latitudeLongitudeGeoPoints) {
        var area = L.polygon(latitudeLongitudeGeoPoints);
        this.displayArea(area);
    }

    Mapper.prototype.drawCircle = function (center, radius) {
        if (center[0] !== undefined) {
            center = center[0];
        }

        var area = L.circle(center, radius);
        this.displayArea(area);
    }

    Mapper.prototype.drawPolyline = function (latLngs, options) {
        var route = L.polyline(latLngs, options);
        this.displayArea(route);

        return route;
    }

    Mapper.prototype.displayArea = function (area) {
        var added = this.featureGroup.addLayer(area);
    }

    /**
     * setters and getters
     * @param {[type]} area [description]
     */
    Mapper.prototype.getAreas = function () {
        return this.featureGroup;
    }

    Mapper.prototype.setRadius = function(radius) {
        return this.radius = radius;
    };

    Mapper.prototype.getRadius = function(radius) {
        return this.radius;
    };

    Mapper.prototype.setCenter = function(center) {
        return this.center = center;
    };

    Mapper.prototype.getCenter = function() {
        return this.center;
    };

    Mapper.prototype.setCoordinates = function(coordinates) {
        return this.coordinates = coordinates;
    };

    Mapper.prototype.getCoordinates = function () {
        return this.coordinates;
    }

    Mapper.prototype.getAreaFormData = function () {
        return this.areaFormData;
    }

    Mapper.prototype.clearAreas = function ()
    {
        return this.featureGroup.clearLayers();
    }

    Mapper.prototype.clearMarkers = function ()
    {
        if (this.markers.length > 0) {
            $.each(this.markers, function(n, marker) {
                mapper.map.removeLayer(marker);

                this.markers = [];
            });
        }
    }

    Mapper.prototype.addMarker = function (latLng, options)
    {
        if (options === undefined) {
            options = {};
        }

        var marker = L.marker(latLng, options).addTo(this.map);

        this.markers.push(marker);
    }

    Mapper.prototype.fitFeatureGroupBounds = function ()
    {
        this.map.fitBounds(this.featureGroup.getBounds());
    }

    return {
        load: function (selector, multipleAreas, options) {
            return new Mapper(selector, multipleAreas);
        }
    }
}());

$(app.mapper).on('container-resize', function (event) {
    mapper.map.updateSize();
});

