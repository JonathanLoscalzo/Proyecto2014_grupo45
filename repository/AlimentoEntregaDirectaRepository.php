<?php

class AlimentoEntregaDirectaRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($obj) {
        $sql = "INSERT INTO alimento_entrega_directa(entrega_directa_id, detalle_alimento_id, cantidad) VALUES(?, ?, ?)";
        $args = $obj->getArray();
        //array_shift($args); // corremos el null
        //array_pop($args); // quitamos el model sino da error de string parse
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function edit($obj) {
        
    }

    public function exist($id) {
        
    }

    public function getAll() {
        
    }

    public function getByID($id) {
        
    }

    public function getAllById($id) {
        $sql = "SELECT * FROM alimento_entrega_directa WHERE entrega_directa_id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new AlimentoEntregaDirectaModel(
                   $row['entrega_directa_id'], $row['detalle_alimento_id'], $row['cantidad']
            );
        };
        return $this->queryList($sql, $args, $mapper);
    }

    public function remove($id) {
        // lo implementa un trigger cuando se elimina una entregadirecta
    }

//put your code here
}
