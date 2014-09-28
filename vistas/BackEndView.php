<?php

include_once('vistas/TwigView.php');

class BackEndView extends TwigView {

    public function index($message = "") {
        //$twig = self::getTwig();
        echo self::getTwig()->render('index-backend.php', array('message' => $message));
    }

    public function listado_alimentos($lista) {
        echo self::getTwig()->render('ListadoAlimentos.php', array('detalles' => $lista));
    }

    public function entidadesReceptoras($entidades, $estados, $necesidades, $servicios) {
        echo self::getTwig()->render('EntidadesReceptoras.php', array(
            'entidades' => $entidades,
            'estados' => $estados,
            'necesidades' => $necesidades,
            'servicios' => $servicios
        ));
    }

    public function alimentos($alimentos, $detalles) {
        echo self::getTwig()->render('Alimentos.php', array(
            'alimentos' => $alimentos,
            'detalles' => $detalles  
                ));
    }

    public function donantes($donantes) {
        echo self::getTwig()->render('Donantes.php', array('donantes' => $donantes));
    }

    public function editViewDonante($donante) {

        echo self::getTwig()->render('EditViewDonante.html.twig', ['donante' => $donante]); //ver si esto anda
    }

    public function editViewEntidadReceptora($entidad, $estados, $necesidades, $servicios) {

        echo self::getTwig()->render('EditViewEntidadReceptora.html.twig', ['entidad' => $entidad,
            'estados' => $estados,
            'necesidades' => $necesidades,
            'servicios' => $servicios]); //ver si esto anda
    }

    public function editViewAlimento($alimento) {

        echo self::getTwig()->render('EditViewAlimento.html.twig', array('alimento' => $alimento)); //ver si esto anda
    }

}
