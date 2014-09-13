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
		<header>	
			<img id ="logo-img" style ="border-radius: 15px; "src="../../images/logo-web.jpg"/>
		</header>
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
		<?php 
			include '_content-home.php'
		?>
	</div>
	<div id="footerwrap">
		<footer>
			© 2013 Banco Alimentario de La Plata Recuperando alimentos de La Plata para ayudar a los que mas necesitan :)
		</footer>
	</div>

</body>
</html>