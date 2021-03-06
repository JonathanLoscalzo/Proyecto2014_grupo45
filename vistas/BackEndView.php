<?php

/* Ver conceptos de metaprogramacion:
  EVITAR CODIGO REDUNDANTE. Convention over configuration.
 * USAR LOS MISMOS NOMBRES Y hago solo una funcion. Le mando el parametro que quiero.
 * parametros variables. 
 * Alto refactoring
 *  */
include_once('vistas/TwigView.php');

class BackEndView extends TwigView {

    public function index() {
        //$twig = self::getTwig();
        echo self::getTwig()->render('index-backend.php');
    }

    public function alertas($pedidos, $detalles) {
        echo self::getTwig()->render('Alertas.html.twig', ["pedidos"=>$pedidos, "detalles"=>$detalles]);
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

    public function entregaDirecta($entregas, $entidades, $detalles) {
        echo self::getTwig()->render('EntregaDirecta.html.twig', ['entregas' => $entregas, 'entidades' => $entidades, 'detalles' => $detalles]);
    }

    public function donantes($donantes) {
        echo self::getTwig()->render('Donantes.php', array('donantes' => $donantes));
    }

    public function turnos($turnos) {
        echo self::getTwig()->render('turnosEntrega.html.twig', array('turnos' => $turnos));
    }

    public function estadisticas() {
        echo self::getTwig()->render('Estadisticas.html.twig');
    }

    public function editViewTurno($turno) {
        echo self::getTwig()->render('EditViewTurnoEntrega.html.twig', array('turno' => $turno)); //ver si esto anda
    }

    public function usuarios($usuarios, $roles) {
        echo self::getTwig()->render('usuarios.twig', array('usuarios' => $usuarios, 'roles' => $roles));
    }

    public function editViewUsuarios($us, $roles) {
        echo self::getTwig()->render('EditViewUsuarios.html.twig', array('usuario' => $us, 'roles' => $roles)); //ver si esto anda
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

    public function editViewAlimento($alimento, $detalle) {
        echo self::getTwig()->render('EditViewAlimento.html.twig', array(
            'alimento' => $alimento,
            'detalle' => $detalle
        ));
    }

    public function Envios() {
        echo self::getTwig()->render('Envios.php');
    }
    
    public function Weather($entidades) {
        echo self::getTwig()->render('weather.twig', array(
            'stations' => $entidades
        ));
    }

    public function Pedidos($entidades, $turnos) {
        echo self::getTwig()->render("ConfeccionPedidos.html.twig", array(
            'entidades' => $entidades,
            'turnos' => $turnos
        ));
    }
    public function configuracion($banco, $configuracion, $oauth) {
        echo self::getTwig()->render("configuracion.html.twig", array(
            'banco' => $banco,
            'configuracion' => $configuracion,
            'oauth' => $oauth
        ));
    }

}
