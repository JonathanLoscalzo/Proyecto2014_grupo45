<nav>
    <ul id="mainNavBar">
        <!-- http://laravel-recipes.com/recipes/186/generating-a-html-link -->
        <!-- {{ HTML::link('/login', 'log in', array('id' => 'linkid'), true)}} -->
        <li>{{ HTML::link('/', 'Home') }}</li>
        <li><a href="#">Quienes somos</a></li>
        <li><a href="#">Voluntariado</a></li>
        <li><a href="#">Proyectos</a></li>
        <li><a href="#">Contacto</a></li>
        <li><a href="#">¡Dona Ahora!</a></li>
        <li><a href="#">Ver nuestros donantes</a></li>
        <li><a href="#">Ver nuestras Entidades Receptoras</a></li>
        <li>{{ HTML::link('/acerca_de', 'Acerca de Nosotros')}}</li>
        @if  (Auth::check())
        <li>{{ HTML::link('/backend', 'Backend') }}</li>
        @else
        <li>{{ HTML::link('/login', 'Log-in') }}</li>		
        @endif
    </ul>
</nav>