<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntregaDirectaController
 *
 * @author loscalzo
 */
class EntregaDirectaController extends Controller {

    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }
    public function index() {
        $view = new BackEndView;
        $view->entregaDirecta();
    }

}
