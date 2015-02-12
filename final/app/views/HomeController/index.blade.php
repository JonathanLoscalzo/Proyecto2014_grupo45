
@extends('layouts.frontend_layout')

@section('head')
<script type="text/javascript" src="{{ $server }}js/plugins/jquery-2.1.2.js"></script>
<link href="{{$server}}/js/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="{{$server}}js/plugins/jquery-ui/jquery-ui.js"></script>
@stop


@section('content')
<div id="content">

    <h2>
        Lo que hacemos en el Banco Alimentario			
    </h2>
    <p>
        Somos una organizacion sin fines de lucro que tiene como misión la recuperación de alimentos para generar conciencia ambiental combatiendo el hambre y la desnutrición en la zona de La Plata.	
    </p>	
    <img class ="image-frontend" alt="imagen-banco" src="{{$server}}/images/imagen-banco.jpg" style="border-radius: 15px;">
</div>	
@stop
