<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadisticasRepository
 *
 * @author loscalzo
 */
class EstadisticasRepository extends PDORepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function add($obj) {
        
    }

    public function edit($obj) {
        
    }

    public function exist($id) {
        
    }

    public function getAll() {
        
    }

    public function getByID($id) {
        
    }

    public function remove($id) {
        
    }

    public function alimento_entre_fechas($from, $to) {
        $sql = "call alimentos_por_fechas_entre(?,?)";
        $args = [$from, $to];
        $mapper = function($row) {
            return [$row['fecha'], $row['kilogramos']];
        };
        return $this->queryList($sql, $args, $mapper);
    }
    
    public function alimento_entre_fechas_por_entidad($from, $to) {
        $sql = "call alimentos_por_entidad_entre_fechas(?,?)";
        $args = [$from, $to];
        $mapper = function($row) {
            return [$row['razon_social'], $row['kilogramos']];
        };
        return $this->queryList($sql, $args, $mapper);
    }
    
    public function alimentos_vencidos_agrupados_descripcion(){
        $sql = "select * from alimentosvencidos";
        $args = [];
        $mapper = function($row){
            return [$row['descripcion'], $row['cantidad']];
        };
        return $this->queryList($sql, $args, $mapper);
    }

}
