<?php
include_once("PDOrepository.php");

class UserRepository extends PDOrepository
{
	private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }  
              
        return self::$instance;
    }

    public function getUser($username, $pass)
    {
    	$sql = "SELECT User.username, User.roleID FROM User WHERE User.username = ? and User.pass = ?";
    	$args = [$username, $pass];
    	$mapper = function($row){
    		return new UserModel($row['username'], $row['roleID']);
    	} ;
    	$answer = $this->queryList($sql, $args, $mapper);
    	
    	if ( count($answer) == 1 )
    	{
    		return $answer[0];
    	}
    	else
    	{
    		return false;
    	}
    }

}