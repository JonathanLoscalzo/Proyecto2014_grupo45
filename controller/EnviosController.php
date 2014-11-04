<?php    
include_once('Controller.php');
include_once("repository/PDOrepository.php");
include_once("controller/RoleService.php");
include_once("repository/PedidoRepository.php");
include_once("model/EstadoPedidoModel.php");

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
        $banco['lat'] = -34.930500;
        $banco['long'] = -57.952400;
        $format_date = date("Y-m-d", strtotime($date) );
        $entidad_receptora['id'] = 1;
        if ($format_date > "2014-10-10") {
            $entidad_receptora['razonSocial'] = "Carlitos Tevez";
        }
        else 
        {
            $entidad_receptora['razonSocial'] = "Carlos Sanchez";
        }
        $entidad_receptora['telefono'] = "4225252";
        $entidad_receptora['domicilio'] = "60 1821, La Plata";
        $entidad_receptora['lat'] = -34.930596;
        $entidad_receptora['long'] = -57.952437;
        $pedido['id'] = 2;
        $pedido['entidad_receptora_id'] = 1;
        $pedido['fecha_ingreso'] = "22-05-2014";
        $pedido['estado'] = "En Espera";
        $turno['date'] = "24-05-2014";
        $turno['time'] = 20;
        $detalle['id'] = 3;
        $detalle['cantidad'] = 10;
        $detalle['alimento_codigo'] = "Almendras";
        
        $data['entidad_receptora'] = $entidad_receptora;
        $data['pedido'] =   $pedido;
        $data['turno'] =   $turno;
        $data['detalle'] =  $detalle;
        $data['banco'] = $banco;
        

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