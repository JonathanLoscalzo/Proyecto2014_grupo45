<?php    
include_once('Controller.php');
include_once("repository/PDOrepository.php");
include_once("controller/RoleService.php");
include_once("repository/PedidoRepository.php");
include_once("model/EstadoPedidoModel.php");
include_once("repository/BancoRepository.php");

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
        $date = $id->getParams()['date']; // la fecha en la cual se deben procesar los envios
        $banco = BancoRepository::getInstance()->getAll()[0];
        $format_date = date("Y-m-d", strtotime($date) );
        $pedidos = PedidoRepository::getInstance()->getPedidosByDateSinEnviar($format_date);
        $data['banco'] = $banco;
        $data['pedidos'] = $pedidos;
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