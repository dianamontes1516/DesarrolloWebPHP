-- Creación de la base de datos
create database escuela;

-- Conexión a la base recién creada
\c escuela;

-- si ya habían creado la base
-- y las tablas, las borramos.
drop table alumno	cascade;	
 drop table curso_alumno cascade;	
 drop table curso_profe cascade;	
 drop table curso cascade;	
 drop table persona	cascade;	
 drop table profesor	cascade;	
 drop table salon	cascade;	
 drop table salon_curso cascade;	
 drop table semestre	cascade;

-- Esquema de la base de datos
create table persona(
       id char(18) primary key,
       nombre text not null,
       a_paterno text not null,
       a_materno text not null default ''
);

create table semestre(
       id serial primary key,
       nombre_semestre char(6) not null unique
);

create table profesor(
       num_trabajador integer primary key,
       fecha_ingreso date not null,
       id_persona char(18) not null references persona -- Llave foranea
);

create table alumno(
       num_cuenta char(9) primary key,
       id_semestre integer not null references semestre, -- En el formato aaaa-[1|2]. Ej: 2002-1
       id_persona char(18) not null references persona       
);

create table curso(
      clave serial primary key,
      nombre_curso text not null
);

create table curso_profe(
       id serial primary key,
       id_semestre integer not null references semestre, 
       id_profesor integer not null references profesor,
       id_curso integer not null references curso
);

create table salon(
       id serial primary key,
       nombre_salon text not null unique
);

create table curso_alumno(
       id_curso_prof integer not null references curso_profe, 
       id_alumno char(9) not null references alumno,
       unique(id_curso_prof, id_alumno)
);

create table salon_curso(
       id_curso_prof integer not null references curso_profe,
       id_salon integer not null references salon,
       horario tsrange -- timestamp range
);

-- Para usar el ídice gist. Tiene que instalarse la extensión como
-- super usuario.
--create extension btree_gist;
alter table salon_curso
add constraint un_curso EXCLUDE USING gist (id_salon with =, horario with &&);

--------- Tuplas prueba -------------------------
-- Catálogos 
insert into semestre (nombre_semestre) values
('2017-1'),
('2016-2'),
('2016-1'),
('2015-2'),
('2015-1'),
('2014-2');

insert into curso(nombre_curso) values
('Animales 2'),
('Cálculo 1'),
('Cálculo 2'),
('Cálculo 3'),
('Cálculo 4'),
('Pensiones 1'),
('Animales 2'),
('Plantas 1'),
('Plantas 1');

insert into salon (nombre_salon)  values
('Aula Magna 1, Tlahuiz, Piso 2'),
('Aula 123, Edificio P, Piso 1'),
('Aula 212, Edificio P, Piso 2');

-- Función que llena las tablas con valores aleatorios.
create or replace function personas(poblacion int)
returns void AS $$
    DECLARE
	nombre text array[7] = '{Juan, Rosa,Karla,Jeanne
	       	    	       ,Ricardo, Victor, Luis}';
	apellidos text array[8] = '{López, Maya,Ricalde
		       		,Vallarta,Fuentes,Cervantes,Juárez}';
	llave int;
	v_curso int;
	v_alumno text;
    BEGIN
	
	FOR i IN 1..poblacion LOOP
	    -- Inserto tuplas de prueba en persona
	    insert into persona(id, nombre, a_paterno, a_materno) values
	    ('nomeseelcurp'||i, nombre[ceil(random()*7)],
	    apellidos[ceil(random()*7)],apellidos[ceil(random()*7)]);

	    IF random() < 0.25 THEN 
	       llave = floor(i*10000);
	       -- Inserto tuplas de prueba en profesor
	       -- La fecha de ingreso no es tan importante
	       insert into profesor(num_trabajador,fecha_ingreso,id_persona)
	       values
	       (llave,'2012-12-12','nomeseelcurp'||i);
	       
	       -- Inserto tuplas de prueba en curso_profe
	       insert into curso_profe(id_semestre,id_profesor,id_curso)
	       values
	       (ceil(random()*6),llave,ceil(random()*8)),
	       (ceil(random()*6),llave,ceil(random()*8)),
	       (ceil(random()*6),llave,ceil(random()*8));
	    ELSE 
	       -- Inserto tuplas de prueba en profesor
		insert into alumno(num_cuenta,id_semestre,id_persona)
	       values
	       (floor(i*10000),ceil(random()*6),'nomeseelcurp'||i);
	    END IF;
	END LOOP;
        FOR v_curso in SELECT id from curso_profe LOOP
	    	insert into salon_curso(id_curso_prof,id_salon)
		values
		(v_curso, ceil(random()*2));
	
        END LOOP;
        FOR v_alumno in SELECT num_cuenta from alumno LOOP
	    FOR i IN 1..ceil(random()*2) LOOP
	    	insert into curso_alumno(id_alumno,id_curso_prof)
		values
		(v_alumno
		, (select min(id)+(ceil(random()*(max(id)-min(id))))
		  from curso_profe));
           END LOOP;	
        END LOOP;
   END;
