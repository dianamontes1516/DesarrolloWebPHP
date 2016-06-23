<?php
require_once ('configuracion.inc.php');
/**
 * Archivo de conexión a la base de datos
 */
$db_config = [
	'host' => DB_HOST,
	'port' => DB_PORT,
	'user' => DB_USER,
	'dbname' => DB_NAME,
	'password' => DB_PASSWORD,
];

$db_connection = [];
// Construimos cadena para la conexión a la DB
foreach ($db_config as $param => $value) {
	$db_connection[] = "{$param}='{$value}'";
}
// Se crea la conexión a la base de datos
if (!pg_connect(implode(' ', $db_connection))) {
	die(
		'Error: La base de datos no se encuentra disponible.' .
		PHP_EOL . 'Por favor contacte a los administradores del sistema'
	);
}

/** La configuración ahora se encuentra en el archivo configuracion.inc.php */
