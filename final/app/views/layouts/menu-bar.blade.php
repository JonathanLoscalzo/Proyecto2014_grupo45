<nav>
    <ul>
        @if (Auth::User()->roleID === 1)
        <li><a href="#">ABM de donantes</a></li>
        <li><a href="#">ABM de entidades receptoras</a></li>
        <li><a href ="#">ABM de paquetes</a></li> 		
        <li disabled><a href = "./{{ $server }}final/public/backend/usuarios" >ABM de Usuarios</a></li>
        <li disabled><a href = "#" >Entrega Directa</a></li>
        @endif
        @if (Auth::User()->roleID === 1 or Auth::User()->roleID === 3)
        <li><a href="#">Listado de alimentos</a></li>
        <li disabled style="display:none"><a href="#">Consulta stock de alimentos</a></li>
        @endif
        @if (Auth::User()->roleID === 2 or Auth::User()->roleID === 1)
        <li><a href = "#">Confección de pedidos</a></li>
        <li disabled><a href = "#"  >ABM de turnos de entrega</a></li>
        <li disabled><a href = "#"  >Envios</a></li>
        @endif
        
        <li><a href="./{{ $server }}final/public/backend/Estadisticas">Estadisticas</a></li>
        <li><a href="./{{ $server }}final/public/">FRONTEND</a></li>
        <li><a href="#">Alertas</a></li>
        

    </ul>
</nav>