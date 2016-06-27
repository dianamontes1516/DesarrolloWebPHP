<?php
$ruta = '/home/dmontes/Documents/CSC/inter0616/DesarrolloWebPHP/D11';
require_once($ruta.'/modelo/LibroModelo.php');

class LibroControlador
{

    private $libroM;
    
    public function __construct(){
        $this->libroM = new LibroModelo();
    }

    /* Muestra: libro, autor, diponibilidad
     */
    public function catalogo():array{
        
    }
    
}

$uC = new UsuarioControlador();
var_dump($uC->login('fua2', 'fuasda2'));