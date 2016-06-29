CREATE DATABASE biblioteca;
\c biblioteca
 DROP table autor      	CASCADE;
 DROP table ejemplares 	CASCADE;
 DROP table libro      	CASCADE;
 DROP table multa      	CASCADE;
 DROP table prestamo   	CASCADE;
 DROP table renovación 	CASCADE;
 DROP table rol        	CASCADE;
 DROP table usuario    	CASCADE;

begin;
CREATE TABLE libro(
        id varchar(11) PRIMARY KEY --isbn
       , titulo text NOT NULL
       , autor text NOT NULL
       , genero text
       , idioma text
       , año text NOT NULL
);

CREATE TABLE ejemplares(
       id SERIAL PRIMARY KEY 
       , id_libro varchar(11) not null references libro
);

CREATE TABLE usuario(
        username text PRIMARY KEY
       , nombre text NOT NULL
       , apellidoP text NOT NULL
       , apellidoM text NOT NULL DEFAULT ''
       , correo text NOT NULL
       , contraseña text NOT NULL
       , rol integer NOT NULL  --0 normal user, --1 adminsitrador
);


CREATE TABLE prestamo(
       id SERIAL PRIMARY KEY
       , id_usuario text NOT NULL references usuario(username)
       , id_ejemplar integer NOT NULL references ejemplares(id)
       , periodo daterange NOT NULL
       , EXCLUDE USING gist (id_ejemplar with =, periodo with &&)
);

CREATE TABLE renovación(
       id_prestamo integer references prestamo(id)
       , fecha_renovacion date NOT NULL
);

CREATE TABLE multa(
       id_prestamo integer references prestamo(id),
       pagada boolean NOT NULL DEFAULT FALSE
);

commit;

/*Determina si un usuario puede pedir prestados libros o no*/
/* Es decir, no tiene mas de un prestamo activo*/
/* y los pasados no tiene multas pendientes*/

-- TODO: verificar que el préstamo activo
-- no haya rebasado el límite de días permitidos.
create or replace function usuario_legal(v_id_usuario)
returns boolean
as $$
  WITH prestamos_activos as (
       	 	select * as activos
     	       	from prestamo
     	       	where id_usuario = v_id_usuario
	       	      and upper(periodo) = 'infinity'
	)
	, prestamos_pasados as (
       	 	select *
     	       	from prestamo
     	       	where id_usuario = v_id_usuario
	       	      and upper(periodo) <> 'infinity'
	)
	, multas_pendientes as (
	  	 select * as multas
		 from prestamos_pasados pp
		 join multas m on (m.id_prestamo = pp.id)
	)

select count(*) = 0 as multas
from multas_pendientes
UNION ALL
select count(*) < 2
from prestamos_activos
;
