<?php

class Datos
{

    private $info;
    /* info = ['cols' => ['c1', 'c2', 'c3' ]
               , 'llave' => 'llave']
    */
    private $tabla =[];
    
    public function __construct(array $datos){
        $this->info = $datos;
    }

    /* $datos = []*/
    public function insert(stdClass $o):bool{
        $columnas = [];
        foreach($this->info['cols'] as $col){
            $columnas[$col] = $o->$col;
        }
        $llave = $this->info['llave'];
        $id = $o->$llave;
        $this->tabla[$id] = $columnas;
        return true;
    }

    public function update(array $datos):bool{
    }
 
    public function exists(string $id):bool{
        return array_key_exists($id,$this->tabla);        
    }

    public function all():array{
        $elementos = [];
        foreach($this->tabla as $elemento => $valores){
            $o = new stdClass();
            foreach($this->tabla[$elemento] as $llave =>$valor){
                $o->$llave = $valor;
            }
            $elementos[] =$o;
        }
        return $elementos;
    }

    public function select(string $id):stadClass{
        
    }
    
}