<?php 
/********************************************************************
 ********************************************************************
 * Configuración de la aplicación del Sistema de Personal de Base
 ********************************************************************
 *********************************************************************/
/**
 * Variable para definir el ambiente
 * @var string - {DESARROLLO | PRODUCCIÓN}
 */
define('AMBIENTE', 'DESARROLLO');

if (AMBIENTE === 'DESARROLLO') {
	define('DB', 'pgsql');	
	define('DEBUG_SQL', true);	
	define('ASSOC', true);	
	define('ALL', false);	
    define('DB_HOST', '127.0.0.1');
	define('DB_PORT', '5432');
    define('DB_NAME', 'escuela');
	define('DB_USER', 'personal');
    define('DB_PASSWORD', 'kndaXBNU');

} elseif (AMBIENTE === 'PRODUCCIÓN') {

} else {
	die();
}