$$ language plpgsql;

--------------------
-- Puebas
begin;
-- Es posible haya que correr mas de una vez la consulta
-- ya que puede generar resultados repetidos que violen
-- las restricciones de las tablas
SELECT personas(6000); 
-- si hubo un error, rollback; y probar de nuevo
-- begin; SELECT personas(6000);
rollback;
-- si no hubo ningún error, continuar con las pruebas.

--Consultas:
-- 1. Consulta que devuelve el semestre 2015-2 y cada uno de sus cursos y salones.

-- Creación de la vista
create or replace view cursos_2015_2 AS 
select	
		s.nombre_salon,
		c.clave
	from (
       select cp.id, cp.id_semestre, cp.id_curso
       from curso_profe cp
       join semestre s on (s.id=cp.id_semestre)
       where s.nombre_semestre like '2015-2' ) as t1
join salon_curso sc on (t1.id = sc.id_curso_prof)
join salon s on (sc.id_salon=s.id)
join curso c on (c.clave = t1.id_curso);

-- Uso de la vista
select * from cursos_2015_2;

-- Borramos la vista
drop view cursos_2015_2;

-- Versión 2 para la consulta 1
-- Uso de CTE para la creación de vistas
create view v_2015_2 as 
WITH cursos_2015_2 as (
       select cp.id
       	      , cp.id_semestre
	      , cp.id_curso
       from curso_profe cp
       join semestre s on (s.id=cp.id_semestre)
       where s.nombre_semestre like '2015-2'     
       )
       , salones as (
       	 select *
	 from salon_curso sc
	 join salon s on (s.id = sc.id_salon) 
       )
select s.nombre_salon
       , c.id_curso
from cursos_2015_2 c
join salones s on (c.id = s.id_curso_prof);


rollback;


--- Vistas materializadas
CREATE MATERIALIZED VIEW salones AS
select nombre_salon from salon;

select * from salones;

insert into salon (nombre_salon)  values
('Aula 301, Yeliz, Piso 3');



-- 2. regresar lista de semestre, curso, profesir y alumno incrito
-- Dado un semestre determinado
create or replace function inscritos(v_semestre text)
returns  table(sems TEXT, curso text, profesor text, alumno text)
AS $$
   with cursos_semestre as (
   	 select *
         from curso_profe cp
         where id_semestre = ( -- todos los cursos de v_semestre
		        select id
			from semestre
			where nombre_semestre like v_semestre
			)
	)
	
   SELECT v_semestre as bla			
   	  , c.nombre_curso
	  , pe.nombre ||' '|| pe.a_paterno ||' '|| pe.a_materno as profesor
	  , pe1.nombre ||' '|| pe1.a_paterno ||' '|| pe1.a_materno as alumno
   from cursos_semestre cs
   join curso c on (c.clave = cs.id_curso)
   join profesor p on (cs.id_profesor = p.num_trabajador)
   join persona pe on (pe.id = p.id_persona)
   join curso_alumno ca on (ca.id_curso_prof = cs.id)
   join alumno a on (a.num_cuenta = ca.id_alumno)
   join persona pe1 on (pe1.id = a.id_persona)
$$ language sql;

SELECT * from inscritos('2016-2') order by curso, profesor;

rollback;
