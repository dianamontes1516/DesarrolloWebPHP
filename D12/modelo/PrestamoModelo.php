<?php
require_once 'Modelo.inc.php';

class PrestamoModelo extends Modelo
{
    public function __construct(){
        parent::__construct('prestamo');
    }

    /* Préstamos activos por usuario
     */
    public function prestamos_activos(string $id_u){
        $datos = ['upper(periodo)'=>'infinity'
                  ,'id_usuario' => $id_u];
        return $this->filter($datos);
    }

    public function dias_prestamo(string $id_u){
        $query = "with renovaciones as (
                        select count(fecha_renovacion) as renovaciones
     	                     , id_prestamo
                        from renovación
                        group by id_prestamo
                  )
                  select p.id
                       , lower(p.periodo) as inicio
                       , upper(p.periodo) as fin
                       , upper(p.periodo) - lower(p.periodo) as dias
                       , r.renovaciones
                  from prestamo p
                  join multa m on (p.id = m.id_prestamo)
                  join renovaciones r on (r.id_prestamo = p.id)
                  where p.id_usuario = '{$id_u}'
                       and not m.pagada";

        return $this->query($query, ALL);
        
    }

    //TODO
    /* Realiza una renovación en el modelo.*/
    public function renovacion(){

    }

}
