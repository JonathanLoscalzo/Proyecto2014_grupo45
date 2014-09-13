<!DOCTYPE html>
<html>
<head>
	<title>Banco de Alimentos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- BackEnd page	 -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<link href="../../css/style-backend.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="headerwrap">
			<?php
				include '_header-backend.php' 
			?>
		</div>

		<div id="leftcolumnwrap">
			<!--<aside>
				
			</aside> -->
		</div>	

		<div id="contentwrap">
			<div id = "content">
				<h2>ALTA, BAJA Y MODIFICACIÓN DE ALIMENTOS</h2>
				<form action="#" method="POST">
					<label for="description" style = "display : block">Descripción: </label><input id="description" type="text" >
					<label for="expiration" style = "display : block">Fecha de Vencimiento: </label><input id="expiration" type="text" >
					<label for="content" style = "display : block">Contenido: </label><input id="content-food" type="text" >
					<label for="weight" style = "display : block">Peso: </label><input id="weight" type="number" >
					<label for="stock" style = "display : block">Stock: </label><input id="stock" type="number" >
					<label for="reserve" style = "display : block">Reservado: </label><input id="reserve" type="number" >
				</form>
			</div>
		</div>

		
		<?
			include './../_footer.php'
		?>

	</div>

</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('#expiration').datepicker();
	});
</script>
</html>