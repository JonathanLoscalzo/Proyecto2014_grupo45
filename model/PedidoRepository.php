<?php

class PedidoRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function getByID($numero) {
        $sql = "SELECT * FROM pedido_modelo WHERE numero=?";
        $args = [$numero];
        $mapper = function ($row) {
            return new EstadoPedidoModel($row['numero'], $row['entidad_receptora_id'], 
                    $row['fecha_ingreso'], $row['estado_pedido_id'], 
                    $row['turno_entrega_id'], $row['con_envio']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0]; // deberia devolver solo 1. 
    }
    public function add($obj) {
        $sql = "INSERT INTO `pedido_modelo`(`entidad_receptora_id`,"
                . " `fecha_ingreso`, `estado_pedido_id`, "
                . "`turno_entrega_id`, `con_envio`) "
                . "VALUES (?, ?, ?, ?, ?)";
        $args = $obj->getArray();
        array_shift($args); // corremos el null
        // model delete
        array_pop($args);
        array_pop($args);
        array_pop($args);
        // end model delete
        $mapper = function($row){
            return $row;
        };
        
        return $this->queryList($sql, $args, $mapper);
    }
    public function getAll() {
        $sql = "SELECT * FROM pedido_model";
        $args = [];
        $mapper = function($row) {
            return new PedidoModel($row['numero'],
                    $row['entidad_receptora_id'], 
                    $row['fecha_ingreso'], 
                    $row['estado_pedido_id'], 
                    $row['turno_entrega_id'], 
                    $row['con_envio']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }
}