function login(usr, pass){
    console.log("tratando de hacer login");
    $.ajax({
        url: 'controlador/login', // Biblio/
        method: 'POST',
        dataType: 'json',
        data: {username:usr,
	       pass:pass
	      },
        success: function(response) {
            if(response.status == 200) {
		url = "/Biblio/usuario/inicio";
		$( location ).attr("href", url);
            } else {
		console.log(response);
		alert(response.message);
            }
        }
    });

}

$(document).ready(function() {
    $('#login').submit(function(){
	event.preventDefault();
	login($('#usern').val(),$('#pass').val());
    });
    
    $('#login').validate({
        rules: {
            usern: {
        	required: true,
            },
	    pass: {
        	required: true,
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
