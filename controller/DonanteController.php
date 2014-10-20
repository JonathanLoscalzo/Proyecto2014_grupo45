<?php

include_once('Controller.php');
include_once("model/DonanteModel.php");
include_once("model/DonanteRepository.php");
include_once("model/PDOrepository.php");
include_once("controller/RoleService.php");

class DonanteController extends Controller {

    private static $instance = null;

    protected function redirect() {
        parent::redirect("donantes");
    }

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function create($post) {
        /* $donante sin id de donante */
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $data = $post->getParams();
                $donantes = DonanteRepository::getInstance()->getByRazonSocial($data['razonSocial']);
                if (!$donantes) {
                    DonanteRepository::getInstance()->add(new DonanteModel(null, $data['razonSocial'], $data['apellido'], $data['nombre'], $data['telefono'], $data['email'], $data['domicilio']));
                    $_SESSION["message"] = new MessageService("createSuccess", ["donante con razón social " . $data['razonSocial']]);
                } else {
                    $_SESSION["message"] = new MessageService("createErrorExist", ["donante con razón social " . $data['razonSocial']]);
                }
                $this->redirect();
            }
        }
    }

    public function edit($post) {
        /* CUANDO SE LLEGA ACÀ SEGURO QUE SE TIENE UN ID CORRECTO? */
        $data = $post->getParams();
        if (parent::backendIsLogged() && RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
            if (DonanteRepository::getInstance()->getByID($data['id'])) {
                $donanteModificadoID = $data['id'];
                $donanteActual = DonanteRepository::getInstance()->getByRazonSocial($data['razonSocial']);
                if (!$donanteActual) {
                    $donante = new DonanteModel($data['id'], $data['razonSocial'], $data['apellido'], $data['nombre'], $data['telefono'], $data['email'], $data['domicilio']);
                    DonanteRepository::getInstance()->edit($donante);
                    $_SESSION["message"] = new MessageService("modificationSuccess", ["donante con razón social " . $data['razonSocial']]);
                } elseif ($donanteActual->getId() === $donanteModificadoID) {
                    $donante = new DonanteModel($data['id'], $data['razonSocial'], $data['apellido'], $data['nombre'], $data['telefono'], $data['email'], $data['domicilio']);
                    DonanteRepository::getInstance()->edit($donante);
                    $_SESSION["message"] = new MessageService("modificationSuccess", ["donante con razón social " . $data['razonSocial']]);
                } else {
                    $_SESSION["message"] = new MessageService("modificationErrorExist", ["donante", "razon social (" . $data['razonSocial'] . ")"]);
                }
            } else {
                $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["donante", "razon social (" . $data['razonSocial'] . ")"]);
            }
            $this->redirect();
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged() && RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
            $donanteInfo = DonanteRepository::getInstance()->getByID($id);
            if ($donanteInfo) {
                $view = new BackEndView();
                $view->editViewDonante($donanteInfo);
            } else {
                $_SESSION["message"] = new MessageService("modificationErrorNotExist", ["donante"]);
                $this->redirect();
            }
        }
    }

    public function remove($id) {
        /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged() && RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
            $donanteInfo = DonanteRepository::getInstance()->getByID($id);
            if ($donanteInfo) {
                DonanteRepository::getInstance()->remove($id);
                $_SESSION["message"] = new MessageService("removeSucess", ["donante"]);
            } else {
                $_SESSION["message"] = new MessageService("removeErrorNotExist", ["donante"]);
            }
            $this->redirect();
        }
    }

    public function index() {
        /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */

        if (parent::backendIsLogged() && RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
            $donantes = DonanteRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->donantes($donantes);
        }
    }
    
    public function listDonante() {
        $lista_donantes = DonanteRepository::getInstance()->getAll();
        $view = new FrontEndView();
        $view->listar_donantes($donantes);
    }

}
