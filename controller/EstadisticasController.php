<?php

include_once 'repository/EstadisticasRepository.php';
require 'vendor/autoload.php';
define('DOMPDF_ENABLE_AUTOLOAD', false);
include 'vendor/dompdf/dompdf/dompdf_config.inc.php';
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

        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        $array = EstadisticasRepository::getInstance()->alimento_entre_fechas($from->format('Y-m-d'), $to->format('Y-m-d'));
        echo json_encode($array);
    }

    public function dos($from, $to) {
        $from = DateTime::createFromFormat('d/m/Y', $from);
        $to = DateTime::createFromFormat('d/m/Y', $to);

        $array = EstadisticasRepository::getInstance()->alimento_entre_fechas_por_entidad($from->format('Y-m-d'), $to->format('Y-m-d'));
        echo json_encode($array);
    }

    public function tres() {
        $data = EstadisticasRepository::getInstance()->alimentos_vencidos_agrupados_descripcion();
        echo json_encode($data);
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
        $view = new BackEndView();
        $view->estadisticas();
    }

    public function exportarPDF($html) {

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("sample.pdf");

        $output = $dompdf->output();
        file_put_contents('images/file.pdf', $output);
    }

    function exportarPDF2($html) {
        $prints = '<html>
<head>
    <title>Banco Alimentario</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
table {
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#eaebec;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
table th {
	padding:21px 25px 22px 25px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
table th:first-child {
	text-align: left;
	padding-left:20px;
}
table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
table tr {
	text-align: center;
	padding-left:20px;
}
table td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
table td {
	padding:18px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
table tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
table tr:last-child td {
	border-bottom:0;
}
table tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
table tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
table tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}
        </style>
    </head>
    <body>

        ' . $html . '

    </body>
</html>';
        $mipdf = new DOMPDF();
        $mipdf->set_paper("legal", "portrait");
        $mipdf->load_html(utf8_decode($prints));
        $mipdf->render();
        $mipdf->stream('file.pdf');
    }

}
