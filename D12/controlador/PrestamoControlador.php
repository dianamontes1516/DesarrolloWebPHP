<?php
require_once($ruta.'/modelo/PrestamoModelo.php');
class PrestamoControlador
{
    private $usuarioM;
    private $prestamoM;
    
    public function __construct(){
        $this->usuarioM = new UsuarioModelo();
        $this->prestamoM = new PrestamoModelo();
    }
    
    /* Recibe el total de días que duró el préstamo
     */
    public static function calcula_multa(int $dias, int $renovaciones):float{
        $dias_permitidos = 7;
        $renovaciones_permitidas = 1;
        $multa_dia = 5;

        $dias_multa = $dias-$dias_permitidos;        
        if($renovaciones > 0){
            $dias_multa -= min($renovaciones, $renovaciones_permitidas)*$dias_permitidos;
        }
        return $dias_multa * $multa_dia;        
    }

    /* Realiza las validaciones necesarias para saber si es posible una
     * renovación para ese préstamo
     */
    public function renovacion(string $id_p){
        
    }
    
}