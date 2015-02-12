@extends('layouts.backend_layout')
@section('head')
    @parent
@stop


@section('content')
    <div id = "content">
        <h3> USUARIOS </h3>
        <div id="accordion">
            <h3>Alta</h3>
            <div>
                <form action="./{{$server}}final/public/backend/usuarios/add" method="POST">
                    <div class="conj-block">
                        <label for="nombreUsuario" style = "display : block">Nombre usuario: </label><input placeholder="MiUsuario" id="username" name="username" type="text" required >
                        <label for="pass1" style = "display : block">pass: </label><input id="pass"  type="password" name="pass" placeholder="********">
                        <label for="pass2" style = "display : block">repita pass: </label><input id="pass1"  type="password" name="pass2" placeholder="********">
                        <div id="dialog" title="ERROR EN EL FORMULARIO">
                            <p>LAS CONTRASEÑAS DEBEN SER IGUALES!.</p>
                        </div>
                    </div>
                    <div class="conj-block">
                        <label for="roleID" style = "display : block">Rol del usuario: </label>
                        <select id="roleID" required name ="roleID">
                            <option selected disabled hidden value=''></option>
                            @foreach ($roles->all() as $rol)
                                <option value="{{ $rol->roleID }}"> {{ $rol->roleuser }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button id="submit" type="submit" name="submit" disabled> Enviar </button>
                </form>
            </div>
            <h3>Baja y Modificación</h3>
            <div class = "tabla-class">
                <table id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>Nombre de usuario</th>
                            <th>Rol del usuario</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @foreach ($usuario->all() as $user)
                            @if ($user->username != Auth::User()->username)
                            <tr>
                                <td> {{ $user->username }} </td>
                                <td> 
                                    @foreach ($roles->all() as $rol)
                                        @if ($rol->roleID === $user->roleID)
                                            {{ $rol->roleuser }}
                                        @endif
                                    @endforeach
                                </td>
                                <td><a href="./{{$server}}/final/public/backend/usuarios/edit/{{ $user->userID }}"><img src="{{$server}}images/icons/glyphicons_235_pen.png" alt="modificar"></a></td>
                                <td><a href="./{{$server}}/final/public/backend/usuarios/remove/{{ $user->userID }}"><img src="{{$server}}images/icons/glyphicons_197_remove.png" alt="borrar"></a></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <link href="{{$server}}js/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
    <script src="{{$server}}js/plugins/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="{{$server}}js/plugins/jquery.dataTables-1.10.2.min.js"></script>
    <script>
        $(document).ready(function () {
            
            $('#accordion').accordion({collapsible: true, active: false});
            $('select').change(function () {
                var x = $(this).val();
                $("#" + $(this).attr('id') + "-input").val(x);
            });
            
            $("#dialog").dialog({
                autoOpen: false
            });
            
            //$('#tabla-entidades').dataTable();
            $("form").change(function(){
                if ($("#pass").val() === $("#pass1").val() && $('#pass').val() !== ""){
                    $("#submit").prop("disabled", false);
                }else{
                     $("#submit").css("disabled", true);
                }
            });
            
//            $("#pass, #pass1").blur(function () {
//                if ($("#pass").val() !== $("#pass1").val())
//                {
//                    $("#dialog").dialog("open");
//                }
//            });

        });
    </script>
@stop

