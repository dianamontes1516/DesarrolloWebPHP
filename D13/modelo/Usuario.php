<?php

class Usuario
{
    private $nombre;
    private $aPaterno;
    private $aMaterno;
    private $username;
    private $password;
    private $correo;
    private $rol;

    public function __constructor(string $id){
        $this->username = $id;
    }
    
    /* Métodos SET */
    /* Métodos GET */

    public function getNombre():string{
        return $this->nombre;
    }

    public function getAPaterno():string{
        return $this->aPaterno;
    }
    
    public function getAMaterno():string{
        return $this->aMaterno;
    }
    
    public function getNombreCompleto():string{
        $n = $this->nombre;
        $n .= ' '.$this->aPaterno;
        $n .= ' '.$this->aMaterno;
        return $n;
    }
    
    public function getUsername():string{
        return $this->username;
    }

    public function getPassword():string{
        return $this->password;
    }

    public function getRol():int{
        return $this->rol;
    }

    public function getCorreo():int{
        return $this->correo;
    }

    public function setCorreo(int $c){
        $this->correo = $c;
    }
    
    public function setRol(int $rol){
        $this->rol = $rol;
    }
    
    public function setPassword(string $pass){
        $this->password = $pass;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }
    
    public function setAPaterno(string $aP){
        $this->aPaterno = $aP;
    }
    
    public function setAMaterno(string $aM){
        $this->aMaterno = $aM;
    }
}