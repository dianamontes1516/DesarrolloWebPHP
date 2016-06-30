function validUser(valor){
    $.ajax({
        url: 'usuarioValido', // Biblio/usuarioValido
        method: 'POST',
        dataType: 'json',
        data: {username:valor},
        success: function(response) {
            if(response.status == 200) {
		console.log(response);
                alert('usuario válido');
            } else {
		console.log(response);
		alert('usuario no válido');
            }
        }
    });

}

$(document).ready(function() {
    $('#').change(function(){
	validUser(this.value);
    });	
    
    $('#alta').validate({
        rules: {
            usern: {
        	required: true,
		alfabetico: true,
            },
	    pass: {
        	required: true,
		alfabetico: true,
	    }
        },
        messages: {
            usern: {
        	required: "Ingrese nombre usuario.",
            },
            pass: {
        	required: "Ingrese contraseña.",
            }
        }
    }); 
});
