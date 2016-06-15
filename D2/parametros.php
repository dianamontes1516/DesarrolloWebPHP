<?php

/**
 * Par�metros por default. Mas de uno nulo y en
 * diferentes posiciones. 
 * OJO: Mala pr�ctica
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
 * Funci�n que con n�mero variable de par�metros .
 * No muy recomendable.
 */
function sum(...$numeros) {
    $acc = 0;
    foreach ($numeros as $n) {
        $acc += $n;
    }
    return $acc;
}
echo "\n";
echo sum(1, 2, 3, 4);
echo "\n";
echo sum(1, 2, 3, 4,7,12);
echo "\n";

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