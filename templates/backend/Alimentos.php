{% extends "backend_layout.php" %}

{% block head %}
	{{ parent() }}
        <link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
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
		<form action="{{server}}/alimentos/add" method="POST">
			<div class="conj-block">
                                <label for="tipo" style = "display : block">Tipo: </label>
                                <select id="tipo-alimento" required >
                                    <option selected disabled hidden value=''></option>
                                    {% for ali in alimentos %}
                                    <option value="{{ ali.codigo }}"> {{ ali.codigo }}</option>
                                    {% endfor %}
                                </select>
				<label for="description" style = "display : block">Descripción: </label><input name="descripcion"id="description" type="text" >
				<label for="expiration" style = "display : block">Fecha de Vencimiento: </label><input id="expiration" name="fecha_vencimiento" type="text" >
				<label for="content" style = "display : block">Contenido: </label><input id="content-food" type="text" name="contenido">
			</div>
			<div class="conj-block">
				<label for="weight" style = "display : block">Peso: </label><input id="weight" type="number" name="peso_unitario">
				<label for="stock" style = "display : block">Stock: </label><input id="stock" type="number" name="stock">
				<label for="reserve" style = "display : block">Reservado: </label><input id="reserve" type="number" name="reservado">
			</div>
                        <button type="submit"> Enviar </button>
		</form>
                </div>
            <h3>Baja y Modificación</h3>
            <div>
                <table id="tabla-paquetes">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Vencimiento</th>
                            <th>Contenido</th>
                            <th>Peso Unitario</th>
                            <th>Stock</th>
                            <th>Reservado</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody tbody style="text-align: center">
                        {% for detalle in detalles %}
                    <tr>
                        <td> {{ detalle.alimento_codigo }} </td>
                        <td> {{ detalle.fecha_vencimiento }} </td>
                        <rd> {{ detalle.contenido }} </td>
                        <td> {{ detalle.peso_unitario }} </td>
                        <td> {{ detalle.stock }} </td>
                        <td> {{ detalle.reservado }} </td>

                        <td><a href="{{server}}/alimentos/edit/{{ detalle.id }}"><img src="../images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                        <td><a href="{{server}}/alimentos/remove/{{ detalle.id }}"><img src="../images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
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
	$(document).ready(function(){
		$('#expiration').datepicker();
                $('#accordion').accordion({ collapsible: true });
                $('#tabla-paquetes').dataTable();
	});
</script>
{% endblock %}
