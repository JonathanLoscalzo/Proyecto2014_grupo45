{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables-1.10.2.min.js"></script>
{% endblock %}


{% block content %}
<div id = "content">
    <h2>ALTA, BAJA Y MODIFICACIÓN DE ENTIDADES RECEPTORAS</h2>
    <div id="accordion">
        <h3>Alta</h3>
        <div>
            <form action="#" method="POST">
                <div class="conj-block">
                    <label for="nombreCompania" style = "display : block">Razon Social: </label><input id="nombreCompania" type="number" >
                    <label for="phone" style = "display : block">Teléfono: </label><input id="telefono" type="number" >
                    <label for="adress" style = "display : block">Domicilio: </label><input id="domicilio" type="text" >
                </div>
                <div class="conj-block">
                    <label for="service" style = "display : block">Servicio Prestado: </label>
                    <select id="servicio" name="servicio">
                        {% for serv in servicios %}
                        <option id="{{ serv.id }}"> {{ serv.descripcion }}</option>
                        {% endfor %}
                    </select>
                    <label for="need" style = "display : block">Necesidad: </label>
                    <select id="necesidad" type="number" name="necesidad" >
                        {% for nec in necesidades %}
                        <option id="{{ nec.id }}"> {{ nec.descripcion }}</option>
                        {% endfor %}  
                    </select>
                    <label for="estado" style = "display : block">Estado: </label>
                    <select id="estado" name="estado">
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
                <tbody>
                    {% for elem in entidades %}
                <td>
                <tr> {{ elem.razonSocial }} </tr>
                <tr> {{ elem.telefono }} </tr>
                <tr> {{ elem.domicilio }} </tr>
                <tr> {{ elem.estado.descripcion }} </tr>
                <tr> {{ elem.necesidad.descripcion }} </tr>
                <tr> {{ elem.servicio.descripcion }} </tr>

                <tr><a href="./entdidadesReceptoras/edit/{{ elem.id }}"><img src="../images/icons/glyphicons_235_pen.png" alt="modificar"></a></tr>
                <tr><a href="./entidadesReceptoras/remove/{{ elem.id }}"><img src="../images/icons/glyphicons_197_remove.png" alt="borrar"></a></tr>
                </td>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    $('#accordion').accordion({collapsible: true});
    $('#tabla-entidades').dataTable();
});
</script>
{% endblock %}
