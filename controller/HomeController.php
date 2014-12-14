<?php

include_once("Controller.php");
include_once("repository/DonanteRepository.php");
include_once("model/DonanteModel.php");
include_once("model/OAuthModel.php");
include_once("repository/ConfiguracionRepository.php");

class HomeController extends Controller {

    private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct() {
        
    }
    private function getDataLinkedin($credentials) {
        $oauth = new OAuth($credentials->getApi_key(), $credentials->getApi_secret());
        $oauth->setToken($credentials->getToken_id(), $credentials->getToken_secret());

        $params = array();
        $headers = array();
        $method = OAUTH_HTTP_METHOD_GET;

        // Specify LinkedIn API endpoint to retrieve your own profile
        $url = "https://api.linkedin.com/v1/people/~:(id,first-name,last-name,location:(name),summary,email-address,honors-awards)?format=json";

        // By default, the LinkedIn API responses are in XML format. If you prefer JSON, simply specify the format in your call
        // $url = "https://api.linkedin.com/v1/people/~?format=json";

        // Make call to LinkedIn to retrieve your own profile
        $oauth->fetch($url, $params, $method, $headers);

        return json_decode($oauth->getLastResponse());
    }
    public function index() {
        $view = new FrontEndView();
        $view->index();
    }

    public function login() {
        $view = new FrontEndView();
        $view->login();
    }

    public function proyectos() {
        $view = new FrontEndView();
        $view->proyectos();
    }

    public function voluntariado() {
        $view = new FrontEndView();
        $view->voluntariado();
    }

    public function dona_ahora() {
        $view = new FrontEndView();
        $view->dona_ahora();
    }

    public function listDonante() {
        $lista_donantes = DonanteRepository::getInstance()->getAll();
        $view = new FrontEndView();
        $view->listar_donantes($lista_donantes);
    }
    
    public function listadoEntidadesReceptoras() {
        $entidades = EntidadReceptoraRepository::getInstance()->getAll();
        $view = new FrontEndView();
        $view->listar_entidadesreceptoras($entidades);
    }
    public function acerca_de() {
        // LOGIN LINKEDIN and retrive data
        $view = new FrontEndView();
        $credentials = ConfiguracionRepository::getInstance()->getAllOauth();
        if ($credentials) {
            $linkedin_data = $this->getDataLinkedin($credentials);
        }
        else {
            $linkedin_data = "No esta configurado el enlace";
        }
        
        $view->acerca_de($linkedin_data);
    }
    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

}
