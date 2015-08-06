#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_Pizza;

DELIMITER //
create procedure PA_I_Pizza(
	pdescripcion varchar(20),
	pQueso int,
	pActivo bit(1),
	pCod_usr_crea int,
	pFec_creacion datetime,
	out msg_error varchar(100),
	out pID int)

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(15) default '[PA_I_Pizza]';
	declare cantidad_registros int;
	declare error_sql int;

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Verificar la descripcion
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from Pizza
	where descripcion = pDescripcion;

	if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe una pizza ', pDescripcion, '.');
		leave bloquePrincipal;
	end if;

	insert into Pizza(descripcion, queso, activo, cod_usr_crea, fec_creacion) 
	values(pDescripcion, pQueso, pActivo, pCod_usr_crea, pFec_creacion);

	-- @@error_count Contiene la cantidad de errores ocurridos en la transacción
	set error_sql = (select @@error_count);
	
	-- Evaluar si hay errores o no se afectaron tuplas en la transacción
	-- La función ROW_COUNT() retorna la cantidad de filas afectadas en la última sentencia INSERT/UPDATE/DELETE ejecutada
	if (error_sql > 0 OR ROW_COUNT() <= 0) then
		rollback;
		set msg_error = CONCAT('Ocurrió un error al ejecutar el procedimiento ', nombre_PA, '. No se insertó el registro el ingrediente ', pDescripcion);
	else
		select max(id) into pID
		from Pizza;
	end if;
	
end; -- bloquePrincipal
//