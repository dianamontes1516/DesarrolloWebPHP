create database escuela;
\c escuela;

begin;
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
      clave text primary key,
      nombre_curso text not null
);

create table curso_profe(
       id serial primary key,
       id_semestre integer not null references semestre, 
       id_profesor integer not null references profesor,
       id_curso text not null references curso
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
       horario daterange
);

-- Para usar el ídice gist
create extension btree_gist;
alter table salon_curso
add constraint un_curso EXCLUDE USING gist (id_salon with =, horario with &&);

--------- Tuplas prueba
begin;
insert into semestre (nombre_semestre) values
('2017-1'),
('2016-2'),
('2016-1'),
('2015-2'),
('205-1'),
('2014-2');

insert into curso values
('0324','Animales 2'),
('2304','Cálculo 1'),
('1212','Cálculo 2'),
('5347','Cálculo 3'),
('0273','Cálculo 4'),
('1221','Pensiones 1'),
('3455','Animales 2'),
('0834','Plantas 1'),
('7324','Plantas 1');

insert into salon (nombre_salon)  values
('Aula Magna 1, Tlahuiz, Piso 2'),
('Aula 123, Edificio P, Piso 1'),
('Aula 212, Edificio P, Piso 2');



Consultas:
1. Consulta que devuelve el semestre 2015-1 y cada uno de sus cursos y salones.

DROP view cursos_2015_1;

create or replace view cursos_2015_1 AS 
select	
		s.nombre_salon,
		c.clave
	from (
       select cp.id, cp.id_semestre, cp.id_curso
       from curso_profe cp
       join semestre s on (s.id=cp.id_semestre)
       where s.nombre_semestre like '2015-1' ) as t1
join salon_curso sc on (t1.id = sc.id_curso_prof)
join salon s on (sc.id_salon=s.id)
join curso c on (c.clave = t1.id_curso)
;

CREATE MATERIALIZED VIEW salones AS
select nombre_salon from salon;

select * from salones;

insert into salon (nombre_salon)  values
('Aula 301, Yeliz, Piso 3');



1. Consulta que devuelve el semestre 2015-1 y cada uno de sus cursos y salones.

create view 2015_1 as 
WITH cursos_2015_1 as (
       select cp.id
       	      , cp.id_semestre
	      , cp.id_curso
       from curso_profe cp
       join semestre s on (s.id=cp.id_semestre)
       where s.nombre_semestre like '2015-1'     
       )
       , salones as (
       	 select *
	 from salon_curso sc
	 join salon s on (s.salon = sc.id_salon)
       )
select *
from curso_2015_1 c
join salones s (c.id = s.id)

;


CREATE OR REPLACE FUNCTION salones_cursos(semestre text)
 returns table (salon text,curso text ) as $$
select	s.nombre_salon,
		c.nombre_curso
	from (
       select cp.id, cp.id_semestre, cp.id_curso
       from curso_profe cp
       join semestre s on (s.id=cp.id_semestre)
       where s.nombre_semestre like semestre ) as t1
join salon_curso sc on (t1.id = sc.id_curso_prof)
join salon s on (sc.id_salon=s.id)
join curso c on (c.clave = t1.id_curso)

$$ language sql;

