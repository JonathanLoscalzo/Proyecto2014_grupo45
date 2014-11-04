<?php


abstract class Model
{
	public function getArray() {
           
         /* VER ESTA FUNCION 
         array array_values ( array $array )          */
        /* podria crear una clase modelo que contenga esto,
          a su vez cada modelo va a tener un id.
         */
        $index = 0;
        $array = [];
        foreach (get_object_vars($this) as $key => $value) {
            $array[$index] = $value;
            $index +=1;
        }
        
        /*
         * 
         * 
         * ARRAY_VALUES(GET_OBJECT_VARS($THIS));
         * 
         */
       
        return $array;
    }
}