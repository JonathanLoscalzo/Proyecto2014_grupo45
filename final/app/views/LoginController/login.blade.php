@extends('layouts.frontend_layout')

@section('content')
<div id="content">
<!-- se puede usar 'action' => 'LoginController@doLogin' pero no anda REVISAR !-->
	{{ Form::open(array(
                    'url' => 'login', 
                    'method' => 'POST',
            )) }}
        <label for="#login-user">Usuario: </label><input id="login-name" name="username" type="text" required />
        <label for="#login-pass">Contraseña: </label><input id="login-pass" type="password" name="pass" required/>
        <button type="submit" >iniciar sesión</button>
        {{ Form::close() }}
    </form>
</div>
@stop

