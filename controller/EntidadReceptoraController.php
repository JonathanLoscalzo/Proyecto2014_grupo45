<?php

/*
 * 
 */

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

    public function create($entidad) {
        /* $EntidadReceptora sin id de EntidadReceptora */
        if (parent::backendIsLogged()) {
            EntidadReceptoraRepository::getInstance()->add($entidad);
        }
    }

    public function edit($entidad) {
        if (parent::backendIsLogged()) {
            EntidadReceptoraRepository::getInstance()->edit($entidad);
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged()) {
            $entidadInfo = EntidadReceptoraRepository::getInstance()->getByID($id);
            $view = new BackEndView();
            $view->editViewEntidadReceptora($entidadInfo); // si no devuelve nada esta vista se encarga
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
            $view = new BackEndView();
            $view->EntidadesReceptoras($EntidadesReceptoras);
        }
    }

}
