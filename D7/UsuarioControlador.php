<?php
require_once('DatosArreglo.php');
require_once('DatosPSQL.php');
require_once('Usuario.php');
/** 
*/
class UsuarioController
{
    /** Manejador de datos*/
    private $datos;


    public function __construct(){
        $this->datos = new DatosArreglo(['cols' => ['username','password','last_login','name']
                                ,'llave' => 'username']);
    }

    /** Se encarga de validar la información para 
     * 
     */
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
        if(!$this->active($id)){
            throw new Exception("Usuario no encontrado");
        }
        return self::convertToUsuario($this->datos->select($id));
    }
    
    /** Intenta hacer login con las credenciales pasadas  
     * @param  username - identificador del usuario.
     * @param pass - contraseña en texto plano
     * @return bool- verdarero en caso de éxito, falso en otro caso
     */
    public function login(string $username, string $pass ):bool{
        try{
            $u=$this->get($username);
        }catch(Exception $e){
            return false;
        }

        if($u->getPass() == hash('sha256',$pass)){
            return $this->edit($username,['last_login'=>date("F j, Y, g:i a")]);
        }
        
        return false;
    }

    /* Borra al usuario del almacenamiento persistente
     * @return bool- verdarero en caso de éxito, falso
     *  en cualquier otro caso.
     */
    public function delete(string $id):bool{
        if(!$this->active($id)){
            throw new Exception("Usuario no encontrado");
        }
        return $this->datos->delete($id);        
    }

    /** Actualiza la información en el banco de datos
     * @param id - username del usuario a modificar
     * @param array - información nueva
     *   debe estar en forma de arreglo asociativo. 
     *   las llaves corresponden al nombre de los atributos.
     * @return bool- verdarero en caso de éxito
     *               lanza una excepción en caso de que no
     *              exista un usuario activo con esos datos.  
     */
    public function edit(string $id, array $info):bool{
        if(!$this->active($id)){
            throw new Exception("Usuario no encontrado");
        }

        $u= new stdClass;
        $u->username = $id;
        foreach($info as $key => $value){
            $u->$key = $value;
        }
        
        return $this->datos->update($u);        
        
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
    
    public static function convertToUsuario(stdClass $s ):Usuario{
        $nuevoU = new Usuario($s->username, $s->password, $s->name, $s->last_login);
        return $nuevoU;            
    }
}


