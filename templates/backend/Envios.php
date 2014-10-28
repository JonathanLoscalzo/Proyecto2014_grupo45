{% extends "backend_layout.php" %}
{% block head %}
{{ parent() }}
<link rel="stylesheet" type="text/css" href="{{server}}css/sunny/jquery-ui-1.9.2.custom.css">
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-ui-1.11.js"></script>
<script type="text/javascript" src="{{server}}js/plugins/jquery-2.1.2.js"></script>
{% endblock %}


{% block content %}
<body>
   <div id="contentwrap" style="height: 550px">
        <div id="content" style="height:480px;width: 640px;"></div>
   </div>
   <div id="content" class="tabla-class">
       <table>
           <thead>
               <tr>
                   <th>Entidad Receptora</th>
                   <th>Fecha de entrega</th>
                   <th>Estado entrega</th>
                   <th>Detalle Pedido</th>
               </tr>
            </thead>
               <tbody style="text-align: center">
                   <tr>
                       <td>Entidad Cacho</td>
                       <td>12-05-2014 12:23</td>
                       <td>No Entregado</td>
                       <td><button>Ver Detalle</button></td>
                   </tr>
               </tbody>
       </table>
   </div>
</body>
{% endblock %}


{% block scripts %}
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript">
    var zoom = 13;
    function mapInit() {
        var map = new OpenLayers.Map({
            div: 'content',
            controls: [
                new OpenLayers.Control.Attribution(),
                new OpenLayers.Control.TouchNavigation({
                    dragPanOptions: {
                        enableKinetic: true
                    }
                }),
                new OpenLayers.Control.Zoom()
            ],
            layers: [
                new OpenLayers.Layer.OSM()
            ]
        });
        return map;
    }
    map = mapInit();
    var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
    var toProjection   = map.getProjectionObject(); // to Spherical Mercator Projection
    
    
    
    function EntidadReceptora(nombre, lat, lon, tipo){
         this.nombre=nombre;
         this.dire=new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
         this.tipo= tipo;
         return this;
    }
    
    

    var entidades=new Array(); // HERE GOES THE AJAX CALL
    entidades[0]= new EntidadReceptora("Normal 1", -34.921986,-57.957281, "E");
    entidades[1]= new EntidadReceptora("Liceo", -34.910019,-57.950073, "E");
     function crearMarcador(entidad) {
          var iconoEscuela = new OpenLayers.Icon("/images/icons/pin.png");
          iconoEscuela.size.w *=2;
          iconoEscuela.size.h *=2;
          iconoEscuela.title = entidad.nombre;
          var lugar=  entidad.dire;
          if (entidad.tipo=="E")
            icono=iconoEscuela;

          var marcador = new OpenLayers.Marker(lugar, icono);

          return marcador;
       }
 
    var markers = new OpenLayers.Layer.Markers( "Marcadores" );
    map.addLayer(markers);
    for(var i = 0; i <entidades.length; i++) {
			markers.addMarker(crearMarcador(entidades[i]));
                    
     }
    map.setCenter(entidades[1].dire, zoom);
    
    Route = new YourNavigation.Route(map);
    
    
</script>

{% endblock %}
