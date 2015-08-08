# ---------------------------------------------------------------
# Scripts de creación de objetos de la base de datos de Pizzeria
# Autor: Edgar Romero Caravaca
# Email: edgarjromero@outlook.com
# Fecha: Julio 2015
# ---------------------------------------------------------------

drop database if exists Pizzeria;

create database Pizzeria;

use Pizzeria;

#============================================
# Tabla para los roles de los usuarios
# 1. Administrador
# 2. Facturacion
#============================================
drop table if exists RolUsuario;

create table RolUsuario (
	id int not null,
	descripcion varchar(20) not null,
	activo tinyint(1) default 1,
	cod_usr_crea int null,
	fec_creacion datetime null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,  
	primary key(id)
) comment = 'Tabla para los tipos de usuarios';

#============================================
# Tabla para los usuarios
#============================================
drop table if exists Usuario;

create table Usuario (
	id int auto_increment not null,
	username varchar(20) not null,
	password1 varchar(100) not null,
	correo varchar(50) null,
	nombre varchar(20) not null,
	apellido1 varchar(20) not null,
	apellido2 varchar(20) not null,
	rol int null,
	activo tinyint(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,  
	primary key (id),
	unique key (username),
	unique key (correo),
	foreign key (rol) references RolUsuario(id)
) comment = 'Tabla para los usuarios';

#============================================
# Tabla para los tipos de ingredientes
# 1. Carne
# 2. Vegetal
# 3. Queso
#============================================
drop table if exists TipoIngrediente;

create table TipoIngrediente (
	id varchar(3) not null,
	descripcion varchar(50) not null,
	precio decimal not null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,  
	primary key (id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para los tipo de ingredientes';

#============================================
# Tabla para los codigos de los ingredientes
#============================================
drop table if exists CodigoIngrediente;

create table CodigoIngrediente(
	id int not null auto_increment,
	tipo_ingrediente varchar(3) not null,
	consecutivo int(3) not null,
	activo tinyint(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (tipo_ingrediente) references TipoIngrediente(id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)	
) comment = 'Tabla para almacenar los ultimos codigos de los ingrediente segun el tipo';

#============================================
# Tabla para los ingredientes
#============================================
drop table if exists Ingrediente;

create table Ingrediente (
	id varchar(6) not null,
	descripcion varchar(50) not null,
	costo_adicional decimal(8,2) null,
	tipo_ingrediente varchar(3) not null,
	activo tinyint(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (tipo_ingrediente) references TipoIngrediente(id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para los ingredientes';

#============================================
# Tabla para los tipos de bebidas
# NAT = Natural
# GAS = Gaseosa
#============================================
drop table if exists TipoBebida;

create table TipoBebida(
	id varchar(3) not null,
	descripcion varchar(15) not null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para los tipos de bebidas';

#============================================
# Tabla para las bebidas
#============================================
drop table if exists Bebida;

create table Bebida(
	id int auto_increment not null,
	descripcion varchar(20) not null,
	mililitros int(4) not null,
	precio decimal not null,
	cantidad int null,
	tipo_bebida varchar(3) not null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (tipo_bebida) references TipoBebida(id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para las bebidas';

#============================================
# Tabla para los tipos de pasta
# 1. Gruesa
# 2. Delgada
#============================================
drop table if exists TipoPasta;

create table TipoPasta (
	id int not null,
	descripcion varchar(50) not null,
	precio decimal(8,2) not null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para los tipos de pasta para la pizza';

#============================================
# Tabla para las pizzas
#============================================
drop table if exists Pizza;

create table Pizza (
	id int auto_increment not null,
	descripcion varchar(50) not null,
	queso int null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (id),
	foreign key (cod_usr_crea) references Usuario(id),
	foreign key (cod_usr_modifica) references Usuario(id)
) comment = 'Tabla para los pizzas';

#============================================
# Tabla para agregar ingredientes a las pizzas
#============================================
drop table if exists DetallePizza;

create table DetallePizza (
	pizza int not null,
	ingrediente varchar(6) not null,
	activo bit(1) default 1,
	cod_usr_crea int not null,
	fec_creacion datetime not null,
	cod_usr_modifica int null,
	fec_modificacion datetime null,
	primary key (pizza, ingrediente),
	foreign key (pizza) references Pizza (id),
	foreign key (ingrediente) references Ingrediente (id),
	foreign key (cod_usr_crea) references Usuario (id),
	foreign key (cod_usr_modifica) references Usuario (id)
) comment = 'Tabla para detalle de ingredientes para las pizzas';

#============================================
# Tabla para las Facturas
#============================================
drop table if exists Factura;

create table Factura(
	id int auto_increment not null,
    fecha datetime not null,
    total decimal not null,
    ivi decimal not null,
    tipoPago int,
    activo bit(1) default 1,
    cod_usr_crea int not null,
    fec_creacion datetime not null,
    primary key (id),
    foreign key (cod_usr_crea) references Usuario (id)
) comment = 'Tabla de Facturacion';

#============================================
# Tabla para agregar detalle a la Factura
#============================================
drop table if exists DetalleFatura;

create table DetalleFactura(
	factura int not null,
    pizza varchar(50) not null,
    bebida varchar(20) not null,
    activo bit(1) default 1,
    cod_usr_crea int not null,
    fec_creacion datetime not null,
    primary key (factura, pizza, bebida),
    foreign key (factura) references factura (id),
    foreign key (cod_usr_crea) references Usuario (id)
) comment = 'Tabla detalle Factura';