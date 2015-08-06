# ---------------------------------------------------------------
# Scripts de creación de insert de la base de datos de Pizzeria
# Autor: Edgar Romero Caravaca
# Email: edgarjromero@outlook.com
# Fecha: Julio 2015
# ---------------------------------------------------------------

use Pizzeria;

-- Usuario administrador
set @usuario = 1;

#============================================
# Tabla RolUsuario
# 1. Administrador
# 2. Facturacion
#============================================
insert into RolUsuario(id, descripcion)
values(1, 'Administrador'), (2, 'Facturador');

#============================================
# Tabla Usuario
#============================================
insert into Usuario(username, password1, correo, nombre, apellido1, apellido2, rol, cod_usr_crea, fec_creacion)
values
('adminDBA', 'e10adc3949ba59abbe56e057f20f883e', 'userDBA@pizzeria.com', 'Administrador DBA', '', '', 1, 1, now()),
('admin', 'e10adc3949ba59abbe56e057f20f883e', 'adminDBA@pizzeria.com', 'Administrador', '', '', 1, 1, now());


#============================================
# Tabla para los tipos de ingredientes
# 1. Carne
# 2. Vegetal
# 3. Queso
#============================================
insert into TipoIngrediente(id, descripcion, precio, cod_usr_crea, fec_creacion)
values('CAR', 'Carne', 100, @usuario, now()), ('VEG', 'Vegetal', 100, @usuario, now()), ('QUE', 'Queso', 100, @usuario, now());

#============================================
# Tabla para los codigos de los ingredientes
#============================================
insert into CodigoIngrediente(tipo_ingrediente, consecutivo, cod_usr_crea, fec_creacion)
values('CAR', 1, @usuario, now()), ('VEG', 1, @usuario, now()), ('QUE', 1, @usuario, now());

#============================================
# Tabla para los tipos de bebidas
# NAT = Natural
# GAS = Gaseosa
#============================================
insert into TipoBebida(id, descripcion, cod_usr_crea, fec_creacion)
values ('NAT', 'Natural', @usuario, now()), ('GAS', 'Gaseosa', @usuario, now());

#============================================
# Tabla para los tipos de pasta
# 1. Gruesa
# 2. Delgada
#============================================
insert into TipoPasta(id, descripcion, precio, cod_usr_crea, fec_creacion)
values(1, 'Pasta Gruesa', 6000, @usuario, now()), (2, 'Pasta Delgada', 4000, @usuario, now());