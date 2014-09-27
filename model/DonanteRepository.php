<?php

include_once('PDOrepository.php');
include_once('DonanteModel.php');

class DonanteRepository extends PDOrepository {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function getAll() {
        $sql = "SELECT donante.* FROM donante ";
        $args = [];
        $mapper = function($row) {
            return new DonanteModel($row['Id'], $row['razon_social'], $row['apellido_contacto'], $row['nombre_contacto'], $row['telefono_contacto'], $row['mail_contacto'], $row['domicilio_contacto']);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);

        return $answer;
    }

    public function getByID($id) {
        $sql = "SELECT donante.* FROM donante WHERE donante.Id = ?";
        $args = [$id];
        $mapper = function($row) {
            return new DonanteModel($row['Id'], $row['razon_social'], $row['apellido_contacto'], $row['nombre_contacto'], $row['telefono_contacto'], $row['mail_contacto'], $row['domicilio_contacto']);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);

        if (count($answer) == 1) {
            return $answer[0];
        } else {
            return false;
        }
    }
    public function getByRazonSocial($razonSocial) {
                $sql = "SELECT donante.* FROM donante WHERE donante.razon_social = ?";
        $args = [$razonSocial];
        $mapper = function($row) {
            return new DonanteModel($row['Id'], $row['razon_social'], $row['apellido_contacto'], $row['nombre_contacto'], $row['telefono_contacto'], $row['mail_contacto'], $row['domicilio_contacto']);
        }; // deberia crear un builder, feo esto.

        $answer = $this->queryList($sql, $args, $mapper);

        if (count($answer) == 1) {
            return $answer[0];
        } else {
            return false;
        }
    }

    public function add($donante) {
        /*
          que bobo. Se podia usar user_vars_func
          en vez de poner ? se podia poner los nombres de las keys.
         */
       
        
        $sql = "INSERT INTO 
            donante(razon_social,
                    apellido_contacto,
                    nombre_contacto,
                    telefono_contacto,
                    mail_contacto,
                    domicilio_contacto) 
                VALUES (?,?,?,?,?,?)";
        $mapper = ""; //nose que poner acà
        $args = $donante->getArray();
        array_pop($args);
        /* quien valida los datos? */
        $answer = $this->queryList($sql, $args, $mapper);
        return $answer;
    }

    public function edit($donante) {

        $sql = "UPDATE donante
                SET razon_social = ?,
                    apellido_contacto = ? ,
                    nombre_contacto = ?,
                    telefono_contacto = ?,
                    mail_contacto = ?,
                    domicilio_contacto = ?) 
                WHERE Id = ?";
        $args = $donante->getArray();
        $mapper = ""; //nose que poner acà
        /* quien valida los datos? */
        return $answer = $this->queryList($sql, $args, $mapper);
    }

    public function remove($id) {
        $args = [$id];
        $sql = " DELETE FROM donante
                WHERE donante.Id = ?";
        $mapper = ""; //nose que poner acà
        /* quien valida los datos? */
        return $answer = $this->queryList($sql, $args, $mapper);
    }

}
