<?php
/** Nombre de la clase.
 *  No puede empezar con punto*/
class Persona {

    /* Propiedades de los miembros de las clase o atributos*/
    private $nombre = 'Pedro';
    private $apellido_paterno = 'Juárez';
    private $apellido_materno = 'Romero';
    private $correo;
    private static $poblacion =0;
    const especie = "Humano";

   /** Constructor*/
    public function __construct(string $nombre
                                , string $apellidoP
                                , string $apellidoM) {
        self::$poblacion++;
        $this->nombre = $nombre;
        $this->apellido_paterno = $apellidoP;
        $this->apellido_materno = $apellidoM;
    }

    public function saludaA(string $nombre):string {
        return 'Hola '.$nombre.'!';
    }

public static function getPoblacion():int{
    return self::$poblacion;
    }

}




try{
$p1 = new Persona('Diana', 'Montes', 'Aguilar');
echo $p1->saludaA('Korben Dallas');
var_dump($p1);
//echo $p1->correo;
}catch(TypeError $e){
echo "Imposible crear objeto. "
    ."Número o tipo de parámetros incorrecto.";
}
echo Persona::especie;

class Italiano extends Persona
{
    private $anio_nac;

    public function __construct(string $nombre
                                , string $apellidoP
                                , int $anio){
        parent::__construct($nombre, $apellidoP, '');
        $this->anio_nac = $anio;
        // algo mas
    }
    
    public function saludar() {
        return "Ciao!";
    }
}


$a = new Italiano('fwfffqf',"sdsliod",1990);
$b = new Italiano('fwfqqwf',"solidsd",1987);
$c = new Italiano('fwfqf',"sdsiold",1997);
$d = new Italiano('fwfaasloisdqf',"sdsd",1992);
$e = new Italiano('fwfqf',"slioldsd",1993);

echo "\n Poblacion: ".Persona::getPoblacion();




