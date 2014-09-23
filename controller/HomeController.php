<?php
include_once('../vistas/FrontEnd.php')

class HomeController extends Controller
{

	public function index()
	{
		$view = new FrontEnd();
        $view->index();
	}
	public function login()
	{
		$view = new FrontEnd();
        $view->login();
	}
	public function proyectos()
	{
		$view = new FrontEnd();
        $view->proyectos();
	}
	public function voluntariado()
	{
		$view = new FrontEnd();
        $view->voluntariado();
	}
	public function dona_ahora()
	{
		$view = new FrontEnd();
        $view->dona_ahora();
	}



}