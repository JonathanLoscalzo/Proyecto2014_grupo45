<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BancoRepository
 *
 * @author dante
 */

include_once("model/BancoModel.php");
include_once("repository/PDOrepository.php");


class BancoRepository extends PDORepository {
    //put your code here
    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    
    
    
    
    public function add($obj) {
     
    }
    public function getByID($id) {
        $sql = "SELECT * FROM banco";
        $args = [$id];
        $mapper = function($row) {
            return new BancoModel($row['id'], $row['nombre'], $row['ubicacion'], $row['lat'], $row['long']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer; 
        
    }
    public function getAll() {
        $sql = "SELECT * FROM banco";
        $args = [];
        $mapper = function($row) {
            return new BancoModel($row['id'], $row['nombre'], $row['ubicacion'], $row['lat'], $row['long']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;    
    }
    public function edit($obj) {
        
    }
    public function remove($id) {
        
    }
    public function exist($id) {
        
    }
    
}
