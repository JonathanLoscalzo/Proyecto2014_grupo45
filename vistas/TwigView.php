<?php

include_once("vendor/autoload.php");
include_once("controller/LoginController.php");

abstract class TwigView {

    private static $twig;

    public static function getTwig() {

        if (!isset(self::$twig)) {

            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem(array('templates/', 'templates/frontend', 'templates/backend'));
            self::$twig = new Twig_Environment($loader);
            LoginController::getInstance()->startSession();
             self::$twig->addGlobal('session', $_SESSION); // nose si està bien esto
             
             $cant = count(split("/", $_SERVER['REQUEST_URI'])) - 2 ;
             $var = str_repeat("../", $cant);
             self::$twig->addGlobal('server', $var );
        }
        return self::$twig;
    }

}
