<!DOCTYPE html>
<html>
    <head>
        @yield('head')
        <title>Banco de Alimentos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- FrontEnd page	 -->
        <link href="./{{$server}}css/style.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./{{$server}}css/sunny/jquery-ui-1.9.2.custom.css">
        <script type="text/javascript" src="{{$server}}js/plugins/jquery-2.1.2.js"></script>   

    </head>
    <body>
        <div id="headerwrap">

            @include('layouts._header-home')

        </div>
        <div id="navigationwrap">
            @include('layouts._nav-home')
        </div>

        @if (isset($message) and not($message==""))
        <div id="errorwrap">
            <div id="alert-dialog" class="alert-dialog {{ $message->class }}" title="ALERTA">
                <ul>
                    <li><p> {{ $message->text }} </p></li>
                    <li><button id="dismiss" >X</button></li>
                </ul>
            </div>
        </div>
        @endif  
        <div id="leftcolumnwrap">
            @include('layouts._aside-content')

        </div>

        <div id="contentwrap">
            @yield('content')


	
        </div>
        @include('layouts._footer')


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