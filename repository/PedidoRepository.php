<?php

include_once("model/PedidoModel.php");

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
            return new PedidoModel($row['numero'], $row['entidad_receptora_id'], 
                   $row['fecha_ingreso'], $row['estado_pedido_id'], 
                    $row['turno_entrega_id'], $row['con_envio']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0]; // deberia devolver solo 1. 
    }
    public function add($obj) {
        $sql = "INSERT INTO `pedido_modelo`(`entidad_receptora_id`,`estado_pedido_id`,"
                . "`turno_entrega_id`, `con_envio`) "
                . "VALUES (?, ?, ?, ?)";
        $sql2 = "select MAX(numero) as numero FROM pedido_modelo";
        $args = $obj->getArray();
        unset($args[2], $args[0]);
        array_pop($args);
        array_pop($args);
        array_pop($args);
        array_pop($args);
        $args = array_values($args); // reindexamos array.
        $mapper = function($row){
            return $row["numero"];
        };
        
        $this->queryList($sql, $args, $mapper);
        return $this->queryList($sql2, [], $mapper)[0];
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

    public function edit($obj) {
        
    }

    public function exist($id) {
        
    }

    public function remove($id) {
        
    }
    public function getPedidosByDate($date) {
        $sql = "SELECT * FROM 
            ( SELECT * FROM pedido_modelo INNER JOIN turno_entrega ON 
            turno_entrega_id = turno_entrega.id ) 
            AS pedidos 
            WHERE fecha=?";
        $args = [$date];
        $mapper = function ($row) {
            return new PedidoModel($row['numero'], 
                    $row['entidad_receptora_id'], $row['fecha_ingreso'], 
                    $row['estado_pedido_id'], $row['turno_entrega_id'], 
                    $row['con_envio']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }
    
        public function getPedidosByDateSinEnviar($date) {
        $sql = "SELECT * FROM 
            ( SELECT * FROM pedido_modelo INNER JOIN turno_entrega ON 
            turno_entrega_id = turno_entrega.id ) 
            AS pedidos 
            WHERE fecha=? and estado_pedido_id=0";
        $args = [$date];
        $mapper = function ($row) {
            return new PedidoModel($row['numero'], 
                    $row['entidad_receptora_id'], $row['fecha_ingreso'], 
                    $row['estado_pedido_id'], $row['turno_entrega_id'], 
                    $row['con_envio']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
        
    }
    
    public function setEstado($id) {
        $sql = "UPDATE pedido_modelo SET estado_pedido_id=1 WHERE numero=?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

}