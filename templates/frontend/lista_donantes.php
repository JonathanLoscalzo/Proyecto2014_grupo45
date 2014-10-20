{% extends "frontend_layout.php" %}

{% block head %}
<script src="{{server}}js/plugins/jquery-2.1.2.js"></script>

<script type="text/javascript" charset="utf8" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
{% endblock %}

{% block content %}
<div id = "content">
<!--    Haria falta css aca-->
    <h3> LISTADO DE DONANTES </h3>
    <div class="tabla-class">
        <table id="tabla-donantes">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                </tr>
            </thead>

            <tbody tbody style="text-align: center">
                {% for donante in donantes %}
<!--                deben ir todos los alimentos con stock > 0 aca?-->
                <tr>
                    <td> {{ donante.nombre }} </td>
                    <td> {{ donante.apellido  }} </td>
                </tr>
            </tbody>
            {% endfor %}
        </table>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
$(document).ready(function () {
    $('#tabla-donantes').dataTable({
        searching: false,
        paging: false
    });
});
</script>
{% endblock %}