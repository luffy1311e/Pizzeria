#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_Login;

DELIMITER //
create procedure PA_Login(
	pUsername varchar(20), 
	pPassword varchar(100), 
	out msg_error varchar(100))

bloquePrincipal:
begin
	
	-- Declaración de variables locales
	declare nombre_PA varchar(10) default '[PA_Login]';
	declare cantidad_registros int;

	-- Declaracion del handler para el manejo de excepciones
	declare exit handler for sqlexception, sqlwarning
	handler_exception:
	begin
		set msg_error = concat('Ocurrio un error al ejecutar el procedimiento: ', nombre_PA);
		leave handler_exception;
	end; -- handler_exception

	-- Validamos la consulta
	set msg_error = '';
	set cantidad_registros = 0;

	select count(username) into cantidad_registros
	from Usuario
	where username = pUsername and password1 = pPassword and activo = 1;

	if (cantidad_registros = 0) then
		set msg_error = concat('Usuario o password incorrecto.');
		leave bloquePrincipal;
	end if;
	
end; -- bloquePrincipal
//