<?php

include_once("repository/PDOrepository.php");

class UserRepository extends PDOrepository {

    private static $instance = null;
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    /* Metodo utilizado para el login. */
    public function getUser($username, $pass) {
        $sql = "SELECT * FROM user WHERE user.username = ? and user.pass = ?";
        $args = array($username, $pass);
        $mapper = function($row) {
            return new UserModel($row['userID'],$row['username'],"",$row['roleID']);
        };

        $answer = $this->queryList($sql, $args, $mapper);

        if (count($answer) == 1) {
            return $answer[0];
        } else {
            return false;
        }
    }

    public function add($user) {
        $sql = "insert into user (userID, username, pass, roleID) values (?,?,?,?)";
        $args = $user->getArray();
        $args[0] = NULL;
        $mapper = function ($row)
        {
            return $row;
        };
        
        return $this->queryList($sql, $args, $mapper);
    }

    public function edit($user) {
    /* Que datos deberian poder editarse? */
        $sql = "UPDATE user
                SET username= ?, pass= ? , roleID= ? 
                WHERE userID=?";
        
        $args = $user->getArray();
        
        array_push($args, $args[0]);
        array_shift($args);
        
        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
        
    }

    public function exist($username) {
        
        $sql = "select * from user where username = ?";
        $args = [$username];
        $mapper = function($row) { return $row; };
        
        $answer = $this->queryList($sql, $args, $mapper);
        return ($answer) ? TRUE : FALSE;
    }

    public function getAll() {
        $sql = "SELECT * FROM user";
        $args = [];
        $mapper = function ($row) {
            return new UserModel($row['userID'], $row['username'],"", $row['roleID']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function getByID($id) {
        $sql = "SELECT * FROM user where userID = ?";
        $args = [$id];
        $mapper = function ($row) {
            return new UserModel($row['userID'], $row['username'],$row['pass'], $row['roleID']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
    }
    
    public function getByUsername($username) {
        $sql = "SELECT * FROM user where username = ?";
        $args = [$username];
        $mapper = function ($row) {
            return new UserModel($row['userID'], $row['username'], $row['pass'], $row['roleID']);
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer[0];
    }

    public function remove($id) {
        $sql = "delete from user where userID = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        return $this->queryList($sql, $args, $mapper)[0];
    }

}
