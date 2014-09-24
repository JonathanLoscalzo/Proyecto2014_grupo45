{% extends "backend_layout.php" %}

{% block content %}
	<div id = "content">
	<!-- JRL => SE PUEDE USAR UN ACCORDION PARA QUE MUESTRE LAS 3 OPCIONES? -->
		<h2>ALTA, BAJA Y MODIFICACIÓN DE DONANTES</h2>
		<form action="#" method="POST">
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
{% endblock %}
