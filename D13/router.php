<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/UsuarioControlador.php'; 
require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/LibroControlador.php'; 
session_name('Biblioteca');
session_start();
//echo session_id();

//echo "Constante que contiene el nombre de sesión ".SID;
//echo session_status();
return routeRequest();

function routeRequest()
{
    $uri = $_SERVER['REQUEST_URI'];
    
    //var_dump($_SESSION);

    if ($uri == '/Biblio/usuarioValido'){
        die(json_encode(['status'=>200, 'mesage'=> 'amdskam']));
    }
    if ($uri == '/Biblio') {
        $c = new UsuarioControlador();
        echo UsuarioControlador::bienvenida();

        /* pasan todos los jquerys*/
    } elseif (preg_match("/\/vista\/js\/[\s\S]*.js/", $uri)){
        echo file_get_contents($_SERVER['DOCUMENT_ROOT'].$uri);        
    
    } elseif ($uri == '/Biblio/login'){
        echo file_get_contents('./vista/index.php');
        
    } elseif (preg_match("/Biblio\/login(\/[a-zA-Z0-9]+){2}$/", $uri)){
        
        $u = new UsuarioControlador();
        $valores = explode('/',$uri);
        $resp = $u->login($valores[3],$valores[4]);
        if($resp){ //ejemplo simple, sólo un usuario logeado
            $_SESSION['id_u']=$valores[3];
        }
        
    } elseif (preg_match("/Biblio\/libros[\/a-zA-Z]*$/", $uri)){
        echo LibroControlador::bienvenida();        
        $c = new LibroControlador();
        if (preg_match("/Biblio\/libros\/catalogo/", $uri)){
            print_r($c->catalogo()); 
        }
        
    } elseif (preg_match("/Biblio\/usuario\/[a-zA-Z0-9]+$/", $uri)){
        $c = new UsuarioControlador();
        $valores = explode('/',$uri);
        if($_SESSION['id_u'] == $valores[3]){ //ejemplo simple, sólo un usuario logeado
            var_dump($c->info($valores[3]));
        }else{
            echo "No tienes acceso.";
        } 
        
    } elseif (preg_match("/Biblio\/exit/", $uri)){
        echo "Hasta luego ".$_SESSION['id_u'];
		session_unset();
		session_destroy();
    }
}

