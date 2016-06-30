jQuery.validator.addMethod("numerico", function (value, element){
	return this.optional(element) || /^([0-9])*$/.test(value);
}, "Ingresa solo valores numericos");

jQuery.validator.addMethod("alfabetico", function (value, element){
	if (value.length == 0) {
		return true;
	}
	return this.optional(element) || /^([A-Za-z ñáéíóúÑÁÉÍÓÚ,]{1,200})$/.test(value);
}, "Ingresa solo valores alfabeticos");

jQuery.validator.addMethod("alfanumerico", function (value, element){
	if (value.length == 0) {
		return true;
	}
	return this.optional(element) || /^([A-Za-z0-9 .ñáéíóúÑÁÉÍÓÚ]{1,60})$/.test(value);
}, "Ingresa letras, numeros o (.) ");


jQuery.validator.addMethod("telefono", function (value, element){
	// no phone number is a good phone number (the field is optional)
	if (value.length == 0) {
		return true;
	}
	if (value.length < 8 || value.length > 11) {
		return false;
	}
	// if the phone number field is not empty, it has to follow the fixed format
	return this.optional(element) || /^([0-9])*$/.test(value);
}, "El telefono debe tener entre 8 y 10 caracteres numéricos");

jQuery.validator.addMethod("celular", function (value, element){
	// no phone number is a good phone number (the field is optional)
	if (value.length == 0) {
		return true;
	}
	if (value.length != 10) {
		return false;
	}
	// if the phone number field is not empty, it has to follow the fixed format
	return this.optional(element) || /^([1-9]{1}[0-9]{7,9})$/.test(value);
}, "El número de celular debe tener 10 caracteres numéricos, no puede comenzar con '0'.");


jQuery.validator.addMethod("email", function (value, element){
	return this.optional(element) || /^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*(.[a-zA-Z]{2,4}) *$/.test(value);
}, "Ingresa un correo válido");


jQuery.validator.addMethod("calleNumero", function (value, element){
	// solo se valida si se ingresa algun valor, dado que es un campo opcional
	if (value.length == 0) {
		return true;
	}
	// se verifica que solo se ingresen letras y numeros
	return this.optional(element) || /^[0-9A-Za-z ,.\-\/ñ#áéíóúÑÁÉÍÓÚ()]*$/.test(value);
}, "La calle y número no deben contener caracteres especiales");

jQuery.validator.addMethod("codigoPostal", function (value, element){
	// solo se valida si se ingresa algun valor, dado que es un campo opcional
	if (value.length == 0) {
		return true;
	}
	// se verifica que la longitud de la cadena ingresada sea de tamaño 5
	if (value.length != 5) {
		return false;
	}
	// se verifica que solo se ingresen valores numericos
	return this.optional(element) || /^([0-9])*$/.test(value);
}, "El codigo postal debe tener 5 caracteres numéricos");

jQuery.validator.addMethod("curp", function (value, element){
	if (value.length != 18) {
		return false;
	}
	return this.optional(element) ||/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/.test(value);
}, "Ingrese una curp valida");


jQuery.validator.addMethod("rfc", function (value, element){
	// se verifica que la longitud de la cadena ingresada sea de tamaño 13
	if (value.length != 13) {
		return false;
	}
	// se verifica que solo se ingresen valores alfanuméricos
	return this.optional(element) ||/^[a-zA-Z]{4,4}[0-9]{6}[a-z]|[A-Z]|[0-9]{3}$/.test(value);
}, "Ingrese un rfc valido");

jQuery.validator.addMethod("fecha", function (value, element){
	// se verifica que la longitud de la cadena ingresada sea de tamaño 13
	//if (value.) {
	//	return false;
	//}
	// se verifica que solo se ingresen valores alfanuméricos
	return this.optional(element) || /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/.test(value);
}, "Ingrese una fecha valida, ej:  06-10-2015");

/**
 * El formato de una hora es HH:MM ó HH:MM:SS.
 * Con las horas yendo de 00 a 23 y los minutos y segundos de 00 a 59
 */
 jQuery.validator.addMethod("hora", function (value, element){
 	return this.optional(element) || /^(([0-1][0-9])|(2[0-3]))(:[0-5][0-9]){1,2}$/.test(value);
 }, "Ingrese una hora valida, ej:  11:45");
