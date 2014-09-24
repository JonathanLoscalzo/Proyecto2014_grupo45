<?php
/* faltaria quien cierra conexion a la base de datos? */
abstract class PDORepository {
    /* recordar crear un usuario en phpmyadmin */
    const USERNAME = "grupo_45";
    const PASSWORD = "";
	const HOST ="localhost";
	const DB = "grupo_45";
    
    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }
    
    protected function queryList($sql, $args, $mapper){
        $connection = $this->getConnection(); // hace la conexion
        $stmt = $connection->prepare($sql); // prepara la consulta
        $stmt->execute($args); //envia los parametros a la consulta
        $list = []; // lista vacia
        while($element = $stmt->fetch()) // mientras haya que consultar, mapeo el resultado en una lista
        {
            $list[] = $mapper($element);
        }

        return $list;
    }
    
}