<?php
require_once('Datos.php');

class DatosPSQL implements Datos
{
    private $conexion;
    private $tabla;
    
    public function __construct(array $db_config){
        $db_connection = [];
        // Construimos cadena para la conexión a la DB
        foreach ($db_config as $param => $value) {
            $db_connection[] = "{$param}='{$value}'";
        }
        // Se crea la conexión a la base de datos
        if (!pg_connect(implode(' ', $db_connection))) {
            die(
                'Error: La base de datos no se encuentra disponible.'
            );
        }
    }

    public function insert(stdClass $o):bool{
        $query = "insert into ".$tabla." values (";
        $array = get_object_vars($o);
        $llaves = 
        $valores = 

    }

    public function update(stdClass $o):bool{
    }
 
    public function exists(string $id):bool{
    }

    public function all():array{
    }

    public function select(string $id):stdClass{
        $query = "select * from ".$tabla;
    }

    public function delete(string $id):bool{
    }
    
}
$db_config = [
	'host' => 'localhost',
        'port' => '5432',
        'user' => 'personal',
        'dbname' => 'registro',
        'password' => 'kndaXBNU',
];


$a = new DatosPSQL($db_config);