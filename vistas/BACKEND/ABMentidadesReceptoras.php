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
			<?php
				include 'menu-bar.php';
			?>

		</div>
		
		<div id="contentwrap">
			<div id = "content">
				<h2>ALTA, BAJA Y MODIFICACIÓN DE ENTIDADES RECEPTORAS</h2>
				<form action="#" method="POST">
					<div class="conj-block">
						<label for="companyName" style = "display : block">Razon Social: </label><input id="companyName" type="number" >
						<label for="phone" style = "display : block">Teléfono: </label><input id="phone" type="number" >
						<label for="adress" style = "display : block">Domicilio: </label><input id="adress" type="text" >
					</div>
					<div class="conj-block">
						<label for="service" style = "display : block">Servicio Prestado: </label>
						<!-- JRL => preguntar como usar esto!, como guardar esto. Si guardar con numeros y utilizar 
						tipo un archivo de recursos. -->
						<input id="service" type="text">
						<label for="need" style = "display : block">Necesidad: </label>
						<select id="need" type="number" >
							<option id="">Máximo</option>
							<option id="">Mediana</option>
							<option id="">Mínima</option>
						</select>
						<label for="state" style = "display : block">Estado: </label>
						<select id="state">
							<option id="">En alta</option>
							<option id="">En trámite</option>
							<option id="">Suspendida</option>
							<option id="">Baja</option>
						</select>
					</div>
					<button type="submit" > Enviar </button>
				</form>
			</div>
		</div>

		
		<?php
			include './../_footer.php'
		?>

	</div>

</body>
<script type="text/javascript">
	
</script>
</html>