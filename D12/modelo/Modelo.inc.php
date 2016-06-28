<?php
require_once 'DB.inc.php';

/**
 * Clase que abstrae un modelo para una arquitectura MVC
 */
class Modelo
{
    /**
     * Tabla en la base de datos del modelo
     * @var string
     */
    protected $tabla;
    protected $id;
    private $base;

    /**
     */
    function __construct($t) {
        $this->tabla = $t;
        $this->base = new DB();
    }

    /**
     * Método para obtener todos los ejemplares del modelo
     * @return array Arreglo con los modelos
     */
    public function all(){
        return $this->base->selectAll($this->tabla);
    }

    /**
     * Método para obtener todos los ejemplares del modelo ordenados
     * @param  string $value Columna por la cual ser ordenados
     * @return array        Arreglo con los modelos ordenados
     */
    public function allOrdered(string $value){
        return $this->base->selectAllOrdered($this->tabla, $value);
    }

    /**
     * Método para encontrar un modelo por su ID
     * @param  string $id Identificador del modelo en la BD
     * @return array     Modelo
     */
    public function find($id,$col='id'){
        return $this->base->select($this->tabla, $id, $col);
    }

    /**
     * Método para buscar un modelo por una claúsula where
     * @param  string $column Columna para la claúsula where
     * @param  mixed $value  Valor por el cual buscar en la claúsula
     * @return array         Modelos que cumplen con la claúsula where
     */
    public function where($column, $value)
    {
        return $this->base->where($this->tabla, $column, $value);
    }

    /**
     * Método para buscar un modelo por una claúsula where
     * @param  string $column Columna para la claúsula where
     * @param  mixed $valuea  Valores por el cual buscar en la claúsula
     * @return array         Modelos que cumplen con la claúsula where
     */
    public function filter($values){
        return $this->base->filter($this->tabla, $values);
    }
    
    /**
        Método para buscar objetos de modelo en la base de datos.
        Puedes especificar solo ciertos atributos que buscar
        y puedes buscar objetos con ciertos valores en los atributos de los mismos
        @param Array(String) $cols Arreglo con los nombres de los atributos 
       deseados. Se puede ingresar ["*"] para conseguir todos los atributos
        @param Assoc(String=>String) $values Arreglo asociativo entre los nombre 
       de los atributos y los valores deseados en los objetos buscados
        @return Array(Assoc) Arreglo con valores de los objetos de modelo 
       encontrados. False si hubo un error
    */
    public function select($cols,$values = null) {
        return $this->base->selectFilter($this->tabla,$cols,$values);
    }

    /**
     * Método para insertar un modelo en la base de datos
     * @param  array $values Un arreglo de llaves y valores del modelo
     * @return Array La tupla insertada
     */
    public function insert($values)
    {
	return $this->base->insert($this->tabla, $values);
    }

    /**
     * Método para actualizar un modelo en la base de datos
     * @param  array $values Un arreglo de llaves y valores del modelo
     * @param  string $id     Identificador del modelo en la BD
     * @return boolean         True en caso exitoso, false e.o.c.
     */
    public function update($values, $id){
        return $this->base->update($this->tabla, $values, $id);
    }

    /**
     * Método para eliminar un modelo de la base de datos
     * @param  string $id Identificador del modelo en la BD
     * @return boolean     True en caso exitoso, false e.o.c.
     */
    public function delete($id){
        return $this->base->delete($this->tabla, $id);
    }

    public function query($q, $modo){
        return $this->base->query($q,$modo);
    }
}

