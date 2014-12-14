{% extends "backend_layout.php" %}
{% block head %}
<link href="/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
{{ parent() }}
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<link href="{{server}}/js/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="{{server}}js/plugins/jquery-ui/jquery-ui.js"></script>

<script type="text/javascript" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
{% endblock %}


{% block content %}
<div class="ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
        <p>
            <span class="ui-icon ui-icon-alert" 
                style="float: left; margin-right: .3em;"></span>
            <strong>Alert:</strong> Geolocation no disponible.
        </p>
    </div>
</div>


<div id = "content">
    <div id="accordion">
        <h3>Alta</h3>
        <div>
            <form id="send-form" action="./{{server}}entidadesReceptoras/add" method="POST">
                <div class="conj-block">
                    <label for="nombreCompania" style = "display : block">Razon Social: </label><input placeholder="Empleados S.A" id="razonSocial" name="razonSocial" type="text" required placeholder="Razon social">
                    <label for="phone" style = "display : block">Teléfono: </label><input id="telefono" placeholder="Ej: 2215550000" type="number" name="telefono"placeholder="Telefono">
                    <label for="adress" style = "display : block">Domicilio: </label><input id="domicilio" placeholder="Ej: 9 de Julio numero 555" type="text" name="domicilio" placeholder="Domicilio">
                    <button id="location-btn" type="button" style="display: block; margin: 10px ">Ubicar en mapa</button>
                    <input type="hidden" name="lat" id="form-lat" required>
                    <input type="hidden" name="long" id="form-long" required>
                </div>
                <div class="conj-block">
                    <label for="service" style = "display : block">Servicio Prestado: </label>
                    <select id="servicio" required >
                        <option selected disabled hidden value=''></option>
                        {% for serv in servicios %}
                        <option value="{{ serv.id }}"> {{ serv.descripcion }}</option>
                        {% endfor %}
                    </select>
                    <input id="servicio-input"  name="servicioEntidadID" hidden> 
                    <label for="need" style = "display : block">Necesidad: </label>
                    <select id="necesidad" required>
                        <option selected disabled hidden value=''></option>
                        {% for nec in necesidades %}
                        <option value="{{ nec.id }}"> {{ nec.descripcion }}</option>
                        {% endfor %}  
                    </select>
                    <input id="necesidad-input" name="necesidadEntidadID" hidden> 
                    <label for="estado" style = "display : block">Estado: </label>
                    <select id="estado" required>
                        <option selected disabled hidden value=''></option>
                        {% for est in estados %}
                        <option value="{{ est.id }}"> {{ est.descripcion }}</option>
                        {% endfor %}
                    </select>
                    <input id="estado-input" class="estado" name="estadoEntidadID" hidden> 
                </div>
                <button type="submit" name="submit" id="btn-submit"  disabled> Enviar </button>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div class = "tabla-class">
            <table id="tabla-entidades">
                <thead>
                    <tr>
                        <th>Razón Social</th>
                        <th>Teléfono</th>
                        <th>Domicilio</th>
                        <th>Estado</th>
                        <th>Necesidad</th>
                        <th>Servicio Prestado</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    {% for elem in entidades %}
                    <tr>
                        <td> {{ elem.razonSocial }} </td>
                        <td> {{ elem.telefono }} </td>
                        <td> {{ elem.domicilio }} </td>
                        <td> {{ elem.estado.descripcion }} </td>
                        <td> {{ elem.necesidad.descripcion }} </td>
                        <td> {{ elem.servicio.descripcion }} </td>

                        <td><a href="./{{server}}entidadesReceptoras/edit/{{ elem.id }}"><img src="{{server}}images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                        <td><a href="./{{server}}entidadesReceptoras/remove/{{ elem.id }}"><img src="{{server}}images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src="{{server}}js/plugins/OpenLayers.js"></script>
<script type="text/javascript" src="{{server}}js/scripts/mapHandler.js"></script>
<script>
$(".ui-widget").hide();

$(document).ready(function () {

    $('#accordion').accordion({collapsible: true, active:false});
    $('select').change(function () {
        var x = $(this).val();
        $("#" + $(this).attr('id') + "-input").val(x);
    });
    function handleMapClick(e)
    {

       var lonlat = map.getLonLatFromViewPortPx(e.xy);
       // use lonlat

       // If you are using OpenStreetMap (etc) tiles and want to convert back 
       // to gps coords add the following line :-
       toProjection = new OpenLayers.Projection("EPSG:4326");
       lonlat.transform( map.getProjectionObject(), toProjection); // map.displayProjection
       var Longitude = lonlat.lon;
       var Latitude  = lonlat.lat;
       
       $("#lat").val(Latitude);
       $("#long").val(Longitude);
       $("#form-lat").val(Latitude);
       $("#form-long").val(Longitude);
       $("#btn-submit").prop("disabled", false);
    } 
    var $dialog = $("<div></div>")
			.load("templates/backend/map_display.html")
			.dialog({ autoOpen: false,
                                    show: {
                                        effect: "blind",
                                        duration: 1000
                                    },
                                    hide: {
                                        effect: "explode",
                                        duration: 1000
                                    },            
                                    height: 500,
                                    width: 700
			});
    function displayMap(position) {
        
        $dialog.dialog("open");
        map = mapInit();
        fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
        zoom = 13;
        position = new OpenLayers.LonLat(position.coords.longitude, position.coords.latitude).transform( fromProjection, toProjection);
        map.setCenter(position, zoom);
        map.events.register('click', map, handleMapClick);
        
    }
    


    // select dir modal to get lat/long.
    $("#location-btn").click(function () {
         if (navigator.geolocation) {
             navigator.geolocation.getCurrentPosition(displayMap);
         }
         else {
             $(".ui-widget").show();
         }
    });
});
</script>
{% endblock %}
