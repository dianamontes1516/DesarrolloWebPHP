<?php
require_once 'DB.inc.php';

/**
 * Clase que abstrae un modelo para una arquitectura MVC
 */
abstract class Modelo
{
    /**
     * Tabla en la base de datos del modelo
     * @var string
     */
    protected static $table;

    /**
     * Revisamos en la base de datos la estructura de la
     * tabla de la base de datos y construimos el objeto
     * del modelo.
     */
    function __construct() {
	$columns = $this->getTableColumns();
	foreach ($columns as $column) {
	    $this->$column = null;
	}
	// $vars = get_object_vars($this);
	// die(json_encode($vars));
    }

    /**
     * Método para obtener las columnas de la tabla de la base de datos
     * @return array Arreglo de strings con los nombres de las columnas
     */
    private function getTableColumns()
    {
	$table = static::$table;
	$columns_info = DB::query(
	    "SELECT * FROM information_schema.columns
			WHERE table_schema = 'public'
			AND table_name   = '{$table}'", ALL
	);
	$columns = [];
	// TODO: data_type restrictions and validation pre-save
	foreach ($columns_info as $column_info) {
	    $columns[] = $column_info['column_name'];
	}

	return $columns;
    }

    /**
     * Método para una vez construido una instancia del modelo
     * Y obtenido sus valores de la base de datos, cargarlos al objeto
     * @param  array $array Arreglo con los atributos del objeto
     * @return boolean        True en caso exitoso, false e.o.c.
     */
    public function loadAttributes($array)
    {
	if (!is_array($array)) {
	    return false;
	}

	foreach ($array as $key => $value) {
	    $this->key = $value;
	}
	return true;
    }

    /**
     * Método para obtener todos los ejemplares del modelo
     * @return array Arreglo con los modelos
     */
    public static function all()
    {
	return DB::selectAll(static::$table);
    }

    /**
     * Método para obtener todos los ejemplares del modelo ordenados
     * @param  string $value Columna por la cual ser ordenados
     * @return array        Arreglo con los modelos ordenados
     */
    public static function allOrdered($value)
    {
	return DB::selectAllOrdered(static::$table, $value);
    }

    /**
     * Método para encontrar un modelo por su ID
     * @param  string $id Identificador del modelo en la BD
     * @return array     Modelo
     */
    public static function find($id)
    {
	return DB::select(static::$table, $id);
    }

    /**
     * Método para buscar un modelo por una claúsula where
     * @param  string $column Columna para la claúsula where
     * @param  mixed $value  Valor por el cual buscar en la claúsula
     * @return array         Modelos que cumplen con la claúsula where
     */
    public static function where($column, $value)
    {
	return DB::where(static::$table, $column, $value);
    }

    /**
     * Método para buscar un modelo por una claúsula where
     * @param  string $column Columna para la claúsula where
     * @param  mixed $valuea  Valores por el cual buscar en la claúsula
     * @return array         Modelos que cumplen con la claúsula where
     */
    public static function filter($values)
    {
	return DB::filter(static::$table, $values);
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
    public static function select($cols,$values = null) {
        return DB::selectFilter(static::$table,$cols,$values);
    }

    /**
     * Método para insertar un modelo en la base de datos
     * @param  array $values Un arreglo de llaves y valores del modelo
     * @return Array La tupla insertada
     */
    public static function insert($values)
    {
	return DB::insert(static::$table, $values);
    }

    /**
     * Método para actualizar un modelo en la base de datos
     * @param  array $values Un arreglo de llaves y valores del modelo
     * @param  string $id     Identificador del modelo en la BD
     * @return boolean         True en caso exitoso, false e.o.c.
     */
    public static function update($values, $id)
    {
	return DB::update(static::$table, $values, $id);
    }

    /**
     * Método para eliminar un modelo de la base de datos
     * @param  string $id Identificador del modelo en la BD
     * @return boolean     True en caso exitoso, false e.o.c.
     */
    public static function delete($id)
    {
	return DB::delete(static::$table, $id);
    }
}
