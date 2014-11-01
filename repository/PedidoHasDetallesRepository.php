<?php

class PedidoHasDetallesRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    public function getByID($id) {}
    
    public function getByPedido($numero) {
        $sql = "SELECT * FROM alimento_pedido WHERE numero=?";
        $args = [$numero];
        $mapper = function ($row) {
            return new PedidoHasDetallesModel($row['pedido_numero'], $row['detalle_alimento_id'], $row['cantidad']); 
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer; // deberia devolver un array de PedidosHasDetalles
    }
    public function add($obj) {
        $sql = "insert into alimento_pedido values(?,?,?)";
        $args = $obj->getArray();
        $mapper = function($row){
            return $row;
        };
        
        return $this->queryList($sql, $args, $mapper);
    }

    public function edit($obj) { // edita cantidad buscando por pedido
        $sql = "update alimento_pedido set cantidad = ? where numero = ?";
        $args = $obj->getArray(); // FALTA HACER
        $mapper = function($row){ return $row ; };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
    }
    
    public function exist($id) {}

    public function getAll() {
        
        $sql = "SELECT * FROM alimento_pedido";
        $args = [];
        $mapper = function ($row) {
            return new PedidoHasDetallesModel($row['pedido_numero'], $row['detalle_alimento_id'], $row['cantidad']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }

    public function remove($pedido) {
        $sql = "delete from alimento_pedido where pedido_numero=?"; // QUIEN HACE LA SUMA
        // DE LOS PEDIDOS BORRADOS AL STOCK NUEVAMENTE?, MySQL?, PHP?, QUE MODULO PHP?.
        $args = [$pedido];
        $mapper = function ($row) {
            return $row;
        };
        return $this->queryList($sql, $args, $mapper)[0];
    }
}

