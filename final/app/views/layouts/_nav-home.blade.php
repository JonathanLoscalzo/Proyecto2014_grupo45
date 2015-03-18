<nav>
    <ul id="mainNavBar">
        <!-- http://laravel-recipes.com/recipes/186/generating-a-html-link -->
        <!-- {{ HTML::link('/login', 'log in', array('id' => 'linkid'), true)}} -->
        <li>{{ HTML::link('/', 'Home') }}</li>
        <li><a href="#">Quienes somos</a></li>
        <li><a href="./{{ $server }}/final/public/Voluntariado">Voluntariado</a></li>
        <li><a href="./{{ $server }}/final/public/Proyectos">Proyectos</a></li>
        <li><a href="#">Contacto</a></li>
        <li><a href="./{{ $server }}final/public/Dona-ahora">¡Dona Ahora!</a></li>
        <li><a href="./{{ $server }}final/public/lista_donantes">Ver nuestros donantes</a></li>
        <li><a href="./{{ $server }}final/public/lista_entidadesreceptoras">Ver nuestras Entidades Receptoras</a></li>
        <li><a href="./{{ $server }}final/public/acerca_de">Acerca de nosotros</a></li>
        @if  (Auth::check())
        <li>{{ HTML::link('/backend', 'Backend') }}</li>
        @else
        <li>{{ HTML::link('/login', 'Log-in') }}</li>		
        @endif
    </ul>
</nav>