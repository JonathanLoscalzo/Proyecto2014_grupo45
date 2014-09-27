{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables-1.10.2.min.js"></script>
<link rel = "stylesheet" type ="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
{% endblock %}


{% block content %}
<div id = "content">
    <h2>ALTA, BAJA Y MODIFICACIÓN DE ENTIDADES RECEPTORAS</h2>
    <div id="accordion">
        <h3>Alta</h3>
        <div>
            <form action="./entidadesReceptoras/add" method="POST">
                <div class="conj-block">
                    <label for="nombreCompania" style = "display : block">Razon Social: </label><input id="nombreCompania" type="text" required placeholder="Razon social">
                    <label for="phone" style = "display : block">Teléfono: </label><input id="telefono" type="number" placeholder="Telefono">
                    <label for="adress" style = "display : block">Domicilio: </label><input id="domicilio" type="text" placeholder="Domicilio">
                </div>
                <div class="conj-block">
                    <label for="service" style = "display : block">Servicio Prestado: </label>
                    <select id="servicio" name="servicio" required>
                        {% for serv in servicios %}
                        <option id="{{ serv.id }}"> {{ serv.descripcion }}</option>
                        {% endfor %}
                    </select>
                    <label for="need" style = "display : block">Necesidad: </label>
                    <select id="necesidad" name="necesidad" required>
                        {% for nec in necesidades %}
                        <option id="{{ nec.id }}"> {{ nec.descripcion }}</option>
                        {% endfor %}  
                    </select>
                    <label for="estado" style = "display : block">Estado: </label>
                    <select id="estado" name="estado" required>
                        {% for est in estados %}
                        <option id="{{ est.id }}"> {{ est.descripcion }}</option>
                        {% endfor %}
                    </select>
                </div>
                <button type="submit"> Enviar </button>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div>
            <table id="tabla-entidades">
                <thead>
                <th>Razón Social</th>
                <th>Teléfono</th>
                <th>Domicilio</th>
                <th>Estado</th>
                <th>Necesidad</th>
                <th>Servicio Prestado</th>
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

                <td><a href="{{ server }}/entidadesReceptoras/edit/{{ elem.id }}"><img src="../images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                <td><a href="{{ server }}/entidadesReceptoras/remove/{{ elem.id }}"><img src="../images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
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
    $('#tabla-entidades').dataTable({
        language:{
            url: window.location.host +"/js/plugins/SpanishDataTable.json"
        }
    });
});
</script>
{% endblock %}
