<?php
include_once("model/PDORepository.php");
include_onde("model/AlimentoModel.php");

class AlimentoRepository extends PDORepository
{
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }  
              
        return self::$instance;
    }
    public function addAlimento($codigo, $descripcion) {
        $sql = "INSERT INTO alimento VALUES(?, ?)";
        $args = array($codigo, $descripcion);
        $mapper = function($row) {}; // que carajo hace mapper cuando no se
        // necesita?
        $answer = $this->queryList($sql, $args, $mapper);
        
    }
    public function getAlimento($codigo) {
        $sql = "SELECT * FROM alimento WHERE alimento.codigo = ?";
        $args = array($codigo);
        $mapper = function($row) {
            return new AlimentoModel($row['codigo'], $row['descripcion']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
    }
    public function updateAlimento($codigo, $descripcion) {
        // por ahora no permito cambiarle el codigo, desp se verá si es necesario
        $sql = "UPDATE alimento SET descripcion=? WHERE alimento.codigo = ?";
        $args = array($descripcion, $codigo);
        $mapper = function($row) {};
        $answer = $this->queryList($sql, $args, $mapper);
        $answer = count($answer) == 1 ? answer[0] : false; // short if, mas comodo
        return $answer;
    }
}