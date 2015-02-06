{% extends "frontend_layout.php" %}

{% block content %}
<div id="content">
<!-- JRL => LAS CONTRASEÑAS DEBERÌAN IR CIFRADAS? CAMBIAR EL CONTROLADOR!--> 
	<form id="login-form" action = "./login-user" method="POST">
        <label for="#login-user">Usuario: </label><input id="login-name" name="username" type="text" required />
        <label for="#login-pass">Contraseña: </label><input id="login-pass" type="password" name="pass" required/>
        <button type="submit" >iniciar sesión</button>
    </form>
</div>
{% endblock %}