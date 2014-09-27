<?php

include_once("model/EntidadReceptoraRepository.php"); //altos problemas con esta
include_once("model/EntidadReceptoraModel.php");

/**
 * Description of EntidadReceptoraController
 *  HABRIA QUE TENER EN CUENTA QUE ENTIDAD TIENE VARIAS VARIABLES CONECTADAS
 *  COMO SE RELACIONARIAN?
 * @author jloscalzo
 */
class EntidadReceptoraController extends Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function create($post) {
        /* $EntidadReceptora sin id de EntidadReceptora */
        if (parent::backendIsLogged()) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new EntidadReceptoraModel(
                    $data["id"], $data["razon_social"], $data["apellido"], $data["nombre"], $data["telefono"], $data["email"], $data["domicilio"], $data['estado_entidad_id'], $data['necesidad_entidad_id'], $data["servicio_perstado_id"]);
            EntidadReceptoraRepository::getInstance()->add($entidad);
        }
    }

    public function edit($post) {
        if (parent::backendIsLogged()) {
            $data = $post->getParams(); // obtenemos Los parametros
            $entidad = new EntidadReceptoraModel(
                    $data["id"], $data["razonSocial"], $data["telefono"], $data["domicilio"], $data["estadoEntidadID"], $data["necesidadEntidadID"], $data["servicioPrestadoID"]);
            /* $arr = array('Hello','World!','Beautiful','Day!'); echo implode(" ",$arr); => pasa todos los parametros a un string separado por espacios
             * 
             * 
             */
            var_dump(EntidadReceptoraRepository::getInstance()->edit($entidad));die;
            /* USAR GLOBALS PARA LOS MENSAJES */
            $this->index();
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged()) {
            $entidadInfo = EntidadReceptoraRepository::getInstance()->getByID($id);
            $Necesidades = NecesidadEntidadRepository::getInstance()->getAll();
            $Servicios = ServicioEntidadRepository::getInstance()->getAll();
            $Estados = EstadoEntidadRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->editViewEntidadReceptora($entidadInfo, $Estados, $Necesidades, $Servicios); // si no devuelve nada esta vista se encarga
        }
    }

    public function remove($id) {
        /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            EntidadReceptoraRepository::getInstance()->remove($id);
            LoginController::getInstance()->index();
        }
    }

    public function index() {
        /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */

        if (parent::backendIsLogged()) {
            $EntidadesReceptoras = EntidadReceptoraRepository::getInstance()->getAll();
            $Necesidades = NecesidadEntidadRepository::getInstance()->getAll();
            $Servicios = ServicioEntidadRepository::getInstance()->getAll();
            $Estados = EstadoEntidadRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->EntidadesReceptoras($EntidadesReceptoras, $Estados, $Necesidades, $Servicios);
        }
    }

}
