<!DOCTYPE html>
<html>
    <head>
        @yield('head')
        <title>Banco de Alimentos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="{{ $server }}css/style-backend.css" rel="stylesheet">
        <script type="text/javascript" src="{{$server}}js/plugins/jquery-2.1.2.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="headerwrap">
                @include('layouts._header-backend')

            </div>
            <div id="navigationwrap">
                @include('layouts.menu-bar')
            </div>
     

            <div id="contentwrap">
                @yield('content')
            </div>
            @include('layouts._footer')
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
