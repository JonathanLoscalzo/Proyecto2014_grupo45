<!DOCTYPE html>
<html>
    <head>
        <title>Banco de Alimentos</title>
        @section('head')
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="{{ $server }}css/style-backend.css" rel="stylesheet">
        <script type="text/javascript" src="{{$server}}js/plugins/jquery-2.1.2.js"></script>
        @stop
    </head>
    <body>
        <div id="wrapper">
            <div id="headerwrap">
                @include('layouts._header-backend.php')

            </div>
            <div id="navigationwrap">
                @include('layouts.menu-bar.php')
            </div>

            @if (isset($message) and not($message==""))
            {# JRL -> deberiamos agregar un alert que se pueda cerrar #}
            
            <div id="errorwrap">
                <div id="alert-dialog" class="alert-dialog {{ $message->class }}" title="ALERTA">
                    <ul>
                        <li><p> {{ $message->text }} </p></li>
                        <li><button id="dismiss" >X</button></li>
                    </ul>
                </div>
            </div>

            @endif      

            <div id="contentwrap">
                @yield('content')
            </div>
            @include('_footer.php')
     </div>
    </body>
    <script>
$(document).ready(function () {
    $('#dismiss').click(function () {
        $("#errorwrap").fadeOut();
    });
});
    </script>
    @yield('scripts')

</html>
