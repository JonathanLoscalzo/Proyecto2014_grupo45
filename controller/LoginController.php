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
		2 => "Usuario no existente, pruebe contraseña o nombre de usuario",
		3 => "",
	);

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }        

        return self::$instance;
    }
    
	protected function __construct() {
        
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

	private function createSession($userName, $pass)
	{
		/*
		*	Esta funcion crea una sesion de usuario.
		*	Si puede iniciar sesion, conecta
		*	
		*/
		session_start();
		if (!isset($_SESSION['username']))
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
		$view = new FrontEndView();
		/*enviar un alert o mensaje global aqui*/
		$view->index();
	}

	private function destroySession()
	{	/*deberia usar session_destroy() sesision_start() ??? */
		session_start();
		unset($_SESSION['username']);
		unset($_SESSION['roleID']);
	}

}