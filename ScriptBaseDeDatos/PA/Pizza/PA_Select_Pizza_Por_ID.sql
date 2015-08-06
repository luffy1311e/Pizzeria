#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_S_Pizza_Por_ID;

DElIMITER //
create procedure PA_S_Pizza_Por_ID(pID varchar(6), out msg_error varchar(100))

bloquePrincipal:
begin

	-- Declaracion de variables locales
	declare nombre_PA varchar(30) default '[PA_S_Pizza_Por_ID]';
    declare cantidad_registros int;
    
    -- Declaracion del handler para el manejo de excepciones
    declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
        leave handler_exception;
    end;
    
    -- Validamos la consulta
    set cantidad_registros = 0;
    
    select count(id) into cantidad_registros
    from Pizza
    where id = pID;
    
    if (cantidad_registros <= 0) then
		set msg_error = concat('No existe ningun ingrediente con el id ', pID);
		leave bloquePrincipal;
	end if;
    
    -- Ejecutamos la consulta
    select id,
		   descripcion,
           queso,
           activo,
           cod_usr_crea,
           fec_creacion,
           cod_usr_modifica,
           fec_modificacion
	from pizza
    where id = pID;

end; -- Bloque Principal
//