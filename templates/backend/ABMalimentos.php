{% extends "_layout.php" %}

{% block head %}
	{{ parent() }}
	<!-- BackEnd page	 -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script> -->

	<script type="text/javascript" src="./../../js/plugins/jquery-ui-1.11.js"></script>
	<script type="text/javascript" src="./../../js/plugins/jquery-2.1.2.js"></script>
	<link rel="stylesheet" type="text/css" href="./../../js/plugins/smoothness-jquery-ui.css">

{% endblock %}

{% block content %}		
	<div id = "content">
		<h2>ALTA, BAJA Y MODIFICACIÓN DE ALIMENTOS</h2>
		<form action="#" method="POST">
			<div class="conj-block">
				<label for="description" style = "display : block">Descripción: </label><input id="description" type="text" >
				<label for="expiration" style = "display : block">Fecha de Vencimiento: </label><input id="expiration" type="text" >
				<label for="content" style = "display : block">Contenido: </label><input id="content-food" type="text" >
			</div>
			<div class="conj-block">
				<label for="weight" style = "display : block">Peso: </label><input id="weight" type="number" >
				<label for="stock" style = "display : block">Stock: </label><input id="stock" type="number" >
				<label for="reserve" style = "display : block">Reservado: </label><input id="reserve" type="number" >
			</div>
		</form>
	</div>
{% endblock %}
{% block scripts %}
<script type="text/javascript">
	$(document).ready(function(){
		$('#expiration').datepicker();
	});
</script>
{% endblock %}
