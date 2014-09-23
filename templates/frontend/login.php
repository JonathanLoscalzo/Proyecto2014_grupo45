<!DOCTYPE html>
<html>
<head>
	<title>Banco de Alimentos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- FrontEnd page	 -->
    <link href="../../css/style.css" rel="stylesheet">
    
</head>
<body>
	<div id="headerwrap">
		<?php
			include '_header-home.php' 
		?>
	</div>
	<div id="navigationwrap">
		<?php 
		include '_nav-home.php'
		 ?>
	</div>
	<div id="leftcolumnwrap">
		<?php 
			include '_aside-content.php'
		 ?>
	</div>

	<div id="contentwrap">
		<div id="content">
		<!-- JRL => LAS CONTRASEÑAS DEBERÌAN IR CIFRADAS? --> 
			<form id="login-form" action = "../BACKEND/index.php" method="POST">
	            <label for="#login-user">Usuario: </label><input id="login-name" name="login-name" type="text" required />
	            <label for="#login-pass">Contraseña: </label><input id="login-pass" type="password" name="login-pass"required/>
	            <button type="submit" >iniciar sesión</button>
	        </form>
		</div>
	</div>
	<?php
		include './../_footer.php'
	?>

</body>
</html>