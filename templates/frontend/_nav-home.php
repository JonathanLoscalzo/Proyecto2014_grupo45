<nav>
	<ul id="mainNavBar">
		<li><a href="./{{ server }}index">Home</a></li>
		<li><a href="#">Quienes somos</a></li>
		<li><a href="./{{ server }}Voluntariado">Voluntariado</a></li>
		<li><a href="./{{ server }}Proyectos">Proyectos</a></li>
		<li><a href="#">Contacto</a></li>
		<li><a href="./{{ server }}Dona-ahora">¡Dona Ahora!</a></li>
		{% if session.username is defined %}
		<li><a href= "./{{ server }}backend">BACKEND</a></li>
		{% else %}
		<li><a href= "./{{ server }}login">INICIAR SESION</a></li>		
		{% endif %}
	</ul>
</nav>