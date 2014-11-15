<?php

include_once 'repository/EstadisticasRepository.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstadisticasController extends Controller {

    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

    /* una por cada enunciado */

    public function uno($from, $to) {

        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        $array = EstadisticasRepository::getInstance()->alimento_entre_fechas($from->format('Y-m-d'), $to->format('Y-m-d'));
        echo json_encode($array);
    }

    public function dos($from, $to) {
        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        $array = EstadisticasRepository::getInstance()->alimento_entre_fechas_por_entidad($from->format('Y-m-d'), $to->format('Y-m-d'));
        echo json_encode($array);
    }

    public function tres() {

        echo json_encode($data);  
    }
    
    public function alertas() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $view = new BackEndView();
                $pedidos = PedidoRepository::getInstance()->getPedidosByDate(Date('Y-m-d'));
                $detalles = DetalleRepository::getInstance()->getAllVencimientoCercano();
                $view->alertas($pedidos, $detalles);
            }
        }
    }

    public function index() {
        $view = new BackEndView();
        $view->estadisticas();
    }

}
