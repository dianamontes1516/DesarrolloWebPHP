<?php
require_once 'Modelo.inc.php';

class UsuarioModelo extends Modelo
{
    public function __construct(){
        parent::__construct('usuario');
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

    public function alta(Usuario $u):bool{
        $datos = ['username' => $u->username
                  ,'nombre' => $u->nombre
                  ,'apellidop' => $u->aPaterno
                  ,'apellidom' => $u->aMaterno
                  ,'correo' => $u->correo
                  ,'constraseña' => hash('sha256', $u->password)
                  ,'rol' => $u->rol];
        $this->insert($datos);
        return true;
    }
}

