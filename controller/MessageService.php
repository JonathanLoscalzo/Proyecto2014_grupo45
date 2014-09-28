<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("controller/MessageResource.php");

class MessageService {

    protected $text;
    private $classType = array("success" => "success", "error" => "error"); //ejemplo: info, error, dataResponse, etc...
    protected $class;

    public function __construct($message) {
        $res = new MessageResource();
        $arrayMessage = $res->getResource($message);
        $this->text=$arrayMessage[0];
        $this->class=$this->classType[$arrayMessage[1]];
    }

    public function parseJSON() {
        // return a JSON object of the message
        return json_encode((array) $this);
    }

    public function parseXHR() {
        // return a XMLHTTP RESPONSE object of the message
    }

    public function getText() {
        return $this->text;
    }

    public function getClass() {
        return $this->class;
    }

}
