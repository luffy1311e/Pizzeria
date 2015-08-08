#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_DetalleFactura;

DELIMITER //
create procedure PA_I_DetalleFactura(
	pFactura int,
	pPizza varchar(50),
	pBebida varchar(20),
	pActivo bit(1),
	pCod_usr_crea int,
	pFec_creacion datetime,
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(20) default '[PA_I_DetalleFactura]';
	declare cantidad_registros int;
	declare error_sql int;
	declare descPizza varchar(50);

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Verificar si existe la factura
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(id) into cantidad_registros
	from Factura
	where id = pFactura;

	if (cantidad_registros <= 0) then
		set msg_error = concat('No existe la Factura en el Sistema.');
		leave bloquePrincipal;
	end if;

	-- Verificar que no exista la llave primaria en la tabla DetalleFactura
	set cantidad_registros = 0;
	set msg_error = '';
	
	select count(factura) into cantidad_registros
	from DetalleFactura
	where factura = pFactura and pizza = pPizza and bebida = pBebida;

	if (cantidad_registros > 0) then
		-- Nombre del detalle
		select descripcion into descPizza
		from Pizza
		where id = pPizza;
		
		set msg_error = concat('Ya existe La pizza ',  descPizza, ' en la factura.');
		leave bloquePrincipal;
	end if;

	-- Esto se realizara desde el leguaje de programacion
	-- Declaración de inicio de Transacción - @@autocommit = 0
	-- start transaction;
	
	insert into DetalleFatura(factura, pizza, bebida, activo, cod_usr_crea, fec_creacion) 
	values(pFactura, pPizza, pBebida, pActivo, pCod_usr_crea, pFec_creacion);
    
    -- @@error_count Contiene la cantidad de errores ocurridos en la transacción
	set error_sql = (select @@error_count);
	
	-- Evaluar si hay errores o no se afectaron tuplas en la transacción
	-- La función ROW_COUNT() retorna la cantidad de filas afectadas en la última sentencia INSERT/UPDATE/DELETE ejecutada
	if (error_sql > 0 OR ROW_COUNT() <= 0) then
		rollback;
		set msg_error = CONCAT('Ocurrió un error al ejecutar el procedimiento ', nombre_PA, '. No se insertó el detalle ', descPizza, ' en la factura.');
	end if;
	
end; -- bloquePrincipal
//
