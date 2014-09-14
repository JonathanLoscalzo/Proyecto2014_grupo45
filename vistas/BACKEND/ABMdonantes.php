<!DOCTYPE html>
<html>
<head>
	<title>Banco de Alimentos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- BackEnd page	 -->
	<link href="../../css/style-backend.css" rel="stylesheet">

</head>
<body>
	<div id="wrapper">
		<div id="headerwrap">
			<?php
				include '_header-backend.php' 
			?>
		</div>
		<div id="navigationwrap">
			<?
				include 'menu-bar.php';
			?>

		</div>
		
		<div id="contentwrap">
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
		</div>

		
		<?
			include './../_footer.php'
		?>

	</div>

</body>
<script type="text/javascript">

</script>
</html>