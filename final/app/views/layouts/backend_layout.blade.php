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
            @if ($errors->has())
                <div id="errorwrap">
                    <div id="alert-dialog" class="alert-dialog" title="ALERTA">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            
            @if (Session::has('message'))
                <div>{{ Session::get('message') }}</div> <!-- aqui se deberia incluir un 
                                                         template para el error !-->
            @endif

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
