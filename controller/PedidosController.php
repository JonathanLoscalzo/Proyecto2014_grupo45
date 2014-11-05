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
    
    
    public function edit($id) {
        
    }
    public function create($pedido) {
        
        // mucho por hacer aca....
        $arr_pedido = $pedido->getParams();
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $pedidoModelo = new PedidoModel(null, $arr_pedido['']);
                PedidoRepository::getInstance()->add($pedido);
            }
        }
        
    }
    public function remove($id) {}
    public function editView($id) {
    } 
    
    public function AJAX_agregarAlimento($id) {
        if (parent::backendIsLogged()) {
            $detalle = DetalleRepository::getInstance()->getByID($id);
            echo json_encode($detalle);
            die();
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
                    die();
        }
    }

    public function index() {
        if (parent::backendIsLogged()) {
               if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                        $view = new BackEndView();
                        $view->Pedidos();
                    }
                }
        }
}