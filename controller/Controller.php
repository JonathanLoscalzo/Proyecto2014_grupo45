<?php

abstract class Controller
{
	private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }        

        return self::$instance;
    }
    
    protected function __construct() {
        
    }
	
}
