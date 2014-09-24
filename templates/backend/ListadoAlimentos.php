{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
	<script src="../js/plugins/jquery-2.1.2.js"></script>
	<script type="text/javascript" charset="utf8" src="../js/plugins/jquery.dataTables-1.10.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/sunny/jquery-ui-1.9.2.custom.css">

	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
{% endblock %}

{% block content %}
			<div id = "content">
			<h2>ALTA, BAJA Y MODIFICACIÓN DE ALIMENTOS</h2>
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
				<!-- acá se podria poner un for in -->
				</tbody>
			</table>
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
		$('#tabla-alimentos').dataTable({
			data: datos
		});

	});
</script>
{% endblock %}