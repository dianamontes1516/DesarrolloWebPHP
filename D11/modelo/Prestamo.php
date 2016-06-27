<?php

class Prestamo
{

    private $id;
    private $usuario;
    private $inicio;
    private $fin;

    /* Métodos SET */
    /* Métodos GET */

    public function getId():string{
        return $this->id;
    }

    public function getUsuario():string{
        return $this->usuario;
    }
    
    public function getInicio():string{
        return $this->inicio;
    }
    
    public function getfin():string{
        return $fin;
    }
        
    public function setUsuario(string $u){
        $this->usuario = $u;
    }

    public function setInicio(string $fi){
        $this->inicio = $fi;
    }
    
    public function setFin(string $ff){
        $this->fin = $ff;
    }
}