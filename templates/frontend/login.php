{% extends "_layout.php" %}

{% block content %}
<div id="content">
<!-- JRL => LAS CONTRASEÑAS DEBERÌAN IR CIFRADAS? CAMBIAR EL CONTROLADOR!--> 
	<form id="login-form" action = "../BACKEND/index.php" method="POST">
        <label for="#login-user">Usuario: </label><input id="login-name" name="login-name" type="text" required />
        <label for="#login-pass">Contraseña: </label><input id="login-pass" type="password" name="login-pass"required/>
        <button type="submit" >iniciar sesión</button>
    </form>
</div>
{% endblock %}