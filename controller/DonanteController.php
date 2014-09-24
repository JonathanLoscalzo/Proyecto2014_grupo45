<?php
include_once('Controller.php');
include_once('CREInteface.php');
include_once("model/DonanteModel.php");
include_once("model/DonanteRepository.php");
include_once("model/PDOrepository.php");
/* EN ALGUN LADO DEBERIA CONTROLAR QUE ESTÀ LA SESION INICIADA"*/

class DonanteController extends Controller implements CREInterface
{
	private static $instance = null;

    public static function getInstance() {

        if (is_null(self::$instance)){
            self::$instance = new static();
        }        

        return self::$instance;
    }
    
    protected function __construct() {
        
    }

    public function create()
    {

    }

	public function edit(id)
    {

    }

    public function remove(id)
    {

    }    


    public function index()
    {
    	/*comproba si hay una sesion valida*/
    	$donantes = DonanteRepository::getInstance()->getDonantes();
    	$view= new BackEndView();
    	$view->donantes($donantes);
    }

}