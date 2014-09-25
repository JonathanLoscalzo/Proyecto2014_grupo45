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
					<label for="companyName" style = "display : block">Razon Social: </label><input id="companyName" type="number" >
					<label for="name" style = "display : block">Nombre: </label><input id="name" type="text" >
					<label for="lastname" style = "display : block">Apellido: </label><input id="lastname" type="text" >
				</div>
				<div class="conj-block">
					<label for="phone" style = "display : block">Teléfono: </label><input id="phone" type="number" >
					<label for="adress" style = "display : block">Domicilio: </label><input id="adress" type="text" >
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
						{# tendria que ver como pasar un objeto a la vista y acceder por los get#}
						<tr> {{ donante.getRazonSocial }} </tr>
						<tr> {{ donante.getNombre }} </tr>
						<tr> {{ donante.getApellido }} </tr>
						<tr> {{ donante.getTelefono }} </tr>
						<tr> {{ donante.getDomicilio }} </tr>
						<tr> {{ donante.getEmail }} </tr>

						<tr><a href="./donantes/edit/{{donante.getId}}"><img src="../images/icons/glyphicons_235_pen.png" alt="modificar"></a></tr>
						<tr><a href="./donantes/remove/{{donante.getId}}"><img src="../images/icons/glyphicons_197_remove.png" alt="borrar"></a></tr>
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
$(document).ready(function(){

	var datos = [
	    [
	        "ALIMENTO 1",
	        "14/02/2016",
	        "Harina",
	        "1",
	        "200",
	        "10"
	    ],
	    [
	        "ALIMENTO 2",
	        "16	/02/2016",
	        "Fideos",
	        "1",
	        "150",
	        "84"
	    ],
	    [
	    	"ALIMENTO 3",
	        "19/11/2018",
	        "Arroz",
	        "1,5",
	        "25",
	        "15"
	    ]
	]
	$('#accordion').accordion({ collapsible: true });
	$('#tabla-donantes').dataTable({
		data : datos
	});
});
	
</script>
{% endblock %}
