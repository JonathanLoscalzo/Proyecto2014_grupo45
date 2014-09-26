
{% extends "frontend_layout.php" %}

{% block head %}
	{{ parent() }}
	<link rel="stylesheet" type="text/css" href="../css/sunny/jquery-ui-1.9.2.custom.css">
	<script type="text/javascript" src="../js/plugins/jquery-2.1.2.js"></script>
	<script type="text/javascript" src="../js/plugins/jquery-ui-1.11.js"></script>
	<script type="text/javascript" src="../js/plugins/jquery-ui-1.9.2.custom.js"></script>
{% endblock %}

{% block content %}
<div id="content">
	{% if message is defined and not(message=="") %}
	{# JRL -> deberiamos agregar un alert que se pueda cerrar #}
		<div class = "alert-dialog" title="ALERTA">
			<p> {{ message }} </p>	
		</div>
	{% endif %}
	<h2>
		Lo que hacemos en el Banco Alimentario			
	</h2>
	<p>
		Somos una organizacion sin fines de lucro que tiene como misión la recuperación de alimentos para generar conciencia ambiental combatiendo el hambre y la desnutrición en la zona de La Plata.	
	</p>	
	<img class ="image-frontend" alt="imagen-banco" src="../images/imagen-banco.jpg" style="border-radius: 15px;">
</div>	
{% endblock %}

{% block scripts %}
<script>
	$(document).ready(function(){
    	$( ".alert-dialog" ).dialog();
	})

</script>
{% endblock %}