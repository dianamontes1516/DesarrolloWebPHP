<?php
require_once 'Modelo.inc.php';

class LibroModelo extends Modelo
{
    public function __construct(){
        parent::__construct('usuario');
    }

    /* Hace una consulta para devolver todos los libros 
     * que hay y su disponiblidad
     */
    public function catalogo(){
        $query = "select l.titulo
                       , l.autor
                       , count(e.id) as total
                       , count(p.id) as prestamos
                       , count(e.id) -count(p.id) as disponibles
                  from ejemplares e 
                  join libro l on (e.id_libro = l.id)
                  left join prestamos_activos p on (e.id=p.id_ejemplar) 
                  group by l.id ";
        return $this->query($query, ALL);
    }
    
}