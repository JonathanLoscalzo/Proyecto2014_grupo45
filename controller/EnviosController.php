<?php    
include_once('Controller.php');
include_once("model/PDOrepository.php");
include_once("controller/RoleService.php");

class EnviosController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("envios");
    }
    public function edit($id) {
        
    }
    public function create($entidad) {
        
    }
    public function remove($id) {}
    public function editView($id) {
        $date = $id; // la fecha en la cual se deben procesar los envios
        $data['ejemplo'] = 'Estos son datos de ejemplo';
        echo json_encode($data);
        die();
    } 
    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    public function index() {
        if (parent::backendIsLogged()) {
               if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                        $view = new BackEndView();
                        $view->Envios();
                    }
                }
        }
}
?>