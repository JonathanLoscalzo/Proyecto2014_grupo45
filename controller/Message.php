<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Message {
    private static $instance = null;
            
    protected $message;
    protected $type;//ejemplo: info, error, dataResponse, etc...
    protected $value; // ejemplo: algun valor numerico de condicion, puede servir
            // para errores.


    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function __construct($message, $type, $value=null) {
        $this->message = $message;
        $this->type = $type;
        $this->value = $value;
    }
    public function parseJSON() {
        // return a JSON object of the message
        return json_encode((array)$this);
    }
    
    public function parseXHR() {
        // return a XMLHTTP RESPONSE object of the message
    }
    
    public function getMessage() {}
    
    public function getType() {}
    
    public function getValue() {}
}