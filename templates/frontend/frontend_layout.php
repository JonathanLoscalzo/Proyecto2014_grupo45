<!DOCTYPE html>
<html>
    <head>
        {% block head %}
        <title>Banco de Alimentos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- FrontEnd page	 -->
        <link href="./{{server}}css/style.css" rel="stylesheet">

        {% endblock %}    

    </head>
    <body>
        <div id="headerwrap">

            {% include '_header-home.php' %}

        </div>
        <div id="navigationwrap">
            {% include '_nav-home.php' %}
        </div>

        {% if message is defined and not(message=="") %}
        {# JRL -> deberiamos agregar un alert que se pueda cerrar #}
        <div id="errorwrap">
            <div id="alert-dialog" class="alert-dialog {{ message.class }}" title="ALERTA">
                <ul>
                    <li><p> {{ message.text }} </p></li>
                    <li><button id="dismiss" >X</button></li>
                </ul>
            </div>
        </div>
        {% endif %}    
        <div id="leftcolumnwrap">

            {%	include '_aside-content.php' %}

        </div>

        <div id="contentwrap">
            {% block content %}


            {% endblock %}	
        </div>

        {% include '_footer.php' %}


    </body>
    <script>
        $(document).ready(function () {
            $('#dismiss').click(function () {
                $("#errorwrap").fadeOut();
            });
        });
    </script>
    {% block scripts %}

    {% endblock %}
</html>