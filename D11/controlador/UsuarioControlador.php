<?php
$ruta = '/home/dmontes/Documents/CSC/inter0616/DesarrolloWebPHP/D11';
require_once($ruta.'/modelo/UsuarioModelo.php');
require_once($ruta.'/modelo/LibroModelo.php');
require_once($ruta.'/controlador/PrestamoControlador.php');

class UsuarioControlador
{

    private $usuarioM;
    private $prestamoM;
    private $libroM;
    
    public function __construct(){
        $this->usuarioM = new UsuarioModelo();
        $this->prestamoM = new PrestamoModelo();
        $this->libroM = new LibroModelo();
    }


    /* $pass en texto plano
     */
    public function login(string $id, string $pass):bool{
        $info = $this->usuarioM->find($id,'username');
        if(isset($info->username) === false){
            echo "Usuario no encontrado";
            return false;
        }
        if(hash('sha256',$pass) === $info->contraseña){
            echo "Login exitoso.";
            return true;
        }
        
        echo 'Credenciales inválidas';
        return false;
        
    }

    /* Como usuario quiero ver mis préstamos activos.
     */
    public function prestamos_activos(string $id_u){
        $usuario = $usuarioM->find($id,'username');
        if(isset($info->username) === false){
            echo "Usuario no encontrado";
            return false;
        }
        return $this->prestamoM->prestamos_activos($id_u);
    }

    /* Como usuario quiero saber cuánto debo.
     * El modelo recupera los días que han pasado 
     * desde que empezó cada prestamo
     */
    public function multa(string $id){
        $resultado = $this->prestamoM->dias_prestamo($id);
        $pesos = 0;
        foreach($resultado as $p){
            $pesos += PrestamoControlador::multa($p->id);
        }
        return $pesos;
    }

    
}

$uC = new UsuarioControlador();
var_dump($uC->login('fua2', 'fuasda2'));