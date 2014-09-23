<!DOCTYPE html>
<html>
<head>
{% block head %}
	<title>Banco de Alimentos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- FrontEnd page	 -->
    <link href="../../css/style.css" rel="stylesheet">

{% endblock %}    
    
</head>
<body>
	<div id="headerwrap">
		
		{% include '_header-home.php' %}
		
	</div>
	<div id="navigationwrap">
		{% include '_nav-home.php' %}
	</div>
	<div id="leftcolumnwrap">
		
		{%	include '_aside-content.php' $}
		
	</div>

	<div id="contentwrap">
	{% block content %}


	{% endblock %}	
	</div>
		
	{% include './../_footer.php' %}
	

</body>
</html>