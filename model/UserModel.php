<?php

/* no deberìa ser singleton, dudas! */
/* no modelo la clase padre model porque estaria vacia? */
include_once("model/Model.php");

class UserModel extends Model {

    protected $userID;
    protected $username;
    protected $pass;
    protected $roleID;

    public function __construct($userID, $username, $pass, $roleID) {
        $this->userID = $userID;
        $this->username = $username;
        $this->pass = $pass;
        $this->roleID = $roleID;
        return $this;
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

    public function getPass() {
        return $this->pass;
    }

    public function setUsername($username) {
        return $this->username = $username;
    }

    public function setRoleID($roleID) {
        return $this->roleID = $roleID;
    }

}
