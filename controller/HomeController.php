<?php

include_once("Controller.php");
include_once("repository/DonanteRepository.php");
include_once("model/DonanteModel.php");

class HomeController extends Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct() {
        
    }

    public function index() {
        $view = new FrontEndView();
        $view->index();
    }

    public function login() {
        $view = new FrontEndView();
        $view->login();
    }

    public function proyectos() {
        $view = new FrontEndView();
        $view->proyectos();
    }

    public function voluntariado() {
        $view = new FrontEndView();
        $view->voluntariado();
    }

    public function dona_ahora() {
        $view = new FrontEndView();
        $view->dona_ahora();
    }

    public function listDonante() {
        $lista_donantes = DonanteRepository::getInstance()->getAll();
        $view = new FrontEndView();
        $view->listar_donantes($lista_donantes);
    }
    
    public function listadoEntidadesReceptoras() {
        $entidades = EntidadReceptoraRepository::getInstance()->getAll();
        $view = new FrontEndView();
        $view->listar_entidadesreceptoras($entidades);
    }
    public function acerca_de() {
        // LOGIN LINKEDIN and retrive data
        $view = new FrontEndView();
        $linkedin_data = "";
        $view->acerca_de($linkedin_data);
    }
    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

}
