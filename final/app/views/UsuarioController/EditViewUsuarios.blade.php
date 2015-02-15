@extends('layouts.backend_layout')

@section('head')
    @parent
    <script type="text/javascript" src="{{ $server }}js/plugins/jquery-2.1.2.js"></script>

@stop

@section('content')
    <div id="content">
        <h3> Editar Usuario </h3>
        <form action="./{{$server}}final/public/backend/usuarios/edit" method="POST">
            <div class="conj-block">
                <input style="display: none" value="{{ $usuario->userID }}" name="userID">
                <label for="nombreUsuario" style = "display : block">Nombre usuario: </label><input placeholder="MiUsuario" id="username" name="username" type="text" required value="{{ $usuario->username }}">
                <label for='pass'>Password viejo</label>
                <input type='password' name='pass' id='pass'>
                <label for='pass2'>Nuevo password</label>
                <input type='password' name='pass2' id='pass2'>
               
            </div>
            <div class="conj-block">
                <label for="roleID" style = "display : block">Rol del usuario: </label>
                <select id="roleID" required name ="roleID">
                    <option selected disabled hidden value=''></option>
                     @foreach ($roles as $role)
                        @if ($role->roleID == $usuario->roleID)
                            <option value="{{ $role->roleID }}" selected> {{ $role->roleuser }}</option>
                        @else
                            <option value="{{ $role->roleID }}"> {{ $role->roleuser }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button id="submit" type="submit" name="submit" > Enviar </button>
        </form>
    </div>
@stop
