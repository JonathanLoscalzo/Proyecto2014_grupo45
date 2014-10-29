<nav>
    <ul>
        {% if session.roleID == 1 %}
        <li><a href="./{{ server }}donantes">ABM de donantes</a></li>
        <li><a href="./{{ server }}entidadesReceptoras">ABM de entidades receptoras</a></li>
        <li><a href ="./{{ server }}alimentos">ABM de paquetes</a></li>
        <li disabled><a href = "#"  >ABM de servicios prestados(falta)</a></li> 		
        <li disabled><a href = "./{{ server }}usuarios" >ABM de Usuarios</a></li>
        {% endif %}

        {% if session.roleID == 3 or session.roleID==1 %}
        <li><a href="./{{ server }}listadoAlimentos">Listado de alimentos</a></li>
        <li disabled><a href="#">Consulta stock de alimentos</a></li>
        {% endif %}

        {% if session.roleID == 2 or session.roleID==1 %}
        <li><a href = "#" disabled >Confección y entrega de pedidos</a></li>
        <li disabled><a href = "./{{server}}turnosEntrega"  >ABM de turnos de entrega</a></li>
        {% endif %}

        <li><a href="./{{ server }}index">FRONTEND</a></li>

    </ul>
</nav>