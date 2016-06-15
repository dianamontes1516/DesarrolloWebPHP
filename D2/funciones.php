<?php
declare(strict_types=1);
/**
 * Función que recibe una cadena y devuelve un arreglo
 * conteniendo la longitud y la palabra mas chica
 * @param cadena - sucesión de palabras separadas por espacios
 * @return array - arreglo asociativo con llaves 'minima' que tenga la 
 *                 palabra mas chica y 'longitud' que tenga el numerito 
 *                 correspondiente a la longitud
 * 
*/
function palabraMinima(string $cadena):array{
    return [$cadena];  

}

/**
 * Función que recibe un arreglo con una palabra y 
 * dos numero y hace una operación
 * @param valores - arreglo asociativo con tres llaves:
 *                 'op' que puede tener los valores de: suma, resta, 
 *                multiplicación, división.
 *                'op1' operando 1
 *                'op2' operando 2
 * @return float resultado de la operación
 * 
*/
function calcula(array $valores):float{
    

}


var_dump(palabraMinima('2'));
