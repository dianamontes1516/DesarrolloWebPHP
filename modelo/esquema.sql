CREATE TABLE libro(
        isbn 
       , titulo
       , id_autor
       , id_genero
       , idioma
       , existencias
);

CREATE TABLE autor(
       id
       , nombre
);

CREATE TABLE usuario(
        username
       , nombre
       , apellidoP
       , apellidoM
       , correo
       , id_persona
       , contraseña
       , id_rol
);

CREATE TABLE rol(
       id
       , nombre
);

CREATE TABLE prestamo(
       id
       , id_usuario
       , id_libro
       , fecha_inicio
);

CREATE TABLE renovación(
       id_prestamo
);

CREATE TABLE entrega(
       id_prestamo,
       fecha_entrega       
);

¿Qué quiero guardar?

- Información de los libros
- Información de los autores
- Información de los usuarios
- Información de los préstamos
  - Cuando empezó
  - Si tuvo renovación
  - Fecha de entrega
- Si una multa ya fue pagada o no

Funciones:
	activo(id_prestamo): boolean
	multa(id_prestamo): 

