<?php

class LoginStatus
{
	private $instance = null;
	
	private static $status = array(
		'loginStatusOK',
		'loginStatusAlredyLogin',
		'loginStatusError',
		'loginStatusWithoutPermissions'
	);

	public static function getInstance() {

	    if (is_null(self::$instance)){
	        self::$instance = new static();
	    }        

	    return self::$instance;
	}

	private function __construct()
	{

	}

	public static function loginStatusOK()
	{
		return "Usuario inició sesión correctamente";
	}

	public static function loginStatusAlredyLogin()
	{
		return "Usuario no puede iniciar sesión dos veces, debe cerrar sesión";
	}

	public static function loginStatusError()
	{
		return "Usuario no existente, contraseña o nombre de usuario incorrectos";
	}

	public static function loginStatusWithoutPermissions()
	{
		return " UD. No tiene permiso para llegar aqui !!! ";
	}

	public static function call($num)
	{
		$func = self::$status[$num];
		return LoginStatus::$func();

		//return LoginStatus::status[$num]();
	}
}