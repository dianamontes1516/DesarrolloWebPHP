<?php

interface BaseDatos
{
    public function todos(string $tabla):array;
    
    public function listaTablas():array;
   
}