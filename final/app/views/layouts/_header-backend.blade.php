
<header>	
    <div style="text-align: right; margin: 1%;max-width: 50%;position:relative;float:right" ><p>Bienvenido <b>{{ Auth::user()->username }}</b> - <a href="./{{$server}}configuracion"> Configuracion </a> <a href="./{{$server}}final/public/logout"><img src="{{ $server }}images/icons/glyphicons_387_log_out.png" alt="candado"></a></p></div>
	<img alt ="logo-empresa" id ="logo-img" style ="border-radius: 15px; position:relative;" src="./{{ $server }}images/logo-web.jpg"/>
</header>