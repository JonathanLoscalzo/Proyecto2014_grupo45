        function mapInit() {
            var map = new OpenLayers.Map({
                div: 'map',
                controls: [
                    new OpenLayers.Control.Attribution(),
                    new OpenLayers.Control.TouchNavigation({
                        dragPanOptions: {
                            enableKinetic: true
                        }
                    }),
                    new OpenLayers.Control.Zoom()
                ],
                layers: [
                    new OpenLayers.Layer.OSM()
     
                ]
            });
            return map;
        }
        
        function crearMarcador(entidad) {
              var icono = new OpenLayers.Icon("/images/icons/pin.png");
              icono.size.w *=2;
              icono.size.h *=2;
              icono.title = entidad.nombre;
              var lugar=  new OpenLayers.LonLat(entidad.lon, entidad.lat).transform( fromProjection, toProjection);
              var marcador = new OpenLayers.Marker(lugar, icono);
              return marcador;
           }
                   
        
        function refreshMap(banco, entidades) {
                
        
                zoom = 13;
                position = new OpenLayers.LonLat(banco.long, banco.lat).transform( fromProjection, toProjection);
                map.setCenter(position, zoom);
                 
                
                var markers = new OpenLayers.Layer.Markers( "Marcadores" );
                
                
                map.addLayer(markers);
                
                markers.addMarker(crearMarcador(new EntidadReceptora(banco.nombre, banco.lat, banco.long)));
                routeParams += "loc="+banco.lat+","+banco.long+"&"; // HOME ADDRESS
                for(var i = 0; i <entidades.length; i++) {
                                    markers.addMarker(crearMarcador(entidades[i]));
                                    routeParams += "loc="+entidades[i].lat+","+entidades[i].lon+"&";

                }
                var bounds = markers.getDataExtent();
                map.zoomToExtent(bounds);
         }
         
        function parseRoute(waypoints) {
            var route_style = {
                strokeColor: "#0000ff",
                strokeOpacity: 6,
                strokeWidth: 2
            };
            var array_coordenadas = [];
            for (i=0; i< waypoints.route_geometry.length; i++) {
                
                var coordenada = new OpenLayers.Geometry.Point(waypoints.route_geometry[i][1], waypoints.route_geometry[i][0])
                        .transform( fromProjection, toProjection);
                array_coordenadas.push(coordenada);
            }
            var lineString = new OpenLayers.Geometry.LineString(array_coordenadas);
            var lineVector = new OpenLayers.Feature.Vector(lineString, null, route_style);
            route.addFeatures([lineVector]);
            map.addControl(new OpenLayers.Control.LayerSwitcher({}));
        };
