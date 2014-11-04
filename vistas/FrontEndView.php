<?php

/* esto es la logica de la vista */
require_once('vistas/TwigView.php');

class FrontEndView extends TwigView {

    public function index() {
        $twig = self::getTwig();
        echo $twig->render('index.php');
    }

    public function login() {
        echo self::getTwig()->render('login.php');
    }

    public function proyectos() {
        echo self::getTwig()->render('Proyectos.php');
    }

    public function voluntariado() {
        echo self::getTwig()->render('Voluntariado.php');
    }

    public function dona_ahora() {
        echo self::getTwig()->render('Dona-ahora.php');
    }

    public function listar_donantes($donantes) {
        echo self::getTwig()->render('lista_donantes.php', array('donantes' => $donantes));
    }

    public function listar_entidadesreceptoras($entidades) {
        echo self::getTwig()->render('listado_entidadesreceptoras.html.twig', array('entidades' => $entidades));
    }

}
