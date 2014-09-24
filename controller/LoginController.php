<?php
include_once("Controller.php");
include_once("model/UserModel.php");
include_once("model/UserRepository.php");

class LoginController extends Controller
{
	private static $instance = null;

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
		
		/*if (createSession($user, $pass))
		{

		}
		else
		{

		}*/

		$view = new BackEndView();
		$view->index();
	}

	private function createSession($user, $pass)
	{
		/*
		*	Esta funcion crea una sesion de usuario.
		*	Si puede iniciar sesion, conecta
		*
		*
		*
		*/
		session_start();
		if (!isset($_SESSION["username"]))
		{	

			$actualUser = UserRepository::getUser($userName, $pass);
			if ($actualUser != false)
			{
				$_SESSION["username"] = $actualUser.username;
				$_SESSION["roleID"] = $actualUser.roleID;
				return true;
			}
			else
			{
				return false;
			}
			
		}
	}

	public function logout()
	{

	}

	private function destroySession()
	{

	}

}