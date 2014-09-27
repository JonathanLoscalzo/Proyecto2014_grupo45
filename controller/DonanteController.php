<?php

include_once('Controller.php');
//include_once('CREInteface.php');
include_once("model/DonanteModel.php");
include_once("model/DonanteRepository.php");
include_once("model/PDOrepository.php");
/* EN ALGUN LADO DEBERIA CONTROLAR QUE ESTÀ LA SESION INICIADA" */

class DonanteController extends Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function create($post) {
        /* $donante sin id de donante */
        if (parent::backendIsLogged()) {
            $data = $post->getParams();
            if (count(DonanteRepository::getInstance()->getByRazonSocial($data['razonSocial'])) > 0) {
                    DonanteRepository::getInstance()->add(new DonanteModel(null,
                    $data['razonSocial'], $data['apellido'],
                    $data['nombre'], $data['telefono'], $data['email'],
                    $data['domicilio']));
            }
            else {
                return false;
            }
        }
    }

    public function edit($post) {
        if (parent::backendIsLogged()) {
            $data = $post->getParams();
            $dbdata = DonanteRepository::getInstance()->getByRazonSocial($data['razonSocial']);
            if ((count($dbdata) > 0) && ($dbdata['id'] === $data['id'])) {
               
                 DonanteRepository::getInstance()->edit($data['id'],
                        $data['razonSocial'], $data['apellido'],
                        $data['nombre'], $data['telefono'], $data['email'],
                        $data['domicilio']);
                }
            else if (count($dbdata) === 0){
                DonanteRepository::getInstance()->edit($data['id'],
                        $data['razonSocial'], $data['apellido'],
                        $data['nombre'], $data['telefono'], $data['email'],
                        $data['domicilio']);
            }
        }
    }

    public function editView($id) {

        if (parent::backendIsLogged()) {
            $donanteInfo = DonanteRepository::getInstance()->getByID($id);
            $view = new BackEndView();
            $view->editViewDonante($donanteInfo); // si no devuelve nada esta vista se encarga
        }
    }

    public function remove($id) {
        /* onupdate y onremove estan en Restrict o en cascade? 
          Preguntar que hacer!
         */
        if (parent::backendIsLogged()) {
            DonanteRepository::getInstance()->remove($id);
            LoginController::getInstance()->index(""); /* mensaje de todo ok */
        }
    }

    public function index() {
        /* comproba si hay una sesion valida
          ese metodo deberia enviarte al inicio directamente.
         */
        if (parent::backendIsLogged()) {
            $donantes = DonanteRepository::getInstance()->getAll();
            $view = new BackEndView();
            $view->donantes($donantes);
        }
    }

}
