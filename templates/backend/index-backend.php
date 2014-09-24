
{% extends "backend_layout.php" %}
{% block content %}
<div id ="content">
{% if message is defined %}
	{# JRL -> deberiamos agregar un alert que se pueda cerrar #}
		<p> {{ message }} </p>	
	}
{% endif %}
</div>

{% endblock %}