#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_U_Usuario;

DELIMITER //
create procedure PA_U_Usuario(
	pID int,
	pUsername varchar(20),
	pCorreo varchar(50),
	pNombre varchar(20),
	pApellido1 varchar(20),
	pApellido2 varchar(20),
	pRol int,
	pActivo tinyint,
	pCod_usr_modifica int,
	pFec_modificacion datetime, 
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare cantidad_registros int;
	declare nombre_PA varchar(10) default '[PA_U_Usuario]';

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
	set msg_error = "";

	select count(1) into cantidad_registros
	from Usuario
	where id = pID;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe ningun registro con el id ', pID);
		leave bloquePrincipal;
	end if;
	
	-- Ejecutamos la actualizacion
	update Usuario
	set correo = pCorreo,
	nombre = pNombre,
	apellido1 = pApellido1,
	apellido2 = pApellido2,
	rol = pRol,
	activo = pActivo,
	cod_usr_modifica = pCod_usr_modifica,
	fec_modificacion = pFec_modificacion
	where id = pID;
	
end; -- bloquePrincipal
//