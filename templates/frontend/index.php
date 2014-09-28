
{% extends "frontend_layout.php" %}

{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.9.2.custom.js"></script>
{% endblock %}

{% block content %}
<div id="content">
    
    <h2>
        Lo que hacemos en el Banco Alimentario			
    </h2>
    <p>
        Somos una organizacion sin fines de lucro que tiene como misión la recuperación de alimentos para generar conciencia ambiental combatiendo el hambre y la desnutrición en la zona de La Plata.	
    </p>	
    <img class ="image-frontend" alt="imagen-banco" src="{{server}}/images/imagen-banco.jpg" style="border-radius: 15px;">
</div>	
{% endblock %}

