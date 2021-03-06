<?php

include_once('Controller.php');
include_once("repository/PDOrepository.php");
include_once("controller/RoleService.php");


class PedidosController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("ConfeccionPedidos");
    }
    
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function create($params) {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                try {
                    $obj = $params;
                    
                    $pedido = new PedidoModel(null, $obj['entidad'], null, 0, $obj['turno'], true);
                    $id = PedidoRepository::getInstance()->add($pedido);
                    foreach ($obj["detalle_alimento_id"] as $k => $v) {       
                        $pedido_has_detalle = new PedidoHasDetallesModel($id, $v, $obj["cantidad"][$k]);     
                        PedidoHasDetallesRepository::getInstance()->add($pedido_has_detalle);

                    }  
                    $_SESSION["message"] = new MessageService("createSuccess", [" pedido "]);
                }
                catch (Exception $e) {
                    $_SESSION['message'] = $e->getMessage();
                }
                
            }
        }
    }
    
    public function edit($id) {
        
    }
    public function remove($id) {}
    public function editView($id) {
    } 
    
    public function AJAX_agregarAlimento($id) {
        if (parent::backendIsLogged()) {
            $detalle = DetalleRepository::getInstance()->getByID($id);
            echo json_encode($detalle);
        }
    }
    public function AJAX_checkQty($id, $value) {
        // returns true if the entered qty is equal or less than 
        // then stock qty - reserved qty.
        if (parent::backendIsLogged()) {
               if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                   // first check
                   $element = DetalleRepository::getInstance()->getByID($id);
                   $margin = $element->getStock() - $element->getReservado();
                   if ($value <= $margin) {
                       echo 1;
                   }
                   else {
                       echo 0;
                   }
               }
        
        }
    }
    
    public function AJAX_getAlimentos() {

        if (parent::backendIsLogged()) {

                   
                    $detalles = DetalleRepository::getInstance()->getAll();
                    $key_arr = [];
                    for ($i=0; $i<count($detalles); $i++) {
                        array_push($key_arr, get_object_vars($detalles[$i]));
                    }
                    echo json_encode($key_arr);
        }
    }

    public function index() {
        if (parent::backendIsLogged()) {
               if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                        $entidades = EntidadReceptoraRepository::getInstance()->getAll();
                        $turnos = TurnoRepository::getInstance()->getAll();
                        $view = new BackEndView();
                        $view->Pedidos($entidades, $turnos);
                    }
                }
        }
}