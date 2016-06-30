<!DOCTYPE html>
<html>
  <head>
    <title>Alta</title>

    <!-- Javascript -->
    <script type="text/javascript" src="/vista/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/vista/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/vista/js/util.validator.js"></script>
    <script type="text/javascript" src="/vista/js/alta.js"></script>
   
  </head>
  <body>
      <p> Ingresa los siguientes datos para darte de alta como usuario</p>
    <!-- El submit manejado en alta.js -->
    <form id="alta" >      
      <div >
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" > 
      </div>
      
      <div >
        <label>Apellido paterno:</label>
        <input type="text" name="apat" id="apat" > 
      </div>
      
      <div >
        <label>Apellido materno:</label>
        <input type="text" name="amat" id="amat" > 
      </div>
      
      <div >
        <label>username:</label>
        <input type="text" name="usern" id="usern" value=''> 
      </div>
      
      <div>
        <label for="pass" >Contraseña:</label>
        <input type="password" id="pass1" name="pass1">
      </div>
      
      <div>
        <label for="pass">Repite contraseña:</label>
        <input type="password" id="pass2" name="pass2" >
      </div>

      <div>
          <button id="Cancel">  <a href='/Biblio'> Cancelar</a>    </button>
          <button id="Acceder">  Alta     </button>
      </div>
    </form>
  </body>
</html>
