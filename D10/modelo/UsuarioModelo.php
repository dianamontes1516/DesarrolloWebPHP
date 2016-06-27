<?php
require_once 'Modelo.inc.php';

class UsuarioModelo extends Modelo
{
    public function __construct(){
        parent::__construct('usuario');
    }

    /* Hace una consulta específica para ver cuántos
     * días lleva sin devolver el libro
     * @param u - Usuario sobre el que queremos hacer la búsqueda.
     * @param fecha - fecha a la que queremos cualcular 
     * @return integer - con el total de díás que tiene de deuda el usuario.
     */
    public function dias(Usuario $u, string $fecha):integer{
        
        //$this->query(consulta, ASSOC);
    }


    /* Determina si un usuario tiene derecho a un sacar 
     * prestamo. Esto es calculado a partir de los préstamos 
     * activos y las multas pendientes.
     * @param u - usuario del que se determimará su validez
     * @return bool - regresa la validez del usuaurio.
     */
    public function valido(Usuario $u):bool{
        
    }

    /* Hace una consulta específica para ver el 
     * historial del usuario.
     */
    public function historico(Usuario $u):array{
        //$this->query(consulta, All);        
    }

}

