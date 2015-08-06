#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_U_Ingrediente;

DELIMITER //
create procedure PA_U_Ingrediente(
	pId varchar(6),
	pDescripcion varchar(50),
	pCosto_adicional decimal,
	pTipo_ingrediente varchar(3),
	pActivo tinyint,
	pCod_usr_modifica int,
	pFec_modificacion datetime, 
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(20) default '[PA_U_Ingrediente]';
	declare cantidad_registros int;
	declare error_sql int;
	declare v_consecutivo int(3);
	declare id_ingrediente varchar(6);

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
	from Ingrediente
	where descripcion = pDescripcion
	and id <> pId;

	if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe un ingrediente ', pDescripcion, '.');
		leave bloquePrincipal;
	end if;

	-- Verificar el tipo ingrediente
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from TipoIngrediente
	where id = pTipo_ingrediente;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe el tipo de ingrediente.');
		leave bloquePrincipal;
	end if;

	-- Validar si se va a modificar el tipo de ingrediente
	set cantidad_registros = 0;
	
	select count(tipo_ingrediente) into cantidad_registros
	from Ingrediente
	where tipo_ingrediente = pTipo_ingrediente
	and id = pId;

	-- Cambio de tipo de ingrediente
	if (cantidad_registros = 0) then
		-- Obtener el nuevo codigo del ingrediente
		-- de la tabla CodigoIngrediente
		select consecutivo into v_consecutivo
		from CodigoIngrediente
		where tipo_ingrediente = pTipo_ingrediente;

		if (v_consecutivo <= 0) then
			set msg_error = concat('No se puede obtener el ID para el nuevo ingrediente.');
			leave bloquePrincipal;
		else
			set id_ingrediente = concat(pTipo_ingrediente, v_consecutivo);
			set v_consecutivo = v_consecutivo + 1;

			update CodigoIngrediente
			set consecutivo = v_consecutivo
			where tipo_ingrediente = pTipo_ingrediente;
		end if;
	else
		set id_ingrediente = pId;
	end if;

	-- Declaración de inicio de Transacción - @@autocommit = 0
	start transaction;

	-- Ejecutamos la actualizacion
	update Ingrediente
	set id = id_ingrediente,
	descripcion = pDescripcion,
	costo_adicional = pCosto_adicional,
	tipo_ingrediente = pTipo_ingrediente,
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