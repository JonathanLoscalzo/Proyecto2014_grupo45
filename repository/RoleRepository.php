<?php
/**
 * Description of RoleRepository
 *
 * @author loscalzo
 */
class RoleRepository extends PDORepository{
    /*solo se puede leer roles*/
    
    private static $instance = null;
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    public function add($obj) {
        
    }

    public function edit($obj) {
        
    }

    public function exist($id) {
        
    }

    public function getAll() {
        $sql = "select * from role";
        $args = [];
        $mapper = function($row){
            return new RoleModel($row['roleID'], $row['roleuser'], $row['description']);
        };
        return $this->queryList($sql, $args, $mapper);
    }

    public function getByID($id) {
        
    }

    public function remove($id) {
        
    }

//put your code here
}
