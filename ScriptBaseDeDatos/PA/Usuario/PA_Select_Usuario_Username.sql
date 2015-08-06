#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_S_Usuario_Username;

DELIMITER //
create procedure PA_S_Usuario_Username(pUsername varchar(20), out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(20) default '[PA_S_Usuario_Username]';
	declare cantidad_registros int;

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Validamos la consulta
	set msg_error = '';
	set cantidad_registros = 0;

	select count(username) into cantidad_registros
	from Usuario
	where username = pUsername;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe ningun registro con el username ', pUsername);
		leave bloquePrincipal;
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
	where username = pUsername;
	
end; -- bloquePrincipal
//