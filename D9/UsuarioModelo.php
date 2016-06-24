<?php
require_once 'Modelo.inc.php';

class UsuarioModelo extends Modelo
{
    public function __construct(){
        parent::__construct('usuario');
    }

    /* Hace una consulta específica para ver cuántos
     * días lleva sin devolver el libro
     */
    public function deuda(Usuario $u):integer{
        //$this->query(consulta, ASSOC);
    }

    /* Hace una consulta específica para ver el 
     * historial del usuario.
     */
    public function historico(Usuario $u):integer{
        //$this->query(consulta, All);        
    }

}