<?php
include_once("/model/AlimentoRepository.php");
include_once("/model/AlimentoModel.php");
include_once("/model/DetalleRepository.php");
include_once("/model/DetalleModel.php");

class AlimentoController extends Controller 
{
    private static $instance = null;
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function create($post) {
        if (parent::backendIsLogged()) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new AlimentoModel();
            AlimentoRepository::getInstance()->add($entidad);
        }
    }
    public function edit($id) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new AlimentoModel();
            $this->index();
    }
    public function remove($id) {
         /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            AlimentoRepository::getInstance()->remove($id);
            LoginController::getInstance()->index();
        }
    }
    public function index() {
                /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */

        if (parent::backendIsLogged()) {
            $Alimento= AlimentoRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->alimentos($Alimento);
        }
    }
    public function editView($id) {
        if (parent::backendIsLogged()) {
            $Alimento = AlimentoRepository::getInstance()->getByID($id);
            $Detalle = DetalleRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->editViewAlimento($Detalle, $Alimento); // si no devuelve nada esta vista se encarga
        }
    }	
}