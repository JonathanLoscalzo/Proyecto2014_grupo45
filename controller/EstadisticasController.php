<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstadisticasController extends Controller {

    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

    /* una por cada enunciado */

    public function uno($from, $to) {

        $from = DateTime::createFromFormat('d/m/Y',$from );
        $to = DateTime::createFromFormat('d/m/Y',$to );

        echo json_encode([[$from->format("Y-m-d"), 10], [$to->format('Y-m-d'), 20]]);
    }

    public function dos($from, $to) {
        echo $from . " " . $to;
    }

    public function tres() {
        
    }

    public function index() {
        $view = new BackEndView();
        $view->estadisticas();
    }

}
