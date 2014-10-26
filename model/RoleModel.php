<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleModel
 *
 * @author loscalzo
 */
class RoleModel extends Model {
    //put your code here
    private $roleID;
    private $roleuser;
    private $description;
    
    public function __construct($roleID, $roleuser, $description) {
        $this->roleID = $roleID;
        $this->roleuser = $roleuser;
        $this->description = $description;
    }

    public function getRoleID(){ return $this->roleID; }
    public function getRoleuser(){ return $this->roleuser; }
    public function getDescription(){return $this->description; }
    
       
}
