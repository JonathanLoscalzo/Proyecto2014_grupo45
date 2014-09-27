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
            $detalle_entidad = new DetalleModel($data['id'], $data['alimento_codigo'], $data['fecha_vencimiento'], 
                    $data['contenido'], $data['peso_unitario'], $data['stock'], 
                    $data['reservado']); // creamos el nuevo objeto que se introducira en la BD
            if ($data['flag'] == true) {
                // SI SE DESEA CREAR TAMBIEN UN ALIMNETO NUEVO
                AlimentoRepository::getInstance()->add($detalle_entidad->getAlimento());
                DetalleRepository::getInstance()->add($detalle_entidad);
            }
            else {
                // SI UNICAMENTE SE DESEA CREAR UN DETALLE, CON SU ALIMENTO ASOCIADO 
                // EXISTENTE EN LA BD:
                DetalleRepository::getInstance()->add($detalle_entidad);
            }
            
        }
    }
    public function edit($post) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new DetalleModel($data['id'], $data['alimento_codigo'], 
                    $data['fecha_vencimiento'], $data['contenido'],
                    $data['peso_unitario'], $data['stock'], $data['reservado']);
            DetalleRepository::getInstance()->edit($entidad);
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