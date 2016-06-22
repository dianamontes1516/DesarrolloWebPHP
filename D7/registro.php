<?php
require_once('UsuarioControlador.php');

$controller = new UsuarioController;

echo "Opciones:";

$loop = true;
while($loop){
	$opcion = readline(" 1. Dar de alta usuario  2. login  3. Borrar Usuario  4. Mostrar usuarios: 5. Salir");
	switch($opcion){
		case 1:
			$nombre = readline('Escriba el nombre del usuario:');
			$username = readline('Escriba username:');
			$pass1 = readline('Escriba contraeña:');
			$pass2 = readline('Repita contraeña:');
			$nuevo = ['username'=>$username,
				  'pass1'=> $pass1,
				  'pass2'=> $pass2,
				  'nombre'=> $nombre];
			$resultado = $controller->nuevoUsuario($nuevo);
			if($resultado['status']){
				echo "Usuario Guardado exitosamente";
				break;
			}
			echo $resultado['mensaje'];
			break;

		case 2:
			$username = readline('Escriba username:');
			$pass1 = readline('Escriba contraeña:');
			$resultado =$controller->login($username, $pass1);
		        if($resultado){
                		echo "Acceso exitoso;";
                		break;
            		}
            echo "Credenciales inválidas";
			break;
            
		case 4:
			var_dump($controller->getUsuarios());
			break;
		case 5:
			echo "adios";
			$loop = false;
			break;
    
    }
}
