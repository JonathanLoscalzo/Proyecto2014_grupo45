{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<script src="{{server}}js/plugins/jquery-2.1.2.js"></script>

<script type="text/javascript" charset="utf8" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
{% endblock %}

{% block content %}
<div id = "content">
<!--    Haria falta css aca-->
    <h3> LISTADO DE ALIMENTOS </h3>
    <div class="tabla-class">
        <table id="tabla-alimentos">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Vencimiento</th>
                    <th>Contenido</th>
                    <th>Peso Unitario</th>
                    <th>Stock</th>
                    <th>Reservado</th>
                </tr>
            </thead>

            <tbody tbody style="text-align: center">
                {% for detalle in detalles %}
<!--                deben ir todos los alimentos con stock > 0 aca?-->
                {% if detalle.stock > 0 %}
                <tr>
                    <td> {{ detalle.alimento_codigo }} </td>
                    <td> {{ detalle.fecha_vencimiento }} </td>
                    <td> {{ detalle.contenido }} </td>
                    <td> {{ detalle.peso_unitario }} </td>
                    <td> {{ detalle.stock }} </td>
                    <td> {{ detalle.reservado }} </td>
            </tbody>
            {% endif %}
            {% endfor %}
        </table>
    </div>
</div>
{% endblock %}


{% block scripts %}
<script>
$(document).ready(function () {
    $('#tabla-alimentos').dataTable({
        searching: false,
        paging: false
    });
});
</script>
{% endblock %}