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
       <label for="expiration" style = "display : block" >Seleccione dia: </label>
       <input id="day-input" name="day-input" style="margin: 10px;"/> <button id="refresh-date" style="float: left;">Aceptar</button>
        <div id="content" style="height:320px;width: 320px;"></div>
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
               <tbody style="text-align: center">
                   <tr>
                       <td>Entidad Cacho</td>
                       <td>12-05-2014 12:23</td>
                       <td>42411111</td>
                       <td>4921112</td>
                       <td>No Entregado</td>
                       <td></td>
                   </tr>
               </tbody>
       </table>
   </div>
</body>
{% endblock %}


{% block scripts %}
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript">
        var zoom = 13;
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
        var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        var toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
        var lat = -34.910531;
        var lon = -57.950203;
        zoom = 13;
        position = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
        map.setCenter(position, zoom);
        
          
    $(document).ready(function () {
        button_row = 'td:eq(5)';
        tabla = $("#tabla-pedidos").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
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
                for(var i = 0; i <entidades.length; i++) {
                                    markers.addMarker(crearMarcador(entidades[i]));

                 }
                 var bounds = markers.getDataExtent();
                 map.zoomToExtent(bounds);
         }
        
       
        
        
        function EntidadReceptora(nombre, lat, lon){
             this.nombre=nombre;
             this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
             return this;
        }
        
        
        
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
                
                refreshMap([new EntidadReceptora(json_object['entidad_receptora']['nombre'],
                            json_object['entidad_receptora']['lat'], 
                            json_object['entidad_receptora']['long'])]);
            }, 'json');            
        });
        



        


            
    });
</script>

{% endblock %}
