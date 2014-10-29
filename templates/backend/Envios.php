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
                       <td><button>Ver Detalle</button></td>
                   </tr>
               </tbody>
       </table>
   </div>
</body>
{% endblock %}


{% block scripts %}
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        tabla = $("#tabla-pedidos").DataTable();
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
        //map.setCenter(, zoom);
        function refreshTabla(tabla, data) {
                
                tabla.row.add([data['razonSocial'],data['fecha_entrega'],data['telefono'],data['domicilio'],data['estado_entrega'],]).draw();
            
        }
        function refreshMap(json_object) {
                OpenLayers.Layer.Markers.clearMarkers();
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
         }
        
       
        
        
        function EntidadReceptora(nombre, lat, lon, tipo){
             this.nombre=nombre;
             this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
             return this;
        }
        
        
        
        $('#day-input').datepicker();
        $("#refresh-date").on("click", function () {
            $.post('index.php',{ date: $('#day-input').val() }, function(json_object, status, xhr) {
                console.log(json_object);
                var tableData = {};
                tableData['razonSocial'] = json_object['entidad_receptora']['razonSocial'];
                tableData['domicilio'] = json_object['entidad_receptora']['domicilio'];
                tableData['telefono'] = json_object['entidad_receptora']['telefono'];
                tableData['fecha_entrega'] = json_object['turno']['date'];
                tableData['estado_entrega'] = json_object['pedido']['estado'];
                tabla.clear();
                tabla.rows.add(tableData);
                tabla.draw();
                //refreshMap(json_object);
                
            }, 'json');            
        });
        



        


            
    });
</script>

{% endblock %}
