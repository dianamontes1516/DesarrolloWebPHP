<?php
declare(strict_type=1);
/**
 * Funci�n que recibe una cadena y devuelve un arreglo
 * conteniendo la longitud y la palabra mas chica
 * @param cadena - sucesi�n de palabras separadas por espacios
 * @return array - arreglo asociativo con llaves 'minima' que tenga la 
 *                 palabra mas chica y 'longitud' que tenga el numerito 
 *                 correspondiente a la longitud
 * 
*/
function palabraMinima(string $cadena):array{
    $cachitos = explode(' ', $cadena);
    $longitud = strlen($cachitos[0]);
    $indice = 0;
    for($i = 0 ; $i < count($cachitos) ; $i++){
        if($longitud > strlen($cachitos[$i])){   //Aqui ten�a un error en el c�digo pasado. //que pasar�a si se cambia la condici�n a >=?
            $indice = $i;
            $longitud = strlen($cachitos[$i]);
        }
    }
    return ['minima' => $cachitos[$indice],
            'longitud' => $longitud];
}
 
/**
 * Funci�n que recibe un arreglo con una palabra y 
 * dos numero y hace una operaci�n
 * @param valores - arreglo asociativo con tres llaves:
 *                 'op' que puede tener los valores de: suma, resta, 
 *                multiplicaci�n, divisi�n.
 *                'op1' operando 1
 *                'op2' operando 2
 * @retun float resultado de la operaci�n
 * 
*/
function calcula(array $valores):float{
    switch($valores['op']){
        case 'suma':
            return $valores['op1'] + $valores['op2'];
            
        case 'resta':
            return $valores['op1'] - $valores['op2'];
            
        case 'multiplicacion':
            return $valores['op1'] * $valores['op2'];
            
        case 'division':
            return $valores['op1'] / $valores['op2'];
            
        default:
            return ;
    }
}

print_r(palabraMinima("Hoy es un dia muy lluvioso"));
$entrada = ['op' => 'sumsa',
             'op1' => 2,
             'op2' => 3];

try{
    echo calcula($entrada);
}catch(TypeError $e){
    echo "Operacion no reconocida\n";
}

