<?php


abstract class Model
{
	public function getArray() {
        /* podria crear una clase modelo que contenga esto,
          a su vez cada modelo va a tener un id.
         */
        $index = 0;
        $array = [];
        foreach (get_object_vars($this) as $key => $value) {
            $array[$index] = $value;
            $index +=1;
        }
        /* habria que ver si 
          Mysql puede reconocer o tengo que hacer esto si o si.
         */
        return $array;
    }
}