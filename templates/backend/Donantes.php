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
    <!-- JRL => SE PUEDE USAR UN ACCORDION PARA QUE MUESTRE LAS 3 OPCIONES? -->
    <div id = "accordion">
        <h3>ALTA</h3>
        <div>
            <form action="#" method="POST" id="alta">
                <div class="conj-block">
                    <label for="razonSocial" style = "display : block">Razon Social: </label><input id="razonSocial" type="number" >
                    <label for="nombre" style = "display : block">Nombre: </label><input id="nombre" type="text" >
                    <label for="apellido" style = "display : block">Apellido: </label><input id="apellido" type="text" >
                </div>
                <div class="conj-block">
                    <label for="telefono" style = "display : block">Teléfono: </label><input id="telefono" type="number" >
                    <label for="direccion" style = "display : block">Domicilio: </label><input id="direccion" type="text" >
                    <label for="email" style = "display : block">Correo Electrónico: </label><input id="email" type="email" >
                </div>
                <button type="submit"> Enviar </button>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div>
            <table id="tabla-donantes">
                <thead>
                <th>Razón Social</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Domicilio</th>
                <th>Email</th>

                </thead>
                <tbody>
                    {% for donante in donantes %}
                <td>
                <tr> {{ donante.razonSocial }} </tr>
                <tr> {{ donante.nombre }} </tr>
                <tr> {{ donante.apellido }} </tr>
                <tr> {{ donante.telefono }} </tr>
                <tr> {{ donante.domicilio }} </tr>
                <tr> {{ donante.email }} </tr>

                <tr><a href="./donantes/edit/{{ donante.id }}"><img src="../images/icons/glyphicons_235_pen.png" alt="modificar"></a></tr>
                <tr><a href="./donantes/remove/{{ donante.id }}"><img src="../images/icons/glyphicons_197_remove.png" alt="borrar"></a></tr>
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
$(document).ready(function () {

    $('#accordion').accordion({collapsible: true});
    $('#tabla-donantes').dataTable({
        data: datos
    });
});

</script>
{% endblock %}
