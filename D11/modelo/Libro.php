<?php

class Libro
{

    private $id;
    private $titulo;
    private $autor;
    private $genero;
    private $idioma;
    private $anio;

    /* Métodos SET */
    /* Métodos GET */

    public function getId():string{
        return $this->id;
    }

    public function getTitulo():string{
        return $this->titulo;
    }
    
    public function getAutor():string{
        return $this->autor;
    }
    
    public function getGenero():string{
        return $this->genero;
    }
        
    public function getIdioma():string{
        return $this->idioma;
    }
    
    public function getAnio():string{
        return $this->anio;
    }
        
    public function setTitulo(string $t){
        $this->titulo = $t;
    }

    public function setAutor(string $a){
        $this->autor = $a;
    }
    
    public function setGenero(string $g){
        $this->genero = $g;
    }
    
    public function setIdioma(string $i){
        $this->idioma = $i;
    }
    
    public function setAnio(string $a){
        $this->anios = $a;
    }
}