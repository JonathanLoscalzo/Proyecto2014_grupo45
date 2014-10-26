<?php

/* no deberìa ser singleton, dudas! */
/* no modelo la clase padre model porque estaria vacia? */
include_once("model/Model.php");

class UserModel extends Model {

    private $userID;
    private $username;
    private $pass;
    private $roleID;

    public function __construct($userID,$pass, $username, $roleID) {
        $this->userID = $userID;
        $this->username = $username;
        $this->pass = $pass;
        $this->roleID = $roleID;
    }

     public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRoleID() {
        return $this->roleID;
    }
    
    public function setUsername($username){
        $this->username= $username;
    }
    
    public function setRoleID($roleID) {
        $this->roleID = $roleID;
    }

}
