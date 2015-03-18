<?php
require 'vendor/autoload.php';
define('DOMPDF_ENABLE_AUTOLOAD', false);
include 'vendor/dompdf/dompdf/dompdf_config.inc.php';

class EstadisticasController extends BaseController {

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

        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        return Response::json(AlimentosVencidos::alimento_entre_fechas($from->format('Y-m-d'), $to->format('Y-m-d')));
    }

    public function dos($from, $to) {
        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        return Response::json(AlimentosVencidos::alimento_entre_fechas_por_entidad($from->format('Y-m-d'), $to->format('Y-m-d')));
    }

    public function tres() {
        return Response::json(AlimentosVencidos::alimentos_vencidos_agrupados_descripcion());
    }

    public function alertas() {
        if (parent::backendIsLogged()) {
            if (RoleService::getInstance()->hasRolePermission($_SESSION["roleID"], __CLASS__ . ":" . __FUNCTION__)) {
                $view = new BackEndView();
                $pedidos = PedidoRepository::getInstance()->getPedidosByDate(Date('Y-m-d'));
                $detalles = DetalleRepository::getInstance()->getAllVencimientoCercano();
                $view->alertas($pedidos, $detalles);
            }
        }
    }

    public function index() {
        /*$view = new BackEndView();
        $view->estadisticas();*/
        return  View::make('EstadisticasController.Estadisticas');
    }

    public function exportarPDF($html) {

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("sample.pdf");

        $output = $dompdf->output();
        file_put_contents('images/file.pdf', $output);
    }

    public function exportarPDF2($html) {
        $prints = '<html>
<head>
    <title>Banco Alimentario</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
    <style>
    .contenedor {
        width:85%;
        margin-left:10px;
        margin-right:10px;
    }
    table {
        border:1px solid black;
        width:80%;
        padding:2%;
        margin:2%;
        max-width:50%    
    }
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
    }

    </style>
    <div class="contenedor">
        ' . $html . '
    </div>
    </body>
</html>';
        $mipdf = new DOMPDF();
        $mipdf->set_paper("a4", "portrait");
        $mipdf->load_html(utf8_decode($prints));
        $mipdf->render();
        $mipdf->stream('file.pdf');
    }

}
