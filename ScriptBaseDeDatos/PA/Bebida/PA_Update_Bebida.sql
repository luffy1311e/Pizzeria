#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_U_Bebida;

DELIMITER //
create procedure PA_U_Bebida(
	pId int,
	pdescripcion varchar(20),
	pMililitros int(4),
	pPrecio decimal,
	pCantidad int,
	pTipo_bebida varchar(3),
	pActivo bit(1),
	pCod_usr_modifica int,
	pFec_modificacion datetime, 
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(15) default '[PA_U_Bebida]';
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
	from Bebida
	where descripcion = pDescripcion
	and id <> pId;

	if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe una bebida ', pDescripcion, '.');
		leave bloquePrincipal;
	end if;

	-- Verificar el tipo ingrediente
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from TipoBebida
	where id = pTipo_bebida;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe el tipo de bebida.');
		leave bloquePrincipal;
	end if;

	-- Declaración de inicio de Transacción - @@autocommit = 0
	start transaction;

	-- Ejecutamos la actualizacion
	update Bebida
	set descripcion = pDescripcion,
	mililitros = pMililitros,
	precio = pPrecio,
	cantidad = pCantidad,
	tipo_bebida = pTipo_bebida,
	activo = pActivo,
	cod_usr_modifica = pCod_usr_modifica,
	fec_modificacion = pFec_modificacion
	where id = pID;

	-- @@error_count Contiene la cantidad de errores ocurridos en la transacción
	set error_sql = (select @@error_count);
	
	-- Evaluar si hay errores o no se afectaron tuplas en la transacción
	-- La función ROW_COUNT() retorna la cantidad de filas afectadas en la última sentencia INSERT/UPDATE/DELETE ejecutada
	if (error_sql > 0 OR ROW_COUNT() <= 0) then
		rollback;
		SET msg_error = CONCAT('Ocurrió un error al ejecutar el procedimiento ', nombre_PA, '. No se insertó el registro el ingrediente ', pDescripcion);
	else
		commit;
	end if;
	
end; -- bloquePrincipal
//