<?php

class AlimentosVencidos extends Eloquent{
        
    public static function alimentos_por_entidad_entre_fechas($from,$to)
    {
        return DB::select('call alimentos_por_entidad_entre_fechas(?,?)', [$from, $to])->select('razon_social','kilogramos');
    }
    
    public static function alimento_entre_fechas($from,$to)
    {
        return DB::select('call alimento_entre_fechas(?,?)', [$from, $to])->select('fecha','kilogramos');
    }
    
    public static function alimentos_vencidos_agrupados_descripcion()
    {
        return DB::select('select descripcion, cantidad from alimentosvencidos');
    }
    
    
    
    
}
