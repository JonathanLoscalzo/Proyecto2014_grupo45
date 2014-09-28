<?php
include_once("model/AlimentoRepository.php");
include_once("model/AlimentoModel.php");
include_once("model/DetalleRepository.php");
include_once("model/DetalleModel.php");

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
            // se crea con NULL debido a que ID es auto-incremental
            $detalle_entidad = new DetalleModel(null, $data['alimento_codigo'], $data['fecha_vencimiento'], 
                    $data['contenido'], $data['peso_unitario'], $data['stock'], 
                    $data['reservado']); // creamos el nuevo objeto que se introducira en la BD
            var_dump($detalle_entidad);
            if ($data['flag'] === 1) {
                // VOY A USAR INTEGER EN VEZ DE BOOL, 1 = TRUE, 0 = FALSE
                // SI SE DESEA CREAR TAMBIEN UN ALIMNETO NUEVO
                AlimentoRepository::getInstance()->add($detalle_entidad->getAlimento());
                DetalleRepository::getInstance()->add($detalle_entidad);
            }
            else {
                // SI UNICAMENTE SE DESEA CREAR UN DETALLE, CON SU ALIMENTO ASOCIADO 
                // EXISTENTE EN LA BD:
                DetalleRepository::getInstance()->add($detalle_entidad);
            }
            header("Location: ../alimentos" );
            
        }
    }
    public function edit($post) {
        if (parent::backendIsLogged()) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new DetalleModel($data['id'], $data['alimento_codigo'], 
                    $data['fecha_vencimiento'], $data['contenido'],
                    $data['peso_unitario'], $data['stock'], $data['reservado']);
            DetalleRepository::getInstance()->edit($entidad);
            $this->index();
            header("Location: ../../donantes" );
        }
    }
    public function remove($id) {
         /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            AlimentoRepository::getInstance()->remove($id);
            LoginController::getInstance()->index();
            header("Location: ../../donantes" );
        }
    }
    public function index() {
                /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */

        if (parent::backendIsLogged()) {
            // Se traen todos los alimentos (tipos) y todos los detalles
            // los alimentos se traen para poder completar la lista de tipos
            $Alimento= AlimentoRepository::getInstance()->getAll();
            $Detalle = DetalleRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->alimentos($Alimento, $Detalle);
        }
    }
    public function editView($id) {
        // ACA QUE TENGO QUE HACER?
        if (parent::backendIsLogged()) {
            
            $Detalle = DetalleRepository::getInstance()->getByID($id);
            $Alimento = $Detalle->getAlimento();
            $view = new BackEndView();
            $view->editViewAlimento($Alimento, $Detalle); // si no devuelve nada esta vista se encarga
        }
    }	
    public function listarAlimentos() {
        if (parent::backendIsLogged()) {
            $Detalle = DetalleRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->listado_alimentos($Detalle); 
        }
    }
}