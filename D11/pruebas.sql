\c biblioteca

\dt
\d prestamo
\d usuario

create or replace function dias_prestamo(fin date, v_id_usuario text)
returns table (prestamo integer, id_usuario text, dias integer,
inicio date, fin date)
AS $$ 
     select id as prestamo
     	   , id_usuario 
     	   , fin - lower(periodo) as dias
	   , lower(periodo) as inicio
	   , fin
     from prestamo p 
     where upper(periodo) <> 'infinity'
     and id_usuario = v_id_usuario
$$ language sql
;

drop function dias_prestamo(date,text);

-- Es mejor devolver id_prestamo, id_usuario, dias a la fecha indicada
\d prestamo
\d multa
\dt
\d libro

-- Función auxiliar para cifrar
CREATE OR REPLACE FUNCTION sha256(v_text text) returns text AS $$
    SELECT encode(digest($1, 'sha256'), 'hex')
$$ LANGUAGE SQL STRICT IMMUTABLE;

-- Función que llena las tablas con valores aleatorios.
create or replace function usuarios(poblacion int)
returns void AS $$
    DECLARE
	nombre text array[7] = '{Juan, Rosa,Karla,Jeanne
	       	    	       ,Ricardo, Victor, Luis}';
	apellidos text array[8] = '{López, Maya,Ricalde
		       		,Vallarta,Fuentes,Cervantes,Juárez}';
    BEGIN

	FOR i IN 1..poblacion LOOP
	    -- Inserto tuplas de prueba en persona
	    insert into usuario(username, nombre, apellidop, apellidom
				,correo, contraseña, rol) values
	    ('fua'||i, nombre[ceil(random()*7)],
	    apellidos[ceil(random()*7)],apellidos[ceil(random()*7)]
	    ,'fua'||i||'@blabla.com',sha256('fua'||i), 0);

	END LOOP;
   END;
$$ language plpgsql;

create or replace function libros(poblacion int)
returns void AS $$
    DECLARE	
        id text;
	art text array[3] = '{El, La,Los}';
	sust text array[7] = '{Otros, Llano, Ballena
		            ,Libro,Cama,Suerte,Lado}';
	adj text array[6] = '{negro, triste,rojo
		       		,silencio,de la soledad, en llamas}';
	nombreA text array[13] = '{Juan, Gabriel, Elena, Stephen, Victoria
	       	    	       , Ricardo, Carlos, Paulo, Miguel, Herman
			       , Bertrand, Alan, Alejandro }';
	apellidosA text array[12] = '{Márquez, García, Rulfo, Vizcaíno 
		       		, King, Fuentes, Cervantes, Coelo, Hesse
				, Russell, Turing, Dumas}';
	genero text array[4] = '{terror, drama, Ciencias Ficción, comedia}';
	
    BEGIN

	FOR i IN 1..poblacion LOOP
	    -- Inserto tuplas de prueba en persona
	    id = random_string(11);
	    insert into libro(id, titulo, autor, genero,año) values
	    (id
	    , art[ceil(random()*3)] || ' ' || sust[ceil(random()*7)] || ' ' || adj[ceil(random()*6)]
	    , nombreA[ceil(random()*13)] || ' ' || apellidosA[ceil(random()*12)]
	    , genero[ceil(random()*4)]
	    ,'2012-12-21');

    	    FOR i IN 1..ceil(random()*5) LOOP
	    	insert into ejemplares(id_libro)
		values	(id);
           END LOOP;	

	END LOOP;
   END;
$$ language plpgsql;

\d ejemplares

create or replace function random_string(length integer) returns text as 
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;

select random_string(12);
--------------------
SELECT usuarios(20);
select * from usuario;
SELECT libros(20);
select * from libro;
select * from ejemplares;

\dt
\d libro
\d ejemplares
select *
from prestamo
where upper(periodo) = 'infinity';


-- detalles prestamo
--   nombre_usuario, id_usuario, fi, ff, id_ejemplar, libro, autor.

create or replace view detalles_prestamo as 
select p.id_usuario
     , lower(p.periodo) as inicio 
     , upper(p.periodo) as fin	   
from prestamo p
join ejemplares e on (p.id_ejemplar = e.id)
join 
join libro e on (p.id_ejemplar = e.id)

\d libro prestamo ejemplares



with renovaciones as (
     select count(fecha_renovacion) as renovaciones
     	    , id_prestamo
     from renovación
     group by id_prestamo
)
select p.id
      , lower(p.periodo) as inicio
      , upper(p.periodo) as fin
      , upper(p.periodo) - lower(p.periodo) as dias
      , r.renovaciones
from prestamo p
join multa m on (p.id = m.id_prestamo)
join renovaciones r on (r.id_prestamo = p.id)
where p.id_usuario = ''
      and not m.pagada

;



\dt
\d lib
\d renovación
\d prestamo
\d multa

with prestamos

select l.titulo
       , l.autor
       , count(e.id) as total
       , count(p.id) as prestamos
       , count(e.id) -count(p.id) as disponibles
from ejemplares e 
join libro l on (e.id_libro = l.id)
Left join prestamos_activos p on (e.id=p.id_ejemplar) 
group by l.id
;

\d usuario

create view prestamos_activos AS
select id
       , id_usuario
       , id_ejemplar
       , lower(periodo) as fecha_inicio 
from prestamo
where upper(periodo) = 'infinity'
;
drop view prestamos_activos;
\d prestamos_activos
