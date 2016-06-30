<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <!-- Javascript -->
    <script type="text/javascript" src="/vista/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/vista/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/vista/js/util.validator.js"></script>
    <script type="text/javascript" src="/vista/js/form.js"></script>
   
  </head>
  <body>
    <!-- El submit manejado en form.js -->
    <form id="login" >      
      <div >
        <label for="usern" >username:</label>
        <input type="text" name="usern" id="usern" > 
      </div>
      
      <div>
        <label for="pass" >password:</label>
        <input type="password" id="pass" name="pass" >
      </div>

      <div>
          <button id="Cancel">  <a href='/Biblio'>Cancelar </a>   </button>
          <button id="Acceder">  Acceder     </button>
      </div>
    </form>
  </body>
</html>
