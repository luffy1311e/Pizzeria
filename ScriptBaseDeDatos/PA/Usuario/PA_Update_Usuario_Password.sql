#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_U_Usuario_Password;

DELIMITER //
create procedure PA_U_Usuario_Password(
	pID int,
	pPassword varchar(100),
	pCod_usr_modifica int,
	pFec_modificacion datetime, 
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare cantidad_registros int;
	declare nombre_PA varchar(10) default '[PA_U_Usuario_Password]';

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Validamos la consulta
	set cantidad_registros = 0;
	set msg_error = "";

	select count(id) into cantidad_registros
	from Usuario
	where id = pID;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe ningún registro con el id ', pID);
		leave bloquePrincipal;
	end if;
	
	-- Ejecutamos la actualizacion
	update Usuario
	set password1 = pPassword,
	cod_usr_modifica = pCod_usr_modifica,
	fec_modificacion = pFec_modificacion
	where id = pID;
	
end; -- bloquePrincipal
//