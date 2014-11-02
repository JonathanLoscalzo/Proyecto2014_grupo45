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

//put your code here
}
