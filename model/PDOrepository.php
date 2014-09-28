<?php
/* faltaria quien cierra conexion a la base de datos? */
abstract class PDORepository {
    /* recordar crear un usuario en phpmyadmin */
    const USERNAME = "grupo_45";
    const PASSWORD = "1aGUQ3ASOu81kJSu";
	const HOST ="localhost";
	const DB = "grupo_45";
    
    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        try{
            $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        }
        catch (PDOException $e) {
            echo "problema ",$e->getMessage(); // nose que hacer.
        }
        return $connection;
    }
    
    protected function queryList($sql, $args, $mapper){
        /*
            ver metodos quizàs se puede refactorizar esto
            fetchAll();
            fetch_class();
        */
          
        $connection = $this->getConnection(); // hace la conexion
        $stmt = $connection->prepare($sql); // prepara la consulta
        
        $stmt->execute($args); //envia los parametros a la consulta , Devuelve un resource
              

        $list = []; // lista vacia
        try{
            while($element = $stmt->fetch()) // mientras haya que consultar, mapeo el resultado en una lista
            {
                $list[] = $mapper($element); // esto agrega?
            }

            $connection = null; // para cerrar la conexion
            return $list;
        }
        catch (PDOException $e){
            echo "ERROR ",$e->getMessage();
            die;
        }

    }
    
}