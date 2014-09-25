<?php

include_once('vistas/TwigView.php');

class BackEndView extends TwigView {

    public function index($message = "") {
        $twig = self::getTwig();
        $twig->addGlobal('session', $_SESSION); // nose si està bien esto
        echo self::getTwig()->render('index-backend.php', array('message' => $message));
    }

    public function listado_alimentos() {
        echo self::getTwig()->render('ListadoAlimentos.php');
    }

    public function entidadesReceptoras() {
        echo self::getTwig()->render('EntidadesReceptoras.php');
    }

    public function alimentos() {
        echo self::getTwig()->render('Alimentos.php');
    }

    public function donantes($donantes) {
        echo self::getTwig()->render('Donantes.php', array('donantes', $donantes));
    }

    public function editViewDonante($donante) {

        echo self::getTwig()->render('EditViewDonante.html.twig', array('donante' => $donante)); //ver si esto anda
    }
    
    public function editViewEntidadReceptora($entidad) {

        echo self::getTwig()->render('EditViewEntidadReceptora.html.twig', array('entidad' => $entidad)); //ver si esto anda
    }
    
    public function editViewAlimento($alimento) {

        echo self::getTwig()->render('EditViewAlimento.html.twig', array('alimento' => $alimento)); //ver si esto anda
    }

}
