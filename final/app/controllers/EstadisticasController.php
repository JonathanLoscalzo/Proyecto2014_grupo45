<?php
class EstadisticasController extends BaseController {
    /* una por cada enunciado */

    public function uno() {
        $rules=array(
            'from'    => 'required|date_format:"d/m/Y"',
            'to' => 'required|date_format:"d/m/Y"|after:from', // Nose si hay que poner Input::get(from)
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()){
            return Response::json(array(
                'error' => array( $validator->messages()->all() ),
                'code' => 401), 401);
        }
        else{
            $from = DateTime::createFromFormat('d/m/Y', Input::get('from'));
            $to = DateTime::createFromFormat('d/m/Y', Input::get('to'));
            return Response::json(AlimentosVencidos::alimento_entre_fechas($from->format('Y-m-d'), $to->format('Y-m-d')));
        }
        
    }

    public function dos() {
        $rules=array(
            'from'    => 'required|date_format:"d/m/Y"',
            'to' => 'required|date_format:"d/m/Y"|after:from', // Nose si hay que poner Input::get(from)
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()){
            return Response::json(array(
                'error' => array( $validator->messages()->all() ),
                'code' => 401), 401);
        }
        else{
            $from = DateTime::createFromFormat('d/m/Y', Input::get('from'));
            $to = DateTime::createFromFormat('d/m/Y', Input::get('from'));
            return Response::json(AlimentosVencidos::alimentos_por_entidad_entre_fechas($from->format('Y-m-d'), $to->format('Y-m-d')));
        }
    }

    public function tres() {
        return Response::json(AlimentosVencidos::alimentos_vencidos_agrupados_descripcion());
    }

    /*public function alertas() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $view = new BackEndView();
                $pedidos = PedidoRepository::getInstance()->getPedidosByDate(Date('Y-m-d'));
                $detalles = DetalleRepository::getInstance()->getAllVencimientoCercano();
                $view->alertas($pedidos, $detalles);
            }
        }
    }*/

    public function index() {
        return  View::make('EstadisticasController.Estadisticas');
    }

    public function exportarPDF() {
        $html = Input::get('html');
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("sample.pdf");

        $output = $dompdf->output();
        file_put_contents('images/file.pdf', $output);
    }

    public function exportarPDF2() {
        
        $parameter['html'] = Input::get('html');
        
        $pdf = PDF::loadView('EstadisticasController.PdfView', $parameter);
        return $pdf->stream("file.pdf");
    }

    public function create($entidad) {
        
    }

    public function edit($entidad) {
        
    }

    public function editView($id) {
        
    }

    public function remove($id) {
        
    }

}
