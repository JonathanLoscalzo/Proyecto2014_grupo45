<?php

include_once('PDOrepository.php');

class DonanteRepository extends PDOrepository
{
	
	private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }  
              
        return self::$instance;
    }

    public function getDonantes()
    {
    	$sql = "SELECT donante.* FROM donante ";
    	$args = [];
    	$mapper = function($row){
    		return new DonanteModel($row['id'],
    			$row['razon_social'],
    			$row['apellido_contacto'],
    			$row['nombre_contacto'],
    			$row['telefono_contacto'],
    			$row['mail_contacto'],
    			$row['domicilio_contacto']);
    	} ; // deberia crear un builder, feo esto.
    	
        $answer = $this->queryList($sql, $args, $mapper);
    	
    	return $answer;
    }

    public function getDonanteByID($id)
    {
    	$sql = "SELECT donante.* FROM donante WHERE donante.id = ?";
    	$args = [$id];
    	$mapper = function($row){
    		return new DonanteModel($row['id'],
    			$row['razon_social'],
    			$row['apellido_contacto'],
    			$row['nombre_contacto'],
    			$row['telefono_contacto'],
    			$row['mail_contacto'],
    			$row['domicilio_contacto']);
    	} ; // deberia crear un builder, feo esto.
    	
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

    public function updateDonanteByID($donante)
   	{
   		$sql = "UPDATE donante 
   				SET donante.razon_social = ?,
   					donante.apellido_contacto = ?,
   					donante.nombre_contacto = ?,
   					donante.telefono_contacto = ?,
   					donante.mail_contacto = ?,
   					donante.domicilio_contacto = ?, 
   			 WHERE donante.id = ? ";
    	$args = $donante->getArray(); // debería ser en este orden
    	$mapper = function($row){
    		return new DonanteModel($row['id'],
    			$row['razon_social'],
    			$row['apellido_contacto'],
    			$row['nombre_contacto'],
    			$row['telefono_contacto'],
    			$row['mail_contacto'],
    			$row['domicilio_contacto']);
    	} ; // deberia crear un builder, feo esto.
    	
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