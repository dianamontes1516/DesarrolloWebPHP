<?php
/* Modificación 18.07.2015
 * se valida cadenas mediante expresiones regulares.
 * En algunos casos si la cadena es vacia se evalua a falso
 * Lo cual no es muy conveniente, ya que solo se desea que
 * falle la validación cuando la cadena diferente a la vacia
 * no cumple con la expresión regulara.
 * Si en la validación se desea que falle cuando tiene valor nulo
 * la validación debe incluir required.
 * La modificación consiste en que solo se evaluen a falso
 * las cadenas diferentes de la vacia cuando no cumplen
 * con la respectiva ER.
 */

/**
 * Biblioteca de funciones para seguridad y validaciones
 */
class Validator {

    /**
     * Expresión regular para una CURP
     */
    const CURP_REGEX = "/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/";

    /*
     *Expresión regular para validar un rfc
     */
    const RFC_REGEX = "/^[a-zA-Z]{4}[0-9]{6}([a-z]|[A-Z]|[0-9]){3}$/";

    /**
     * Expresión regular para un email
     */
    const MAIL_REGEX = "/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/";

    /**
     * Expresión regular para un código postal
     */
    const CP_REGEX = "/^[0-9]{5}$/";


    /**
     * Método para verificar un CURP mediante una expresión regular
     * @param curp - string - CURP a validar
     */
    public function curp($curp) {
       return preg_match(self::CURP_REGEX, $curp)
       ?: 'Ingresa una CURP válida ';
   }

    /**
     * Método para verificar un RFC mediante una expresión regular
     * @param rfc - string - RFC a validar
     */
    public function rfc($rfc) {
       return preg_match(self::RFC_REGEX, $rfc)
       ?: 'Ingresa un RFC válido ';
   }

    /**
     * Método para verificar que el RFC y el curp comcuerden
     * Como las validaciones de curp y rfc se hacen individualmente
     * se asume que respetan las expresiones regulares que definen a ambos.
     */
    public function rfc_curp($params) {
       $curp = $params['curp'];
       $rfc = $params['rfc'];
       $prefijo = substr($curp, 0, 10);
       return preg_match("/^".$prefijo."/", $rfc)
       ?: 'El RFC y el CURP no coindicen. CURP introducido: '.$curp;
    }
    
    /**
     * Método para verificar un código postal mediante una expresión regular
     * @param cp - string - cp a validar
     */
    public function codigoPostal($cp) {
       return preg_match(self::CP_REGEX, $cp) || !$cp
       ?: 'Ingresa un código postal válido ';
   }

    /**
     * Método para verificar un email mediante una expresión regular
     * @param email - string - email a validar
     */
    public function mail($mail) {
       return preg_match(self::MAIL_REGEX, $mail) || !$mail
       ?: 'Ingresa un correo válido ';
   }

   
}

$validator = new Validator();
echo $validator->mail("fsdf");

?>
