<?php

/** 
*/
class Usuario
{
    /** Arreglo estático que contendrá la
     * información de los usuarios activos
     * 'username':
     * 'pass': contraseña cifrada hash('sha256','contraseña'); 
     * 'last_login': fecha obtendia con date("F j, Y, g:i a"); 
     */

    /* Los miembros de la clase Usuario deberán tener 
    * las siguiente propiedades: username, password
    */
	private $username;
	private $password;
    private $last_login;
    private $name;
    
    /* Constructor
     */
    public function __construct(string $id,string $p, string $n, string $l = ''){
        $this->username = $id;
        $this->password = $p;
        $this->last_login = $l;
        $this->name = $n;
        echo "Creación de un nuevo usuario: ".$this->username."\n";
    }

    public function getUsername():string{
        return $this->username;
    }

    public function getPass():string{
        return $this->password;
    }
    public function getName():string{
        return $this->name;
    }
    public function getLastLogin():string{
        return $this->last_login;
    }

    public function setPassword(string $p):bool{
        $this->password = $p;
        return true;
    }

    public function setLastlogin(string $l):bool{
        $this->last_login = $l;
        return true;
    }

    public function setName(string $n):bool{
        $this->name = $n;
        return true;
    }

}