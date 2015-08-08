#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_Factura;

DELIMITER //

CREATE PROCEDURE PA_I_Factura(
	PFecha datetime,
    pTotal decimal,
    pIvi decimal,
    pTipoPago int,
    out msg_error VARCHAR(100),
    out pId int)
    
bloquePrincipal:
BEGIN
     
	-- Declaración de variables locales
	declare nombre_PA varchar(15) default '[PA_I_Factura]';
	declare cantidad_registros int;
	declare error_sql int;
    
	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception
   
   -- Insertar en la tabla de Factura
	INSERT INTO Factura (fecha, total, ivi, tipopago, activo)
	VALUES (PFecha,pTotal, pIvi,pTipoPago);
    
    -- @@error_count Contiene la cantidad de errores ocurridos en la transacción
	set error_sql = (select @@error_count);
    
    -- Evaluar si hay errores o no se afectaron tuplas en la transacción
	-- La función ROW_COUNT() retorna la cantidad de filas afectadas en la última sentencia INSERT/UPDATE/DELETE ejecutada
	if (error_sql > 0 OR ROW_COUNT() <= 0) then
		rollback;
		set msg_error = CONCAT('Ocurrió un error al ejecutar el procedimiento ', nombre_PA, '. No se insertó el registro a la factura.');
	else
		select max(id) into pID
		from Pizza;
	end if;
    
end; -- bloquePrincipal
//