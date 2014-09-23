<!DOCTYPE html>
<html>
<head>
	<title>Banco de Alimentos</title>
	{% block head %}
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="../../css/style-backend.css" rel="stylesheet">
	{% endblock %}
</head>
<body>
	<div id="wrapper">
		<div id="headerwrap">
			{% include '_header-backend.php' %}
			
		</div>
		<div id="navigationwrap">
			{%	include 'menu-bar.php'	%}

		</div>
		

		<div id="contentwrap">
		{% block content %}

		{% endblock %}
		</div>

		{% include '_footer.php' %}
	</div>

</body>
{% block scripts %}

{% endblock %}

</html>
