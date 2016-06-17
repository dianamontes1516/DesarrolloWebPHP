-- CREACION de la base de datos
CREATE DATABASE registro;

-- Tabla usuario
CREATE TABLE usuario(
       id serial, -- Es una secuencia entera
       username text,
       password text,
       last_login date
);

-- Insersion de valores en la tabla usuario.
-- No es necesario poner el valor del id, ya que es una secuencia
-- y se aumenta automáticamente.
INSERT INTO usuario(username,password,last_login) VALUES
('user1', 'PASS1', CURRENT_DATE),
('user2','PASS2', '12-02-2012');

------------ Selección de datos ---------------
-- Devuelve todas las tupla.
SELECT * from usuario;
-- Devuelve todos los usuarios que
-- ingresaron después del '01-01-2013'
SELECT password
FROM usuario
WHERE last_login > '01-01-2013';

-- Borra todos los usuarios que
-- ingresaron después del '01-01-2013'
DELETE FROM usuario
WHERE last_login > '01-01-2013';
;

--------  Modificación de la tabla ---------------
ALTER TABLE usuario
ADD PRIMARY KEY (username);

ALTER TABLE usuario
ALTER password SET NOT NULL;

-------- Borrado de tablas ------------------
DROP table usuario;

------ Creación de tabla persona ---------------
CREATE TABLE persona(
       id char(18) primary key,
       nombre text,
       a_paterno text,
       a_materno text
);

ALTER TABLE persona
ALTER a_materno SET NOT NULL;

INSERT INTO persona(id, nombre, a_paterno) VALUES
('198kwmdwsadaskxijs','liz','madrigal');

-- Actualización de valores --------------------
UPDATE persona
SET a_materno = ''
WHERE id = '198kwmdwodkfkxijs';

---- Creación de la tabla alumno ---------------
CREATE TABLE alumno(
       cuenta char(9) primary key,
       semestre text,
       id_persona char(18), 
       FOREIGN KEY (id_persona) REFERENCES persona(id)
);

INSERT INTO alumno(cuenta, semestre, id_persona) VALUES
('83283818', '2012-1','198kwmdwsadaskxijs');

--- Agregar restricciones de columnas no nulas a
-- la tabla alumno
ALTER TABLE alumno
ALTER semestre SET NOT NULL,
ALTER id_persona SET NOT NULL;

\d alumno

CREATE TABLE profesor(
       num_trabajador integer primary key,
       fecha_ingreso date,
       id_persona char(18) REFERENCES persona
);

-- Borramos tabla profesor
drop table profesor;

INSERT INTO profesor VALUES
(223214,'12-12-2011','198kwmdwsadaskxijs');


---- Consultas para obtener el nombre de los alumnos.
SELECT *
FROM alumno as a
INNER JOIN persona as p ON (a.id_persona = p.id);


------ EJERCICIO ---------------------
-- Escribir consulta que devuelva a las personas que son
-- Profesores y alumnos.
-- HINT:  Revisar al operador IN (https://www.postgresql.org/docs/9.4/static/functions-subquery.html#FUNCTIONS-SUBQUERY-IN) (http://www.postgresqltutorial.com/postgresql-in/)
-- y el operador AND (https://www.postgresql.org/docs/9.5/static/tutorial-select.html)



