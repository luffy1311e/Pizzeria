#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_U_DetallePizza;

DELIMITER //
create procedure PA_U_DetallePizza(
	pPizza int,
	pIngrediente varchar(6),
	pActivo bit(1),
	pCod_usr_crea int,
	pFec_creacion datetime,
	out msg_error varchar(100))
 
bloquePrincipal:
begin

	-- Declaracion de variables locales
    declare nombre_PA varchar(20) default '[PA_U_DetallePizza]';
    declare cantidad_registros int;
    declare error_sql int;
    
    -- Declaracion del handler para el manejo de excepciones
    declare exit handler for sqlexception, sqlwarning
    handler_exception:
    begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ' , nombre_PA);
        leave handler_exception;
	end; -- handler_exception:
    
    -- Verificar la descripcion
    set cantidad_registros = 0;
    set msg_error = '';
    
    select count(id) into cantidad_registros
    from pizza
    where descripcion = pDescripcion
    and id <> pID;
    
    if (cantidad_registros > 0) then
		set msg_error = concat('Ya existe una pizza' , pDescripcion, '.');
        leave bloquePrincipal;
	end if;
    
    -- Verificar el Detalle
    set cantidad_registros = 0;
    set msg_error = '';
    
    select count(pizza) into cantidad_registros
    from detallepizza
    where pizza = pID;
    
    if (cantidad_registros <= 0) then
		set msg_error = concat('Ya existe una pizza con ese Detalle.');
        leave bloquePrincipal;
	end if;
    
    -- Declaracion de inicio de Transaccion - @@autocommit = 0
    start transaction;
    
    -- Ejecutamos la actualizacion
    update detallepizza
    set id = pID,
    descripcion = pdescripcion,
    queso = pQueso,
    activo = pActivo,
    cod_usr_modifica = pCod_usr_modifica,
    fec_modificacion = pFec_modificacion
    where id = pId;
    
    -- @@error_count Contiene la cantidad de errores ocurridos en la transaccion
    set error_sql = (select @@error_count);
    
    -- Evaluar si hay errores o se afectaron tuplas en la transaccion
    -- La funcion ROW_COUNT() retorna la cantidad de filas afectadas en la ultima sentencias INSERT/UPDATE/DELETE ejecutada
    if (error_sql > 0 or row_count() <= 0) then
		rollback;
        set msg_error = concat('Ocurrio un error al ejecutar el procedimiento ', nombre_PA, ' No se inserto el registro de Pizza ', pDescripcion);
	else
		select max(id) into lID
        from pizza;
	end if;

end; -- bloquePrincipal
//