<?php
require_once('Datos.php');
require_once('Usuario.php');
/** 
*/
class UsuarioController
{
    /** Manejador de datos*/
    private $datos;


    public function __construct(){
        $this->datos = new Datos(['cols' => ['username','password','last_login','name']
                                ,'llave' => 'username']);
    }

    public function nuevoUsuario(array $info):array{
        if($info['pass1'] != $info['pass2']){
            return ['status' => 0, 'mensaje'=>'Las contraseñas no coinciden'];
        }
        if($info['username']==""){
            return ['status' => 0, 'mensaje'=>'No ingreso username.'];
        }
        if($info['pass1']==""){
            return ['status' => 0, 'mensaje'=>'No ingreso contraseña.'];
        }
        if($info['nombre']==""){
            return ['status' => 0, 'mensaje'=>'No ingreso nombre.'];
        }

        $usuario = new Usuario($info['username'],hash('sha256',$info['pass1']),$info['nombre']);
        return ['status'=>$this->save($usuario)];
        
    }
    
    /* Persiste la información del usuario
     * @return bool- regresa verdadero en caso de éxito,
     *                falso en otr caso
     */
    public function save(Usuario $u):bool{
        if($this->active($u->getUsername())){
            return FALSE;
        }
        $this->datos->insert(UsuarioController::convertToStdcClass($u));
        return TRUE;
    }

    /* Regresa un usuario guardado en los datos
     * @param string id - identificador del usuario
     * @return Usuario - regresa un objeto usuario
     */
    public function get(string $id):Usuario{
        
    }
    
    /* @param  username - identificador del usuario.
     * @param pass - contraseña en texto plano
     * @return bool- verdarero en caso de éxito, falso en otro caso
     */
    public function login(string $username, string $pass ):bool{
        
    }

    /* Borra al usuario del arreglo de los
     * usuarios activos.
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo con esos datos.  
     */
    public function delete(string $id):bool{
        if(!$this->active()){
            throw new Exception("El usuario ".$this->username." no está activo.");
        }

        $i=0;
        foreach(self::$usuarios as $user){
            if($user['username'] == $this->username){
                break;
            }
            $i++;
        }
        unset(self::$usuarios[$i]);
        return TRUE;

    }

    /* Borra al usuario del arreglo de los
     * usuarios activos.
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo con esos datos.  
     */
    public function edit(Usuario $u, array $info):bool{
        if(!$this->active()){
            throw new Exception("El usuario ".$this->username." no está activo.");
        }

        $i=0;
        foreach(self::$usuarios as $user){
            if($user['username'] == $this->username){
                break;
            }
            $i++;
        }
        unset(self::$usuarios[$i]);
        return TRUE;

    }
    

    /* Determina si el usuario es activo. 
     * @return bool- verdarero en caso de que el usuario esté en 
     *               el arreglo de usuarios activos 
     *               falso en otro caso.
     */
    public function active(string $id):bool{
        return $this->datos->exists($id);
    }

    /** Regresa un arreglo y en cada entrada están contenidos cada uno de los 
     * activos.
     * @return array - contine objetos usuario 
     */
    public function getUsuarios():array{
        return $this->datos->all();
    }

    public static function convertToStdcClass(Usuario $u ):stdClass{
        $nuevostdC = new stdClass();
        $nuevostdC->username = $u->getUsername();
        $nuevostdC->password = $u->getPass();
        $nuevostdC->last_login = $u->getLastlogin();
        $nuevostdC->name = $u->getName();
        return $nuevostdC;            
    }
    
}



/*************  Test Usuarios    **********/
/**
$controller = new UsuarioController();
$u= new Usuario('user1',hash('sha256','pass'),'Diana Montes');
$controller->save($u);
print_r($controller->getUsuarios());



var_dump($u->active());
echo "\n ";
var_dump($u->save());
echo "\n ";
$u->login();
var_dump(Usuario::getRegistro());
var_dump($u->changePassword('pops'));
echo "\n ";
$u->login();
var_dump(Usuario::getRegistro());
*/
/*var_dump($u->save());
echo "\n ";
var_dump($u->active());
echo "\n ";
//var_dump($u->save());
echo "\n ";
var_dump(Usuario::getUsuarios());
echo "\n ";
$u->login();
var_dump(Usuario::getUsuarios());
$u->delete();
var_dump(Usuario::getUsuarios());
$usr = Usuario::getUsuarios();
var_dump($usr[0]->active());

var_dump(Usuario::getRegistro());

//Usuario::$usuarios;

/* Por que no usé username como llave :/ */



