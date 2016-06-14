<?php

/**
 * Parámetros por default. Mas de uno nulo y en
 * diferentes posiciones. 
 * OJO: Mala práctica
 */
function bla2($cadena=null, $dos, $tres = null, $cuatro=null, $cinco){
    return ['uno' => $cadena
            , 'dos' => $dos
            , 'tres' => $tres
            , 'cuatro' => $cuatro
            , 'cinco' => $cinco];

}
var_dump(bla2(7,3));

/**
 * Función que con número variable de parámetros .
 * No muy recomendable.
 */
function sum(...$numeros) {
    $acc = 0;
    foreach ($numeros as $n) {
        $acc += $n;
    }
    return $acc;
}

echo sum(1, 2, 3, 4);

function bla3(...$valores){
    foreach($valores as $val){
        echo $val;
    } 

}

var_dump(bla3(7,3));
var_dump(bla3(33,55,22,456,3242));
var_dump(bla3(99,11));

$var = "uno";
echo "cero $var";
echo 'cero $var';

echo FALSE == '0';