<?php

include_once("PDOrepository.php");

class UserRepository extends PDOrepository {

    private static $instance = null;

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

    public function add(UserModel $user) {
        $sql = "insert into user values (?,?,?,?)";
        $args = $user->getArray();
        $mapper = function ($row)
        {
            return new UserModel(NULL,row['username'],row['pass'],row['roleID']);
        };
        
        return $this->queryList($sql, $args, $mapper);
    }

    public function edit(UserModel $user) {
        
        $sql = "UPDATE entidad_receptora
                SET username=?, pass=? , roleID=? 
                WHERE Id=?";
        
        $args = $user->getArray();
        
        array_pop($args);
        array_pop($args);
        array_pop($args);
        array_push($args, $args[0]);

        $mapper = function($row) {
            return $row;
        };
        $answer = $this->queryList($sql, $args, $mapper);
        return count($answer) > 0 ? $answer[0] : False;
        
    }

    public function exist($id) {
        
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
        return $answer;
    }

    public function remove($id) {
        $sql = "delete from user where userID = ?";
        $args = [$id];
        $mapper = function ($row) {
            return $row;
        };
        return $this->queryList($sql, $args, $mapper);
        
    }

}
