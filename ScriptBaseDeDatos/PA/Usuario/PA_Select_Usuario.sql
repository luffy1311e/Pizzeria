#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_S_Usuario;

DELIMITER //
create procedure PA_S_Usuario(pID int, out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare cantidad_registros int;
	declare nombre_PA varchar(10) default '[PA_S_Usuario]';

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		rollback;
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Validamos la consulta
	set cantidad_registros = 0;

	if (pID < 0 or pID > 0) then
		select count(1) into cantidad_registros
		from Usuario
		where id = pID;

		if (cantidad_registros <= 0) then
			set msg_error = concat('No existe ningun registro con el id ', pID);
			leave bloquePrincipal;
		end if;
	end if;
	
	-- Ejecutamos la consulta
	select 	id,
			username,
			correo,
			nombre,
			apellido1,
			apellido2,
			rol,
			activo,
			cod_usr_crea,
			fec_creacion,
			cod_usr_modifica,
			fec_modificacion
	from Usuario
	where id = pID;
	
end; -- bloquePrincipal
//