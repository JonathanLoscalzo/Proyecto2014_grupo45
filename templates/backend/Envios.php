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
                <div class="col-md-3">
                    <label for="day-input" style = "display : block" >Seleccione dia: </label>
                    <input id="day-input" name="day-input"/> <button id="refresh-date" style="float: left;">Aceptar</button>
                </div>
                 <div class="col-md-6">
                          <div id="map" style="height: 400px; width: 400px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></div>
                          <label for="generate-route" style="display: block" >Ruta de envios</label>
                          <button type="button" id="generate-route">Generar recorrido</button>

                 </div>
                <div class="col-md-3" >
                    <h3>El tiempo en ruta</h3>
                    <div id="weather-iframes">
                        
                    </div>
                    
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
<script src="{{server}}js/scripts/mapHandler.js"></script>
<script type="text/javascript">
        

        stations = '';
        map = mapInit();
        route = new OpenLayers.Layer.Vector("route");
        map.addLayer(route);
        fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
        
        
        
        
        
        
        function EntidadReceptora(nombre, lat, lon){
             this.nombre=nombre;
             this.lat = lat;
             this.lon = lon;
             this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
             return this;
        }
          
          
          
          
    $(document).ready(function () {
        button_row = 'td:eq(4)'; // row donde se pone el boton "ver detalle" de la tabla
        checkbox_row = 'td:eq(4)';
        tabla = $("#tabla-pedidos").DataTable({
            paging: false,
            searching: false,
            stateSave: false,
           "fnCreatedRow": function( nRow, aData, iDataIndex ) { // CALLBACK cuando se crea row
                $(checkbox_row, nRow).append('<input class="checkbox" type="checkbox" name="checkbox" />');
                 // cuando se genera una nueva linea en la tabla, deberia agregar el boton de Ver Detalle
           }
        });

        function refreshTabla(tabla, data) {
                
                tabla.clear();
                for (i=0;i<data.length; i++) { 
                    tabla.row.add(data[i]);
                }
                tabla.draw();
     
            
        }
                   
         
         

        $('#day-input').datepicker();
        
        $("#refresh-date").on("click", function () {
            $.post('index.php',{ date: $('#day-input').val() }, function(data, status, xhr) {
                
                routeParams = "";
                console.log(data);
                zoom = 13;
                window.pedidos_index = data.pedidos;
                position = new OpenLayers.LonLat(data.banco.long, data.banco.lat).transform( fromProjection, toProjection);
                map.setCenter(position, zoom);
                
                var tablaData = [];
                var entidades = [];
                var dataArray = [];
                
                for (i=0; i<data.pedidos.length; i++) {
                    
                    
                    tablaData.push( {
                    razonSocial: data.pedidos[i].entidad_receptora_model.razonSocial,
                    fecha_entrega: data.pedidos[i].turno_entrega_model.fecha,
                    telefono: data.pedidos[i].entidad_receptora_model.telefono,
                    domicilio: data.pedidos[i].entidad_receptora_model.domicilio,
                    button: "",
                    ckeckbox: ""});
                
                
                    entidades.push(new EntidadReceptora(data.pedidos[i].entidad_receptora_model.razonSocial,
                    data.pedidos[i].entidad_receptora_model.latitud, 
                    data.pedidos[i].entidad_receptora_model.longitud));
                    dataArray.push($.map(tablaData[i], function(value, index) {
                        return [value];
                    }));
                    
                };
                refreshTabla(tabla, dataArray);
                stations = entidades;
                routeParams = refreshMap(data.banco, entidades, routeParams); // regenera la ruta
                $("#weather-iframes").html(""); // clear old iframes (if any)
                $.post('/envios', { weather_entidades : JSON.stringify(entidades) }, function(data, status, xhr) {
                        alert("weather_being_processed_test");
                        $("#weather-iframes").append(data);
                    }, "html"); 
               
               
            }, 'json');
            
        });
        $("#generate-route").on("click", function () { // traza el mapa cuando se aprieta el boton
            $.ajax({
                url: "https://router.project-osrm.org/viaroute?z=13&output=json&jsonp=OSRM.JSONP.callbacks.route&"
                        +routeParams+"instructions=true&compression=false",
                dataType: "jsonp",
                jsonp: "jsonp",
                cache: true,
                success: parseRoute
            });
        });
        
        $("#confirmar_envios").on("click", function () {
            if ($("#tabla-pedidos").children('td').eq(5).is(':checked')) {
                var pedido_id = $("#tabla-pedidos").children('td').attr("id");
            };
            
            var id_array = [];
            $('#tabla-pedidos tr').each(function (i, row) {
                if ($(row).find('input:checked').length > 0) {
                    id_array.push($(row).index());
                }
            });
            enviados_array = [];
            if (id_array.length > 0) {
                for (i=0; i<id_array.length; i++) {  // obtenemos los pedidos seleccionados
                // con el checkbox en la dataTable y los insertamos en un array //
                    enviados_array.push(window.pedidos_index[i].numero);
                }
                $.post("index.php", {sendEnvios: JSON.stringify(enviados_array)}, function(data) {
                    alert("Se han despachado los pedidos correctamente");
                    window.location.reload(true);
                });
            }
            else {
                alert("Por favor seleccione algun producto para despachar");
            }
         
            
        });
            
    });
</script>

{% endblock %}
