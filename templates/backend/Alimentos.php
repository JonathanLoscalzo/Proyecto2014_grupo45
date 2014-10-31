{% extends "backend_layout.php" %}

{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{server}}js/plugins/smoothness-jquery-ui.css">

{% endblock %}

{% block content %}	

<div id = "content">
    <div id="accordion">
        <!--                $data['alimento_codigo'], $data['fecha_vencimiento'], 
                            $data['contenido'], $data['peso_unitario'], $data['stock'], 
                            $data['reservado']);-->
        <h3>ALTA</h3>
        <div>
            <form action="{{server}}alimentos/add" method="POST">
                <div class="conj-block">
                    <label for="radio" style="display: block">Seleccione opcion</label>
                    <input type="radio" name="habilitar-alimento" id="radio" value="yes">Agregar nuevo Alimento<br>
                    <input type="radio" name="habilitar-alimento" id="radio" checked value="no">Utilizar existente
                    <div id="select-alimento">
                        <label for="tipo" style = "display : block">Tipo: </label>
                        <select id="tipo-alimento" name="alimento_codigo">
                            {% for ali in alimentos %}
                            <option value="{{ ali.codigo }}" id="{{ ali.codigo}}"  > {{ ali.codigo }}</option>

                            {% endfor %}
                        </select>
                    </div>
                    <div hidden id="agregar-alimento">
                        <label for="input_alimento" style="display: block" >Nombre de Alimento</label><input placeholder="Ej: Aceites" id="codigo-nuevo" type="text" name="codigo-nuevo">
                        <label for="input_descripcion" style="display: block">Descripcion de Alimento</label><input placeholder="Ej: Aceite vegetal de girasol" name="descripcion-nueva" id="descripcion-nueva">
                    </div>
                    <label for="expiration" style = "display : block" >Fecha de Vencimiento: </label><input id="expiration" name="fecha_vencimiento" type="text" required>
                    <label for="content" style = "display : block">Contenido: </label><input id="content-food" placeholder="Ej: 10x3lt de Agua" type="text" name="contenido" required>
                    <input id='flag' name='flag' type="hidden" value=0>
                </div>
                <div class="conj-block">

                    <label for="weight" style = "display : block">Peso: </label><input id="weight" type="number" name="peso_unitario" required placeholder="Ingrese el peso por unidad">
                    <label for="stock" style = "display : block">Stock: </label><input id="stock" type="number" name="stock" placeholder="Ingrese el stock (opcional)">
                    <label for="reserve" style = "display : block">Reservado: </label><input id="reserve" type="number" name="reservado" placeholder="Ingrese una cantidad reservada (opcional)">
                </div>
                <button type="submit"> Enviar </button>
            </form>
        </div>
        <h3>Baja y Modificación</h3>
        <div class="tabla-class">
            <table id="tabla-paquetes">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Vencimiento</th>
                        <th>Contenido</th>
                        <th>Peso Unitario</th>
                        <th>Stock</th>
                        <th>Reservado</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody tbody style="text-align: center">
                    {% for detalle in detalles %}
                    <tr>
                        <td> {{ detalle.alimento_codigo }} </td>
                        <td> {{ detalle.fecha_vencimiento }} </td>
                        <td> {{ detalle.contenido }} </td>
                        <td> {{ detalle.peso_unitario }} </td>
                        <td> {{ detalle.stock }} </td>
                        <td> {{ detalle.reservado }} </td>

                        <td><a href="{{server}}alimentos/edit/{{ detalle.id }}"><img src="{{server}}images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                        <td><a href="{{server}}alimentos/remove/{{ detalle.id }}"><img src="{{server}}images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>
{% endblock %}
{% block scripts %}
<script type="text/javascript">
$(document).ready(function () {
    $('#expiration').datepicker();
    $('#accordion').accordion({collapsible: true, active: false});
    $('input:radio[name="habilitar-alimento"]').click(function () {
        if ($('input[name="habilitar-alimento"]:checked').val() === 'yes') {
            $("#agregar-alimento").show();
            $("#select-alimento").hide();
            $("#codigo-nuevo").prop("required", true);
            $("#descripcion-nueva").prop("required", true);
            $("#flag").val(1); // setea en verdadero para pasar al controlador
        }
        else {
            $("#flag").val(0); // setea en falso para pasar al controlador.
            $("#agregar-alimento").hide();
            $("#select-alimento").show();
            $("#codigo-nuevo").prop("required", false);
            $("#descripcion-nueva").prop("required", false);
        }
    });
    //$('#tabla-paquetes').dataTable();


});
</script>
{% endblock %}
