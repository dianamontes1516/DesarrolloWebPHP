<?php
require_once 'configuracion.inc.php';

/**
 * Clase DB para abstraer operaciones repetitivas con la base de datos.
 */
class DB
{

    private $con;
    
    public function __construct(){
        $string_con = DB.":dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT;
        try{
            $this->con = new PDO($string_con,DB_USER,DB_PASSWORD);
        }catch(PDOException $Epdo){
            echo "Unable to conect to Database.";
        }
    }

    public function getCon():PDO{
        return $this->con;  
    }
    
    /**
     * Fúnción para realizar un query a la base de datos
     * @param <string> $query - consulta
     * @param <boolean> $assoc - dice si se quiere el resultado como un
     * 							arreglo associativo.
       @return Si hubo error en la consulta regresa falso. Si la consulta fue exitosa,
       pero no hay renglones que devolver, regresa []. Si fue exitosa y obtuvo renglones,
       regresa un arreglo con los valores encontrados
     */ 
    public function query($query,$assoc){
        $resultado = $this->con->query($query);
        if($resultado === false){ //error
            return false;
        }else{
            $resultado->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
            $resultado = $assoc ? $resultado->fetch(PDO::FETCH_ASSOC)
                       : $resultado->fetchAll(PDO::FETCH_ASSOC);
            if($resultado === false) {
                return [];
            } else {
                return $resultado;
            }
        }
    }

    /**
     * Función para realizar consultas en modo de transacción
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function begin():bool{
        return $this->con->beginTransaction();
    }

    /**
     * Función para realizar un commit de una transacción
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function commit(){
        return $this->con->commit();
    }

    /**
     * Función para realizar un rollback en una transacción
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function rollback(){
        return $this->con->rollBack();
    }

    /**
     * Función para realizar un select en una tabla de la base de datos
     * y que esta se haga sobre la columna de id de la tabla
     * @param  String $table Nombre de la tabla en la base de datos
     * @param  String $id    ID de búsqueda
     * @return 
     */
    public function select($table, $id, $col='id'){
        $b= $this->con->query("SELECT * FROM {$table} WHERE {$col} = '{$id}'");
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetch();
    }
    
    /**
        Función para realizar un select en una tabla de la base de datos
        especificando columnas especificas. Opcionalmente puedes ingresar
        filtros para especificar tu búsqueda
        @param String $table nombre de la tabla para realizar el select
        @param Array(String) $cols Nombres de las columnas que seleccionar. Se puede ingresar ["*"] para buscar todo
        @param Assoc(String=>String) $values Parámetro opcional para especificar columnas con ciertos valores para la búsqueda
        @return Array(Assoc) Resultado del select. Falso si hay un error
    */
    public function selectFilter($table,$cols,$values = null) {    
        $cols = implode(", ",$cols);
        if($values) {
            $query = "SELECT ".$cols." FROM {$table} WHERE ";
        } else {
            $query = "SELECT ".$cols." FROM {$table};";
        }
        $filtros =[];
        foreach($values as $llave => $valor){
            $filtros[] = $llave." = "."'{$valor}'";
        }
        $query.= implode(' AND ', $filtros);
        $b= $this->con->query($query);
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetchAll();
    }

    /**
     * Función que realiza un select de todos los elementos de una tabla
     * @param  String $table Nombre de la tabla en la base de datos
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function selectAll($table){
        $b= $this->con->query("SELECT * FROM {$table}");
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetchAll();
        //return $this->query("SELECT * FROM {$table}",ALL);
    }

    /**
     * Función que realiza un select de todos los elementos de una tabla
     * @param  String $table Nombre de la tabla en la base de datos
     * @param String $column Columna por la cual ordenar
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function selectAllOrdered($table, $column)
    {
        $b= $this->con->query("SELECT * FROM {$table} ORDER BY $column");
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetchAll();
    }

    /**
     * Función para realizar una busqueda con un where en la base de datos
     * @param  String $table  Nombre de la tabla de la base de datos
     * @param  String $column Nombre de la columna en la que buscar
     * @param  String $value  Valor que empatar en la búsqueda
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function where($table, $column, $value){
        $b= $this->con->query("SELECT * FROM {$table} WHERE {$column} = '{$value}'");
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetchAll();
    }

    /**
     * Función para realizar una busqueda con un where en la base de datos
     * @param  String $table  Nombre de la tabla de la base de datos
     * @param  String $values  Valor que empatar en la búsqueda
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function filter($table, $values)
    {
        $query = "SELECT * FROM {$table} WHERE ";
        $filtros = [];
        foreach($values as $llave => $valor){
            $filtros[] = $llave." = "."'{$valor}'";
        }
        $query.= implode(' AND ', $filtros);
        echo $query;
        $b= $this->con->query($query);
        $b->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        return $b->fetchAll();
    }

    /**
     * Función que realiza un update e una tabla de la base de datos
     * @param  String $table  Nombre de la tabla de la base de datos
     * @param  array $values Arreglo de llaves y valores (columnas, valor)
     * @param  String $id     ID del update a realizar
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function update($table, $values, $id){
        if (!isset($id) || !$id) {
            return false;
        }

        $valuesClause = array();
        foreach ($values as $key => $value) {
            if(is_null($value) || $value === 'null') {
                $valuesClause[] = "{$key} = NULL";
            } else {
                $valuesClause[] = "{$key} = '{$value}'";
            }
        }
        $valuesClause = implode(', ', $valuesClause);
        return $this->query(
            "UPDATE {$table} SET {$valuesClause} WHERE id = '{$id}'",ASSOC
        );
    }

    /**
     * Función para realizar una inserción en la base de datos
     * @param  String $table  Nombre de la tabla de la base de datos
     * @param  array $values Arreglo de llaves y valores (columnas, valor)
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function insert($table, $values){
        $columns = implode(', ', array_keys($values));
        $values = implode('\', \'', array_values($values));
        
        return $this->query(
            "INSERT INTO {$table} ({$columns}) VALUES ('{$values}') RETURNING *",
            ASSOC
        );
    }

    /**
     * Función para eliminar un renglón de una base de datos
     * @param  String $table Nombre de la tabla de la base de datos
     * @param  String $id    ID por la cual realizar la eliminación
     * @return boolean        True en caso de éxito, false e.o.c
     */
    public function delete($table, $id){
        if (!isset($id) || !$id) {
            return false;
        }

        return $this->query(
            "DELETE FROM {$table} WHERE id = '{$id}'",
            ASSOC
        );
    }
    
}

$c = new DB();
//var_dump($c->select('profesor','10000'));
//var_dump($c->selectAll('profesor'));

/* Instrucción para verificar si tiene instalado el driver */
//print_r(PDO::getAvailableDrivers());
