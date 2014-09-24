<nav>
	<ul id="mainNavBar">
		<li><a href="./index">Home</a></li>
		<li><a href="#">Quienes somos</a></li>
		<li><a href="./Voluntariado">Voluntariado</a></li>
		<li><a href="./Proyectos">Proyectos</a></li>
		<li><a href="#">Contacto</a></li>
		<li><a href="./Dona-ahora">¡Dona Ahora!</a></li>
		{% if session.username is defined %}
		<li><a href= "./backend">BACKEND</a></li>
		{% else %}
		<li><a href= "./login">INICIAR SESION</a></li>		
		{% endif %}
	</ul>
</nav>