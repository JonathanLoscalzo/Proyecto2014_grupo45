<?php
include_once("Controller.php");

class HomeController extends Controller
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

	public function index()
	{
		$view = new FrontEndView();
        $view->index();
	}
	public function login()
	{
		$view = new FrontEndView();
        $view->login();
	}
	public function proyectos()
	{
		$view = new FrontEndView();
        $view->proyectos();
	}
	public function voluntariado()
	{
		$view = new FrontEndView();
        $view->voluntariado();
	}
	public function dona_ahora()
	{
		$view = new FrontEndView();
        $view->dona_ahora();
	}



}