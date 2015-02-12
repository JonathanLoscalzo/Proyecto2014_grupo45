<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguracionModel
 *
 * @author dante
 */
include_once("model/Model.php");

class ConfiguracionModel extends Model {
    //put your code here
    public $dias_vencimiento;
    public function __construct($dias_vencimiento) {
        $this->dias_vencimiento = $dias_vencimiento;
        return $this;
    }
    
    public function getDias_vencimiento() {
        return $this->dias_vencimiento;
    }
    
}
