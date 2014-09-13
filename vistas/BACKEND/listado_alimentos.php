<!DOCTYPE html>
<html>
<head>
	<title>Banco de Alimentos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- BackEnd page	 -->
	
	<script src="../../js/plugins/jquery-2.1.2.js"></script>
	<script type="text/javascript" charset="utf8" src="../../js/plugins/jquery.dataTables-1.10.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
</head>
<body>
	<header>
	
	</header>
	<nav>
		<img id ="logo-img" src="../../images/logo-web.jpg"/>
		<!-- sacar esto a un archivo-->
		<ul>
			<li>ABM de donantes</li>
			<li>ABM de entidades receptoras</li>
			<li><a href ="./ABMalimentos.html">ABM de alimentos</a></li>
			<li>ABM de turnos de entrega</li>
			<li>ABM de servicios prestados</li>
			<li>Confección y entrega de pedidos</li>
			<li>Consulta stock de alimentos</li>
			<li><a href="./listado_alimentos.html">Listado de alimentos</a></li>
		</ul>
		
	</nav>
	<div id="leftcolumnwrap">
		<aside>
			
		</aside>
	</div>
	<div id="cuerpo-principal">
		<table id="tabla-alimentos" border="1px" style="border-color: gray; text-align: center">
			<thead>
				<tr>
					<th>Descripción</th>
					<th>Fecha de Vencimiento</th>
					<th>Contenido</th>
					<th>Peso</th>
					<th>Stock</th>
					<th>Reservado</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>

		</table>
	</div>

	<footer>
		© 2013 Banco Alimentario de La Plata Recuperando alimentos de La Plata para ayudar a los que mas necesitan :)	
	</footer>

</body>

<script type="text/javascript">
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
		$('#tabla-alimentos').dataTable({
			data: datos
		});

	});

</script>
</html>