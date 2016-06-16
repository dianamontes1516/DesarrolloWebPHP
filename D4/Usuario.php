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
    private static $usuarios=[['username'=>'dmontes'
                              ,'pass'=> '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'
                              ,'last_login'=>'June 15, 2016, 2:39 pm']
    ];

    /* Los miembros de la clase Usuario deberán tener 
    * las siguiente propiedades: username, password
    */
	private $username;
	private $password;
    
    /* Constructor
     */
    public function __construct(string $id,string $pass){
        $this->username = $id;
        $this->password = $pass;
        echo "Creación de un nuevo usuario: ".$this->username."\n";
    }

    /* Guarda la información del usuario en 
     * el arreglo de usuarios activos.
     * @return bool- regresa verdadero en caso de éxito
     *               lanza una excepción si ya había un usuario con
     *               el mismo usuario. 
     */
    public function save():bool{
    }

    /* Actualiza la información del usuario
     * en el arreglo de usuarios activos.
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo   
     */
    public function login():bool{
    }

    /* Borra al usuario del arreglo de los
     * usuarios activos.
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo con esos datos.  
     */
    public function delete():bool{

    }

    /* Actualiza la contraseña del usuario en la propiedad del 
     * objeto y en la lista de los usuarios.
     * @param string - la nueva contraseña en texto plano
     *               ¡no olvidar cifrarla antes de guardarla!
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo con esos datos.  
     */
    public function changePassword(string $pass):bool{

    }

    /* Determina si el usuario es activo. 
     * @return bool- verdarero en caso de que el usuario esté en 
     *               el arreglo de usuarios activos 
     *               falso en otro caso.
     */
    public function active():bool{
        foreach(self::$usuarios as $user){
            if($user['username'] == $this->username){
                return TRUE;
            }
        }
        return FALSE;
    }

    /** Regresa los usuarios en una cadena con elsig formato
     * @return string - El usuario --A- ingreso por última vez ---- 
     *                  El usuario -B-- ingreso por última vez ----
     * y así con todos los usuarios
     */
    public static function getRegistro():string{
        $registro = '';
        foreach(self::$usuarios as $user){
            $registro.= "El usuario ".$user['username']
                     ." ingresó por última vez "
                     .$user['last_login']."\n";
        }
        return $registro;
    }

    /** Regresa un arreglo y en cada entrada están contenidos cada uno de los 
     * activos.
     * @return array - contine objetos usuario 
     */
    public static function getUsuarios():array{
        
    }
    
}



/*************  Test Usuarios    **********/

$u= new Usuario('user1',hash('sha256','pass'));
var_dump($u->active());
echo "\n ";

Usuario::$usuarios;




