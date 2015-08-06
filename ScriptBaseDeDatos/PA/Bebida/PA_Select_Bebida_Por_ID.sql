#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_S_Bebida_Por_ID;

DELIMITER //
create procedure PA_S_Bebida_Por_ID(pID int, out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(20) default '[PA_S_Bebida_Por_ID]';
	declare cantidad_registros int;

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Validamos la consulta
	set cantidad_registros = 0;

	select count(id) into cantidad_registros
	from Bebida
	where id = pID;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe ninguna bebida con el id ', pID);
		leave bloquePrincipal;
	end if;
	
	-- Ejecutamos la consulta
	select 	id,
			descripcion,
			mililitros,
			precio,
			cantidad,
			tipo_bebida,
			activo,
			cod_usr_crea,
			fec_creacion,
			cod_usr_modifica,
			fec_modificacion
	from Bebida
	where id = pID;
	
end; -- bloquePrincipal
//