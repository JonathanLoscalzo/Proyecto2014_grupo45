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

    protected function redirect() {
        parent::redirect("EntregaDirecta");
    }

    public function create($entidad) {
        print_r($entidad);
        return $entidad;
        
        /*
         * se recibe un json. con el siguiente formato:
         *  [entidad => nro, detalle_alimento_id => [nro, nro,...], cantidad => [nro, nro,...]]
         * Cada detalle es con cada cantidad. 
         * se deberia hacer comprobacion de tipos
         * ahora, lo que se deberia devolver es un pedazo de vista, es decir no recargar toda la pagina sino el contenido
         * COMO SE HACE ESTO ni idea. 
         * renderizar con ajax. SI hubo un problema, se deberia cargar (nose si usar los mismos errores). 
         * sino recargar la pagina completa siempre. EN VEZ de mandar a recargar un twig, que recargue una pagina y listo
         * 
         */
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

    public function index() {
        $entidades = EntidadReceptoraRepository::getInstance()->getAll();
        $detalles = DetalleRepository::getInstance()->getAll();
        $entregas = EntregaDirectaRepository::getInstance()->getAll();
        foreach ($entregas as $elem) {
            $elem->cambiar();
            foreach ($elem->getAlimentos() as $alimentos) {
                $alimentos->cambiar();
            }
        }
        $view = new BackEndView();
        $view->entregaDirecta($entregas, $entidades, $detalles);
    }

}
