@extends('layouts.backend_layout')
@section('head')
{{ HTML::style('css/bootstrap/css/bootstrap.min.css') }}
{{ HTML::style('js/plugins/jquery-ui/jquery-ui.min.css') }}
{{ HTML::style('css/dataTables.bootstrap.css') }}
@parent
{{ HTML::script('js/plugins/jquery-2.1.2.js') }}
{{ HTML::script('js/plugins/jquery-ui/jquery-ui.min.js') }}
{{ HTML::script('js/plugins/jquery.dataTables-1.10.2.min.js') }}
{{ HTML::script('css/bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('js/plugins/notifier.js') }}

@stop

@section('content')
<div id = "content" class="container-fluid">
    <div class="row">
        <h3 class=" h3 col-md-12">Listado (entre fechas) de los kilos de pedidos que fueron entregados (gráfico de barra)</h3>
        <div class="col-md-6">
            {{ Form::open(array('class' => 'form-inline', 'id' => 'form-1', 'role' => 'form'))}}
            {{ Form::label('from1', 'Desde') }}
            {{ Form::text('from', '', array('id' => 'from1')) }}
            {{ Form::label('to1', 'Hasta') }}
            {{ Form::text('to', '', array('id' => 'to1')) }}
            {{ Form::submit('Consultar', array('id' => 'button-1')) }}
            {{ Form::close() }}

            <div id="container-1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 3% auto"></div>
        </div>
        <div class="col-md-6">
            {{ Form::open(array('id'=>"exportar-1", 'action'=>'EstadisticasController@exportarPDF2', 'method'=>'post', 'data-type' => 'Listado (entre fechas) de los kilos de pedidos que fueron entregados (gráfico de barra)')) }}
            {{ Form::submit('Exportar PDF', array('style'=>'margin-top:1%; margin-bottom: 1%')) }}
            {{ Form::textarea('html','', array('hidden'=>'')) }}
            {{ Form::close() }}
            
            <table id = "t1" class = "tabla-class table table-striped" style="margin-top:1%; margin-bottom: 1%">
                <thead>
                    <tr>
                        <th> Fecha </th>
                        <th> KG </th>
                    </tr>
                </thead>
                <tbody id="tabla-1"style="text-align: center" ></tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <h3 class="h3">Listado (entre fechas) de cada E.R y los kilos de alimento que le fueron entregados (gráfico de torta)</h3>
        <div class="col-md-6">
            {{ Form::open(array('class' => 'form-inline', 'id' => 'form-2', 'role' => 'form'))}}
            {{ Form::label('from', 'Desde') }}
            {{ Form::text('from', '', array('id' => 'from')) }}
            {{ Form::label('to', 'Hasta') }}
            {{ Form::text('to', '', array('id' => 'to')) }}
            {{ Form::submit('Consultar', array('id' => 'button-2')) }}
            {{ Form::close() }}
            <div id="container-2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 3% auto"></div>
        </div>
        <div class="col-md-6">
            
            {{ Form::open(array('id'=>'exportar-2', 'action'=>'EstadisticasController@exportarPDF2', 'method'=>'post', 'data-type'=>'Listado (entre fechas) de cada E.R y los kilos de alimento que le fueron entregados (grafico de torta)')) }}
            {{ Form::submit('Exportar PDF', array('id'=>'exportar-2', 'style'=>'margin-top:1%; margin-bottom: 1%')) }}
            {{ Form::textarea('html', '', array('hidden'=>'')) }}
            {{ Form::close() }}
            
            <table  id="t2" class=" tabla-class table table-striped" style="margin-top:1%; margin-bottom: 1%">
                <thead>
                    <tr>
                        <th>Entidad</th>
                        <th>kg</th>
                    </tr>
                </thead>
                <tbody id="tabla-2" style="text-align: center"></tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <h3 class="h3">Alimentos vencidos sin entregar (agrupados por descripción)</h3>

            {{ Form::open(['id'=>'form-3']) }}
            <div><button id="refresh" type="submit" class = "col-md-4">Actualizar</button></div>
            {{ Form::close() }}

            {{ Form::open(array('id'=>'exportar-3', 'action'=>'EstadisticasController@exportarPDF2', 'method'=>'post', 'data-type'=>'Alimentos vencidos sin entregar (agrupados por descripción)')) }}
            {{ Form::textarea('html', '', array('hidden'=>'')) }}
            {{ Form::submit('Exportar PDF', ['class' => 'col-md-4' ])}}
            {{ Form::close() }}
        <div style="padding:1.3%;margin:1%"></div>
        <table id = "t3" class = "tabla-class table-striped" style="
               margin-top:1%;
               margin-bottom: 1%;
               margin-left:10%;
               max-width: 80%;
               min-width: 50%
               ">
            <thead>
                <tr>
                    <th> Descripción </th>
                    <th> Cantidad </th>
                </tr>
            </thead>
            <tbody id="tabla-3" style="text-align: center"></tbody>
        </table>
    </div>
</div>
@stop

@section('scripts')
{{ Html::script('js/plugins/Highcharts-4.0.4/js/highcharts.js') }}
{{ Html::script('js/plugins/Highcharts-4.0.4/js/highcharts-3d.js') }}
{{ Html::script('js/plugins/Highcharts-4.0.4/js/modules/exporting.js') }}
<script>
$(document).ready(function () {
    var $j = jQuery.noConflict();
    $("#from").datepicker({
        defaultDate: "+1w",
        onClose: function (selectedDate) {
            $("#to").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#from1").datepicker({
        defaultDate: "+1w",
        onClose: function (selectedDate) {
            $("#to1").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#to").datepicker({
        defaultDate: "+1w",
        onClose: function (selectedDate) {
            $("#from").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#to1").datepicker({
        defaultDate: "+1w",
        onClose: function (selectedDate) {
            $("#from1").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#from, #from1, #to, #to1").datepicker("option", "dateFormat", 'dd/mm/yy');
//=========================================================================================

    function parseToUTC(aDateString) {
        var el = aDateString.split('-');
        return Date.UTC(parseInt(el[0]), parseInt(el[1]) - 1, parseInt(el[2]));
    }



    $("#form-2").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: location.href + '/dos',
            dataType: 'json',
            data: $("#form-2").serialize(),
            success: function (aData) {
                aData = aData.map(function(e){return [e.razon_social, e.kilogramos]});
                console.log(aData);
                debugger;
                $("#t2").DataTable().destroy();

                $("#t2").dataTable({
                    data: aData,
                    "info": false
                });
                $.map(aData, function (elem) {
                    elem[1] = parseInt(elem[1]);
                });
                $("#container-2").highcharts().series[0].update({data: aData});
            },
            error: function(data){
                Notifier.error(data.responseJSON.error.join('<br>'));
            }
        });
    });
    $("#form-1").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: location.href + '/uno',
            dataType: "json",
            data: $("#form-1").serialize(),
            success: function (aData) {
                aData = aData.map(function(e){return [e.fecha, e.kilogramos]});
                console.log(aData);
                debugger;
                $("#t1").DataTable().destroy();

                $("#t1").dataTable({
                    data: aData,
                    "info": false
                });

                $.map(aData, function (elem) {

                    elem[0] = parseToUTC(elem[0]);
                    elem[1] = parseInt(elem[1]);
                });
                $("#container-1").highcharts().series[0].update({data: aData});
            },
            error: function(data){
                Notifier.error(data.responseJSON.error.join('<br>'));
            }
        });
    });

    $("#form-3").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: location.href + '/tres',
            dataType: "json",
            data: $("#form-3").serialize(),
            success: function (aData) {
                aData = aData.map(function(e){return [e.descripcion, e.cantidad]});
                $("#t3").DataTable().destroy();
                $("#t3").dataTable({
                    data: aData
                });
            },
            error: function(data){
                Notifier.error(data.responseJSON.error.join('<br>'));
            }
        });
    });

    $("#exportar-1, #exportar-2, #exportar-3").submit(function (e) {
        //console.log($(this).siblings().children("table"));
        /*$.ajax({
         type: 'POST',
         url: location.href + '/exportarpdf',
         data: {html: '<h3>'+$(this).attr('data-type')+'</h3><table>' + $(this).siblings().children("table").html() + '</table>'},
         success: function (aData) {
         window.open("https://drive.google.com/viewerng/viewer?url=http://grupo_45.proyecto2014.linti.unlp.edu.ar/images/file.pdf");
         //window.location.hostname
         }
         });*/
        var str = '<h3>' + $(this).attr('data-type') + '</h3><table>' + $(this).siblings().children("table").html() + '</table>';
        $(this).children("textarea").val(str);
        
    });
//=========================================================================================

    $j('#container-2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1
        },
        title: {
            text: 'Kilos de alimento que le fueron entregados a E.R.'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}KG</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f}%, {point.y}KGs',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }},
        series: [{
                type: 'pie',
                name: 'KG alimentos',
                data: []
            }]
    });


    $j('#container-1').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Listado (entre fechas) de los kilos de pedidos que fueron entregados'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%e. %b'
            },
            title: {
                text: 'Fechas'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Alimentos vencidos ( kg ) ',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        legend: {enabled: false},
        tooltip: {
            pointFormat: '<b>{point.y}KGs</b>'
        },
        series: [{
                name: 'FECHAS',
                data: []
            }]
    });

});
</script>
@stop
<!--/*http://jsfiddle.net/gh/get/jquery/1.9.1/highslide-software/highcharts.com/tree/master/samples/highcharts/demo/column-parsed/*/ -->

