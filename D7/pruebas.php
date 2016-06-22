<?php

$o = new stdClass;

$o->username = 'dmotnes';
$o->pass = 'bla';
$o->lastL = '2012-12-12';

$array = get_object_vars($o);
foreach($array as $k=>$v){
    print_r($k.' => '.$v);
}
       