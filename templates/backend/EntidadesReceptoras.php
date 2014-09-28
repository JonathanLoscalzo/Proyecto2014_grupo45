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
<div id = "content">
    <div id="accordion">
        <h3>Alta</h3>
        <div>
            <form action="./{{server}}entidadesReceptoras/add" method="POST">
                <div class="conj-block">
                    <label for="nombreCompania" style = "display : block">Razon Social: </label><input id="razonSocial" name="razonSocial" type="text" required placeholder="Razon social">
                    <label for="phone" style = "display : block">Teléfono: </label><input id="telefono" type="number" name="telefono"placeholder="Telefono">
                    <label for="adress" style = "display : block">Domicilio: </label><input id="domicilio" type="text" name="domicilio" placeholder="Domicilio">
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
                <button type="submit" name="submit"> Enviar </button>
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
<script>
$(document).ready(function () {
    $('#accordion').accordion({collapsible: true});
    console.log($("select"));
    $('select').change(function () {
        var x = $(this).val();
        $("#" + $(this).attr('id') + "-input").val(x);
    });
    //$('#tabla-entidades').dataTable();

});
</script>
{% endblock %}
