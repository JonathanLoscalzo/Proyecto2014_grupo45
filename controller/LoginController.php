<?php
include_once("Controller.php");
include_once("model/UserModel.php");
include_once("model/UserRepository.php");
include_once("model/PDOrepository.php");

class LoginController extends Controller
{
	private static $instance = null;
	private static $loginStatus = array(
		0 => "Usuario inició sesión correctamente",
		1 => "Usuario no puede iniciar sesión dos veces, debe cerrar sesión",
		2 => "Usuario no existente, contraseña o nombre de usuario incorrectos",
		3 => " UD. No tiene permiso para llegar aqui !!! ",
	);

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }        

        return self::$instance;
    }
    
	protected function __construct() {
        
    }

    public function startSession()
    {
		if(!isset($_SESSION)) 
		{ 
		        session_start(); 
		}
		
    }
    
    private function destroySession()
	{	
		if (isset($_SESSION))
		{
			session_destroy();
		}
		
	}

	public function isSessionStart()
	{
		self::startSession();
		return isset($_SESSION['username']);
	}

	public function login( $user, $pass )
	{
		/* deberia validar en la base de datos */
		
		$aux = self::createSession($user, $pass);

		switch ($aux) {
			case 0:
			case 1:
				$view = new BackEndView();
				$view->index(self::$loginStatus[$aux]);
				break;
			case 2:
				$view = new FrontEndView();
				$view->index(self::$loginStatus[$aux]);
				break;	
		}
		
	}

	public function backend()
	{
		/*verificar si la sesion està iniciada?*/
		self::startSession();
		if (self::isSessionStart())
		{
			$view = new BackEndView();
			$view->index();
		}
		else
		{
			$view = new FrontEndView();
			$view->index(self::$loginStatus[3]);
		}
	}

	private function createSession($userName, $pass)
	{
		/*
		*	Esta funcion crea una sesion de usuario.
		*	Si puede iniciar sesion, conecta
		*	
		*/
		self::startSession();
		if (!self::isSessionStart())
		{	

			$actualUser = UserRepository::getInstance()->getUser($userName, $pass);
			if ($actualUser != false)
			{
				$_SESSION['username'] = $actualUser->getUsername();
				$_SESSION['roleID'] = $actualUser->getRole();
				return 0;
			}
			else
			{
				return 2;
			}
			
		}
		else
		{
			return 1;
		}
	}

	public function logout()
	{
		self::destroySession();
		self::startSession();
		$view = new FrontEndView();
		/*enviar un alert o mensaje global aqui*/
		$view->index();
	}



	

}