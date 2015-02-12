<nav>
    <ul id="mainNavBar">
        <li><a href="./{{ $server }}final/public/">Home</a></li>
        <li><a href="#">Quienes somos</a></li>
        <li><a href="./{{ $server }}/final/public/Voluntariado">Voluntariado</a></li>
        <li><a href="./{{ $server }}/final/public/Proyectos">Proyectos</a></li>
        <li><a href="#">Contacto</a></li>
        <li><a href="./{{ $server }}final/public/Dona-ahora">¡Dona Ahora!</a></li>
        <li><a href="./{{ $server }}final/public/lista_donantes">Ver nuestros donantes</a></li>
        <li><a href="./{{ $server }}final/public/lista_entidadesreceptoras">Ver nuestras Entidades Receptoras</a></li>
        <li><a href="./{{ $server }}final/public/acerca_de">Acerca de nosotros</a></li>
        @if  (Auth::check())
        <li><a href= "./{{ $server }}final/public/backend">BACKEND</a></li>
        @else
        <li><a href= "{{$server}}final/public/login">INICIAR SESION</a></li>		
        @endif
    </ul>
</nav>