select * from persona
where id in (select id_persona from alumno)
and id in (select id_persona from profesor);
