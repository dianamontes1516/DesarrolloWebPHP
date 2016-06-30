<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/UsuarioControlador.php'; 
require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/LibroControlador.php'; 
session_name('Biblioteca');
session_start();
return routeRequest();

//$uri == '/Biblio/usuarioValido'

function routeRequest()
{
    $uri = $_SERVER['REQUEST_URI'];
    
    if (preg_match("/^\/Biblio(\/index|\/)?$/", $uri)){
        echo file_get_contents('./vista/index.php');

    } elseif (preg_match('/^\/Biblio\/libros\/catalogo$/', $uri)) { 
        $c = new LibroControlador();
        print_r($c->catalogo()); 

        /* pasan todos los jquerys*/
    } elseif (preg_match('/^\/Biblio\/consultor\/alta$/', $uri)){
        echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/vista/consultor/alta.php');        
    
    } elseif (preg_match("/Biblio\/login(\/)?$/", $uri)){
        if(isset($_SESSION['id_u'])){
            echo 'Ya estás in';
        }else{
            echo file_get_contents('./vista/login.php');
        }
        
    } elseif (preg_match("/Biblio\/usuario\/[\s\S]+$/", $uri)){
        if(isset($_SESSION['id_u'])){
            $valores = explode('/',$uri);
            switch($valores[3]){
            case 'inicio':
                echo "Hola";
                break;
            case 'actuales':
                break;
            case 'renovacion':
                break;
            case 'multas':
                break;
            case 'historial':
                break;
            default:  
                header("Location:/Biblio");
                break;
            }
        }else{
            header("Location:/Biblio/login");
         }
        
    } elseif (preg_match("/Biblio\/exit/", $uri)){
        echo "Hasta luego ".$_SESSION['id_u'];
		session_unset();
		session_destroy();
        
    } elseif (preg_match("/Biblio\/controlador\/[\s\S]+$/", $uri)){
            $valores = explode('/',$uri);        
            switch($valores[3]){
            case 'login':
                $u = new UsuarioControlador();                
                $resp = $u->login($_POST['username'],$_POST['pass']);
                if($resp){ //ejemplo simple, sólo un usuario logeado
                    $_SESSION['id_u']=$_POST['username'];
                    die(json_encode(['status'=>200, 'message'=> 'bien']));
                }else{
                    die(json_encode(['status'=>400, 'message'=> 'Credenciales inválidas.']));
                }
                break;
            case 'actuales':
                break;
            case 'renovacion':
                break;
            case 'multas':
                break;
            case 'historial':
                break;
            default:  
                header("Location:/Biblio");
                break;
            }
    } elseif (preg_match("/\/vista\/js\/[\s\S]*.js/", $uri)){
        echo file_get_contents($_SERVER['DOCUMENT_ROOT'].$uri);        
    }
}

