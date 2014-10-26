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
    <h3> ENTIDADES RECEPTORAS </h3>
    <div id="accordion">
        <h3>Alta</h3>
        <div>
            <form action="./{{server}}usuarios/add" method="POST">
                <div class="conj-block">
                    <label for="username" style = "display : block">Razon Social: </label><input placeholder="Empleados S.A" id="razonSocial" name="razonSocial" type="text" required placeholder="Razon social">
                    <label for="pass" style = "display : block">Password: </label><input id="pass"  type="password" name="pass" >
                    <label for="pass" style = "display : block">Repita Password: </label><input id="pass2"  type="password" name="pass" >
                </div>
                <div class="conj-block">
                    <label for="service" style = "display : block">Rol: </label>
                    <select id="roleID" required >
                        <option selected disabled hidden value=''></option>
                        {% for rol in roles %}
                        <option value="{{ rol.roleID }}"> {{ serv.roleuser }}</option>
                        {% endfor %}
                    </select>
                <button type="submit" name="submit"> Enviar </button>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div class = "tabla-class">
            <table id="tabla-entidades">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Rol</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    {% for user in users %}
                    <tr>
                        <td> {{ user.username }} </td>
                        <td> {{ user.roleID }} </td>
                        <td><a href="./{{server}}usuarios/edit/{{ user.userID }}"><img src="{{server}}images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                        <td><a href="./{{server}}usuarios/remove/{{ user.userID }}"><img src="{{server}}images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
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
    $('#accordion').accordion({collapsible: true, active:false});
    console.log($("select"));
    $('select').change(function () {
        var x = $(this).val();
        $("#" + $(this).attr('id') + "-input").val(x);
    });
    //$('#tabla-entidades').dataTable();

});
</script>
{% endblock %}
