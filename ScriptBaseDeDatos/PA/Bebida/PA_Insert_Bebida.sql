#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_Bebida;

DELIMITER //
create procedure PA_I_Bebida(
	pdescripcion varchar(20),
	pMililitros int(4),
	pPrecio decimal,
	pCantidad int,
	pTipo_bebida varchar(3),
	pActivo tinyint(1),
	pCod_usr_crea int,
	pFec_creacion datetime,
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(15) default '[PA_I_Bebida]';
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
	where descripcion = pDescripcion;

	if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe una bebida ', pDescripcion, '.');
		leave bloquePrincipal;
	end if;

	-- Verificar el tipo bebida
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from TipoBebida
	where id = pTipo_bebida;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe el tipo de bebida.');
		leave bloquePrincipal;
	end if;

	-- Verificar que no exista la bebida
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from Bebida
	where descripcion = pDescripcion;

	if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe una bebida con esa descripción .', pDescripcion);
		leave bloquePrincipal;
	end if;

	-- Declaración de inicio de Transacción - @@autocommit = 0
	start transaction;

	insert into Bebida(descripcion, mililitros, precio, cantidad, tipo_bebida, activo, cod_usr_crea, fec_creacion)
	values(pDescripcion, pMililitros, pPrecio, pCantidad, pTipo_bebida, pActivo, pCod_usr_crea, pFec_creacion);

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