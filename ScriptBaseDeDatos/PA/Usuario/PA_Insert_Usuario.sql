#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_Usuario;

DELIMITER //
create procedure PA_I_Usuario(
	pUsername varchar(20),
	pPassword1 varchar(100),
	pCorreo varchar(50),
	pNombre varchar(20),
	pApellido1 varchar(20),
	pApellido2 varchar(20),
	pRol int,
	pActivo tinyint,
	pCod_usr_crea int,
	pFec_creacion datetime,
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare cantidad_registros int;
	declare error_sql int;
	declare nombre_PA varchar(20) default '[PA_I_Usuario]';

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Declaración de inicio de Transacción - @@autocommit = 0
	start transaction;

	-- Verificar el username
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(username) into cantidad_registros
	from Usuario
	where username = pUsername;

	if (cantidad_registros > 0) then
		set msg_error = concat('El usuario ', pUsername, ' ya existe.');
		leave bloquePrincipal;
	end if;

	-- Veriicar el correo
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(correo) into cantidad_registros
	from Usuario
	where correo = pCorreo;

	if (cantidad_registros > 0) then
		set msg_error = concat('El correo ', pCorreo, ' ya existe.');
		leave bloquePrincipal;
	end if;

	-- Verificar el rol
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from RolUsuario
	where id = pRol;

	if (cantidad_registros <= 0) then
		set msg_error = concat('Ha ocurrido un error, no se puede asignar el rol al usuario.');
		leave bloquePrincipal;
	end if;

	insert into Usuario(username, password1, correo, nombre, apellido1, apellido2, rol, activo, 
						cod_usr_crea, fec_creacion)
	values(pUsername, pPassword1, pCorreo, pNombre, pApellido1, pApellido2, pRol, pActivo, 
			pCod_usr_crea, pFec_creacion);

	-- @@error_count Contiene la cantidad de errores ocurridos en la transacción
	set error_sql = (select @@error_count);
	
	-- Evaluar si hay errores o no se afectaron tuplas en la transacción
	-- La función ROW_COUNT() retorna la cantidad de filas afectadas en la última sentencia INSERT/UPDATE/DELETE ejecutada
	if (error_sql > 0 OR ROW_COUNT() <= 0) then
		rollback;
		SET msg_error = CONCAT('Ocurrió un error al ejecutar el procedimiento ', nombre_PA, '. No se insertó el registro del usuario ', pUsername);   
	else
		commit;
	end if;
	
end; -- bloquePrincipal
//