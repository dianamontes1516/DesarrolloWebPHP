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

CREATE TABLE persona(
       id
       , nombre
       , apellidoP
       , apellidoM
       , correo
);

CREATE TABLE usuario(
        username
       , id_persona
       , contraseña
);

CREATE TABLE rol(
       id
       , nombre
);

CREATE TABLE usurio_rol(
       id_usuario
       ,id_rol
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

