{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">

<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">-->

{% endblock %}
{% block content %}
<div id = "content">
    <!-- $data['id'],
         data['razonSocial'], $data['apellido'],
         $data['nombre'], $data['telefono'], $data['email'],
         $data['domicilio']
    JRL => SE PUEDE USAR UN ACCORDION PARA QUE MUESTRE LAS 3 OPCIONES? -->
    <div id = "accordion">
        <h3>ALTA</h3>
        <div>
            <form action="./{{server}}donantes/add" method="POST" id="alta">
                <div class="conj-block">
                    <label for="razonSocial" style = "display : block">Razon Social: </label>
                    <input id="razonSocial" name="razonSocial" type="text" maxlength="100" required placeholder="Ingrese Razon Social">
                    <label for="nombre" style = "display : block">Nombre: </label>
                    <input id="nombre" name="nombre" type="text" maxlength="50" required placeholder="Ingrese su nombre"> 
                    <label for="apellido" style = "display : block">Apellido: </label>
                    <input id="apellido" name="apellido" type="text" maxlength="50" required placeholder="Ingrese su apellido">
                </div>
                <div class="conj-block">
                    <label for="telefono" style = "display : block">Teléfono: </label>
                    <input id="telefono" name="telefono" type="number" maxlength="30" required placeholder="Ej: 4561234">
                    <label for="email" style = "display : block">Correo Electrónico: </label>
                    <input id="email" name="email" type="email" maxlength="50" required placeholder="Ej: Mail@email.com">
                </div>
                <div class="conj-block">
                    <label for="direccion" style = "display : block">Domicilio: </label>
                    <textarea rows="3" colspan=5 id="domicilio" name="domicilio" type="text" maxlength="200" required placeholder="Ej: Benito Juarez 2040, Cancha Lejana, La Trompa (200A)">
                    </textarea>
                    <button type="submit" name="submit" style="display:block"> Enviar </button>
                </div>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div class="tabla-class">
            <table id="tabla-donantes">
                <thead>
                    <tr>
                        <th>Razón Social</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Domicilio</th>
                        <th>Email</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    {% for donante in donantes %}
                    <tr>
                        <td> {{ donante.razonSocial }} </td>
                        <td> {{ donante.nombre }} </td>
                        <td> {{ donante.apellido }} </td>
                        <td> {{ donante.telefono }} </td>
                        <td> {{ donante.domicilio }} </td>
                        <td> {{ donante.email }} </td>
                        <td><a href="{{server}}donantes/edit/{{ donante.id }}"><img src="{{server}}images/icons/glyphicons_235_pen.png" alt="modificar" ></a></td>
                        <td><a href="{{server}}donantes/remove/{{ donante.id }}"><img src="{{server}}images/icons/glyphicons_197_remove.png" alt="borrar" ></a></td>
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
    $('#accordion').accordion({collapsible: true, active: false});
    //$('#tabla-donantes').dataTable();
});

</script>
{% endblock %}
