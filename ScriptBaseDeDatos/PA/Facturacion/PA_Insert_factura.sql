#============================================
# Creado por: Edgar Romero
# Email: edgarjromero@outlook.com
# Version 1.0
#============================================
use Pizzeria;

drop procedure if exists PA_I_Factura;

DELIMITER //

CREATE PROCEDURE PA_I_Factura(pNumeroFac int, PFecha datetime, total decimal, ivi decimal,  ptipoPago int,  INOUT pMensajeError VARCHAR(2000))
bloquePrincipal:
BEGIN
     
   -- Declaración de variables locales
   DECLARE vCantidad_Registros INT;
   DECLARE vError INT;
   DECLARE cNombre_Logica VARCHAR(30) DEFAULT 'Lógica [PA_I_Factura]';

   -- Declaración de bloque con Handler para manejo de SQLException
   DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
   Handler_SqlException:
   BEGIN
      ROLLBACK;
      SET pMensajeError = CONCAT('Ocurrió un error al ejecutar el procedimiento. ', cNombre_Logica);
	  LEAVE Handler_SqlException;
   END; 

   -- Declaración de inicio de Transacción - @@autocommit = 0
   START TRANSACTION;
   
   -- Asignaciones de valores a variables locales
   SET vCantidad_Registros = 0;
   SET pMensajeError = "";
   
   -- Insertar en la tabla de Factura
	INSERT INTO Factura (numerofac, fecha, total, ivi, tipopago, estado)
	VALUES (pNumeroFac,PFecha,total,ptipoPago,ivi,1);

	COMMIT;
end
//