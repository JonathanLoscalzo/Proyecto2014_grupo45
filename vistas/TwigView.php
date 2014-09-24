<?php

include_once("vendor/autoload.php");

abstract class TwigView {

    private static $twig;

    public static function getTwig() {

        if (!isset(self::$twig)) {

            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem(array('templates/', 'templates/frontend', 'templates/backend'));
            self::$twig = new Twig_Environment($loader);
            session_start();
            self::$twig->addGlobal('session', $_SESSION); // nose si està bien esto
        }
        return self::$twig;
    }

}
