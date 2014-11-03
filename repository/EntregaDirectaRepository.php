<?php

class EntregaDirectaRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($obj) {
        $sql = "INSERT INTO entrega_directa(id, entidad_receptora_id, fecha) VALUES(?, ?, ?)";
        $sql2 = "select MAX(id) as id FROM entrega_directa";
        $args = $obj->getArray();
        //array_shift($args); // corremos el null
        array_pop($args); // quitamos el model sino da error de string parse
        $mapper = function($row) {
            return $row["id"];
        };
        
        $this->queryList($sql, $args, $mapper);
        
        return $this->queryList($sql2, [], $mapper)[0];
    }

    public function edit($obj) {
        // Me Parece que no hace falta un edit
    }

    public function exist($id) {
        
    }

    public function getAll() {
        $sql = "SELECT * FROM entrega_directa";
        $args = [];
        $mapper = function($row) {
            return new EntregaDirectaModel(
                    $row['id'], $row['entidad_receptora_id'], $row['fecha']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getByID($id) {

        $sql = "SELECT * FROM entrega_directa where id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new EntregaDirectaModel(
                    $row['id'], $row['entidad_receptora_id'], $row['fecha']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
    }

    public function remove($id) {
        
        $sql = "DELETE FROM entrega_directa WHERE id = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
        
    }

//put your code here
}
