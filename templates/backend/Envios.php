{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
{% endblock %}


{% block content %}
<body>
   <div id="contentwrap" style="height: 550px">
       <label for="day-input" style = "display : block" >Seleccione dia: </label>
       <input id="day-input" name="day-input" style="margin: 10px;"/> <button id="refresh-date" style="float: left;">Aceptar</button>
        <div id="content" style="height:420px;width: 512px;"></div>
        <label for="generate-route" style="display: block" >Ruta de envios</label>
        <button type="button" id="generate-route">Generar recorrido</button>
   </div>
   <div id="content" class="tabla-class" >
       <table id="tabla-pedidos">
           <thead>
               <tr>
                   <th>Entidad Receptora</th>
                   <th>Fecha de entrega</th>
                   <th>Telefono</th>
                   <th>Domicilio</th>
                   <th>Estado entrega</th>
                   <th>Detalle Pedido</th>
               </tr>
            </thead>
       </table>
   </div>
</body>
{% endblock %}


{% block scripts %}
<script src="{{server}}js/plugins/OpenLayers.js"></script>
<script type="text/javascript">
        var zoom = 13;
        routeParams = "";
        function mapInit() {
            var map = new OpenLayers.Map({
                div: 'content',
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
        
        map = mapInit();
        route = new OpenLayers.Layer.Vector("route");
        map.addLayer(route);
        fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
        var lat = -34.910531;
        var lon = -57.950203;
        zoom = 13;
        position = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
        map.setCenter(position, zoom);
        
        
        
        
        
        function EntidadReceptora(nombre, lat, lon){
             this.nombre=nombre;
             this.lat = lat;
             this.lon = lon;
             this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
             return this;
        }
        home_base = new EntidadReceptora('Banco', -34.910531, -57.950203);
          
          
          
          
    $(document).ready(function () {
        button_row = 'td:eq(5)'; // row donde se pone el boton "ver detalle" de la tabla
        tabla = $("#tabla-pedidos").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) { // CALLBACK cuando se crea row
                $(button_row, nRow).append("<button>Ver Detalle</button>"); // trigger que se activa
                // cuando se genera una nueva linea en la tabla, deberia agregar el boton de Ver Detalle
           }
        });

        function refreshTabla(tabla, data) {
                
                tabla.clear();
                tabla.row.add(data);
                tabla.draw();
            
        }
        function refreshMap(entidades) {
                
                 function crearMarcador(entidad) {
                      var icono = new OpenLayers.Icon("/images/icons/pin.png");
                      icono.size.w *=2;
                      icono.size.h *=2;
                      icono.title = entidad.nombre;
                      var lugar=  entidad.dire;
                      var marcador = new OpenLayers.Marker(lugar, icono);
                      return marcador;
                   }

                var markers = new OpenLayers.Layer.Markers( "Marcadores" );
                map.addLayer(markers);
                markers.addMarker(crearMarcador(home_base));
                routeParams += "loc="+home_base.lat+","+home_base.lon+"&"; // HOME ADDRESS
                for(var i = 0; i <entidades.length; i++) {
                                    console.log(entidades[i]);
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
            //map.addControl(new OpenLayers.Control.LayerSwitcher({}));
        };
        
        
     
        
        
        $('#day-input').datepicker();
        
        $("#refresh-date").on("click", function () {
            $.post('index.php',{ date: $('#day-input').val() }, function(json_object, status, xhr) {
                
                var tablaData = {
                    razonSocial: json_object['entidad_receptora']['razonSocial'],
                    domicilio: json_object['entidad_receptora']['domicilio'],
                    telefono: json_object['entidad_receptora']['telefono'],
                    fecha_entrega: json_object['turno']['date'],
                    estado_entrega: json_object['pedido']['estado'],
                    button: ""
                };
                var dataArray = $.map(tablaData, function(value, index) {
                    return [value];
                });
                console.log(dataArray);
                refreshTabla(tabla, dataArray);
                lon = json_object['banco']['long'];
                lat = json_object['banco']['lat'];
                
                refreshMap([new EntidadReceptora(json_object['entidad_receptora']['razonSocial'],
                            json_object['entidad_receptora']['lat'], 
                            json_object['entidad_receptora']['long'])]);
            }, 'json');            
        });
        $("#generate-route").on("click", function () {
            $.ajax({
                url: "https://router.project-osrm.org/viaroute?z=13&output=json&jsonp=OSRM.JSONP.callbacks.route&"
                        +routeParams+"instructions=true&compression=false",
                dataType: "jsonp",
                jsonp: "jsonp",
                cache: true,
                success: parseRoute
            });
        });
        
        



        


            
    });
</script>

{% endblock %}
