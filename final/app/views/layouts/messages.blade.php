

@if ($errors->has())
                <div id="errorwrap">
                    <div id="alert-dialog" class="alert-dialog error" title="ALERTA">
                        <ul>         
                        
                        @foreach ($errors->all() as $error)   <!-- aqui se deberia incluir un 
                                                         template para el error !-->
                            <li><p> {{ $error }} </p></li>
                        @endforeach
                            <li><button id="dismiss" >X</button></li>
                        </ul>
                    </div>
                </div>
@endif


@if (Session::has('message'))
                <div></div> 
                
                <div id="errorwrap">
                    <div id="alert-dialog" class="alert-dialog success" title="ALERTA">
                        <ul>         
                            <li><p> {{ Session::get('message') }} </p></li>
                            <li><button id="dismiss" >X</button></li>
                        </ul>
                    </div>
                </div>
@endif