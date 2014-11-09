{% extends "backend_layout.php" %}
{% block head %}
<link href="{{server}}css/bootstrap/css/bootstrap.css" rel="stylesheet">
{{ parent() }}
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<link href="{{server}}/js/plugins/jquery-ui/jquery-ui.css" rel="stylesheet" rel="stylesheet">
<script src="{{server}}js/plugins/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
{% endblock %}


{% block content %}
<body>
   <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <label for="day-input" style = "display : block" >Seleccione dia: </label>
                    <input id="day-input" name="day-input"/> <button id="refresh-date" style="float: left;">Aceptar</button>
                </div>
                 <div class="col-md-8">
                          <div id="map" style="height: 400px; width: 400px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></div>
                          <label for="generate-route" style="display: block" >Ruta de envios</label>
                          <button type="button" id="generate-route">Generar recorrido</button>

                 </div>
             </div>
        </div>
   <div id="content" class="tabla-class" >
       <table id="tabla-pedidos">
           <thead>
               <tr>
                   <th>Entidad Receptora</th>
                   <th>Fecha de entrega</th>
                   <th>Telefono</th>
                   <th>Domicilio</th>
                   <th>Detalle Pedido</th>
                   <th>Despachar</th>
               </tr>
            </thead>
       </table>
   </div>
       <div style="display: block">
           <button id="confirmar_envios" name="confirmar" type="submit" style="float: left;">Confimar</button>
       </div>
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
        
        map = mapInit();
        route = new OpenLayers.Layer.Vector("route");
        map.addLayer(route);
        fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
        $.get("index.php",{getHomePosition: true}, function (data) {
            zoom = 13;
            position = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
            map.setCenter(position, zoom);
        }, "json");
        
        
        
        
        
        
        function EntidadReceptora(nombre, lat, lon){
             this.nombre=nombre;
             this.lat = lat;
             this.lon = lon;
             this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
             return this;
        }
        home_base = new EntidadReceptora('Banco', -34.910531, -57.950203);
          
          
          
          
    $(document).ready(function () {
        button_row = 'td:eq(4)'; // row donde se pone el boton "ver detalle" de la tabla
        checkbox_row = 'td:eq(5)';
        tabla = $("#tabla-pedidos").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) { // CALLBACK cuando se crea row
                $(button_row, nRow).append("<button>Ver Detalle</button>"); // trigger que se activa
                $(checkbox_row, nRow).append('<input type="checkbox" id="someCheckbox" name="someCheckbox" />');
                 // cuando se genera una nueva linea en la tabla, deberia agregar el boton de Ver Detalle
           }
        });

        function refreshTabla(tabla, data) {
                
                tabla.clear();
                tabla.rows.add(data);
                tabla.draw();
     
            
        }
        function refreshMap(banco, entidades) {
                 zoom = 13;
                 position = new OpenLayers.LonLat(banco.lon, banco.lat).transform( fromProjection, toProjection);
                 map.setCenter(position, zoom);
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
                routeParams += "loc="+banco.lat+","+banco.long+"&"; // HOME ADDRESS
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
        
        $("#refresh-date").on("blur", function () {
            $.post('index.php',{ date: $('#day-input').val() }, function(data, status, xhr) {
                console.log(data);
                zoom = 13;
                position = new OpenLayers.LonLat(data.banco.long, data.banco.lat).transform( fromProjection, toProjection);
                map.setCenter(position, zoom);
                var tablaData = [];
                var entidades = [];
                for (i=0; i<data.pedidos.length; i++) {
                    tablaData.push( {
                    entidad_receptora: data.pedidos[i].entidad_receptora_model.razonSocial,
                    fecha_entrega: data.pedidos[i].turno_entrega_model.fecha,
                    domicilio: data.pedidos[i].entidad_receptora_model.domicilio,
                    telefono: data.pedidos[i].entidad_receptora_model.telefono,
                    button: "",
                    ckeckbox: ""});
                
                
                    entidades.push(new EntidadReceptora(data.pedidos[i].entidad_receptora_model.razonSocial,
                    data.pedidos[i].entidad_receptora_model.latitud, 
                    data.pedidos[i].entidad_receptora_model.longitud));
                    
                    
                };
                
                var dataArray = $.map(tablaData, function(value, index) {
                    return [value];
                });
                console.log(dataArray);
                refreshTabla(tabla, dataArray);
                
                
                refreshMap(data.banco, entidades);
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
