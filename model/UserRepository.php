<?php

include_once("PDOrepository.php");

class UserRepository extends PDOrepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getUser($username, $pass) {
        $sql = "SELECT user.username, user.roleID FROM user WHERE user.username = ? and user.pass = ?";
        $args = array($username, $pass);
        $mapper = function($row) {
            return new UserModel($row['username'], $row['roleID']);
        };

        $answer = $this->queryList($sql, $args, $mapper);

        if (count($answer) == 1) {
            return $answer[0];
        } else {
            return false;
        }
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

}
