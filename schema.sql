################################################
###                                          ###
###             BASE DE DATOS                ###
###                                          ###
################################################
create database if not exists tienda;
use tienda;

################################################
###                                          ###
###              TABLAS SIMPLES              ###
###                                          ###
################################################

create table tda_tbl_articulo(
	id_art int auto_increment not null,
    nombre_art varchar(60) not null,
    clave_art varchar(10) not null,
    precio_art float unsigned not null,
    descripcion_art varchar(200) default 'Sin comentarios',
    imagen_art varchar(100),
    
    primary key(id_art)
) engine = InnoDB;

create table tda_tbl_categoria(
	id_cat int auto_increment not null,
    nombre_cat varchar(60) not null,
    
    primary key(id_cat)
) engine = InnoDB;

create table tda_tbl_tipo(
	id_tip int auto_increment not null,
    nombre_tip varchar(60) not null,
    read_tip boolean default true not null,
    add_tip boolean default false not null,
    delete_tip boolean default false not null,
    edit_tip boolean default false not null,
    
    primary key(id_tip)
) engine = InnoDB;

create table tda_tbl_proveedor(
	id_pro int auto_increment not null,
    nombre_pro varchar(60) not null,
    direccion_pro varchar(200) not null,
    telefono_pro varchar(13) null,
    correo_pro varchar(120) null,
    
    primary key(id_pro)
) engine = InnoDB;

################################################
###                                          ###
###              TABLAS CON FK               ###
###                                          ###
################################################

create table tda_tbl_inventario(
	id_inv int auto_increment not null,
    nombre_inv varchar(60) not null,
    creacion_inv datetime not null,
    descripcion_inv varchar(200) default 'Sin comentarios',
    id_cat_inv int not null,
    
    primary key(id_inv),
    foreign key(id_cat_inv) references tda_tbl_categoria(id_cat)
) engine = InnoDB;

create table tda_tbl_usuario(
	id_usu int auto_increment not null,
    nombres_usu varchar(120) not null,
    apellidos_usu varchar(120) not null,
    usuario_usu varchar(60) not null,
    correo_usu varchar(200) not null,
    password_usu varchar(60) not null,
    foto_usu varchar(200) not null,
    id_tip_usu int not null,
    
    primary key(id_usu),
    foreign key(id_tip_usu) references tda_tbl_tipo(id_tip)
) engine = InnoDB;

create table tda_tbl_compra(
	id_com int auto_increment not null,
    fecha_hora_inicio_com datetime not null,
    fecha_hora_fin_com datetime null,
    total_com float unsigned null,
    id_usu_com int not null,
    
    primary key(id_com),
    foreign key(id_usu_com) references tda_tbl_usuario(id_usu)
) engine = InnoDB;

create table tda_tbl_venta(
	id_ven int auto_increment not null,
    fecha_hora_inicio_ven datetime not null,
    fecha_hora_fin_ven datetime null,
    total_ven float unsigned null,
    id_usu_ven int not null,
    
    primary key(id_ven),
    foreign key(id_usu_ven) references tda_tbl_usuario(id_usu)
) engine = InnoDB;

################################################
###                                          ###
###             TABLAS RELACION              ###
###                                          ###
################################################

create table tda_rel_inventario_articulo(
	id_rel_inv_art int auto_increment not null,
    cantidad_rel_inv_art int unsigned default 0 not null,
    id_inv_rel_inv_art int not null,
    id_art_rel_inv_art int not null,
    
    primary key(id_rel_inv_art),
    foreign key(id_inv_rel_inv_art) references tda_tbl_inventario(id_inv),
    foreign key(id_art_rel_inv_art) references tda_tbl_articulo(id_art)
) engine = InnoDB;

create table tda_rel_articulo_venta(
	id_rel_art_ven int auto_increment not null,
    cantidad_rel_art_ven int unsigned default 1 not null,
    id_art_rel_art_ven int not null,
    id_ven_rel_art_ven int not null,
    
    primary key(id_rel_art_ven),
    foreign key(id_art_rel_art_ven) references tda_tbl_articulo(id_art),
    foreign key(id_ven_rel_art_ven) references tda_tbl_venta(id_ven)
) engine = InnoDB;

create table tda_rel_articulo_compra(
	id_rel_art_com int auto_increment not null,
    cantidad_rel_art_com int unsigned default 1 not null,
    id_art_rel_art_com int not null,
    id_com_rel_art_com int not null,
    
    primary key(id_rel_art_com),
    foreign key(id_art_rel_art_com) references tda_tbl_articulo(id_art),
    foreign key(id_com_rel_art_com) references tda_tbl_compra(id_com)
) engine = InnoDB;


create table tda_rel_usuario_venta(
	id_rel_usu_ven int auto_increment not null,
    id_usu_rel_usu_ven int not null,
    id_ven_rel_usu_ven int not null,
    
    primary key(id_rel_usu_ven),
    foreign key(id_usu_rel_usu_ven) references tda_tbl_usuario(id_usu),
    foreign key(id_ven_rel_usu_ven) references tda_tbl_venta(id_ven)
) engine = InnoDB;

create table tda_rel_usuario_compra(
	id_rel_usu_com int auto_increment not null,
    id_usu_rel_usu_com int not null,
    id_com_rel_usu_com int not null,
    
    primary key(id_rel_usu_com),
    foreign key(id_usu_rel_usu_com) references tda_tbl_usuario(id_usu),
    foreign key(id_com_rel_usu_com) references tda_tbl_compra(id_com)
) engine = InnoDB;

create table tda_rel_proveedor_articulo(
	id_rel_pro_art int auto_increment not null,
    id_pro_rel_pro_art int not null,
    id_art_rel_pro_art int not null,
    
    primary key(id_rel_pro_art),
    foreign key(id_pro_rel_pro_art) references tda_tbl_proveedor(id_pro),
    foreign key(id_art_rel_pro_art) references tda_tbl_articulo(id_art)
) engine = InnoDB;

################################################
###                                          ###
###             DATOS DE INICIO              ###
###                                          ###
################################################

insert into tda_tbl_categoria (nombre_cat) values('Productos');
insert into tda_tbl_categoria (nombre_cat) values('Dulces');
insert into tda_tbl_categoria (nombre_cat) values('Mobiliario');
insert into tda_tbl_categoria (nombre_cat) values('Equipo');

insert into tda_tbl_tipo (nombre_tip, read_tip, add_tip, delete_tip, edit_tip) values ('admin', true, true, true, true);

insert into tda_tbl_usuario (
	nombres_usu, 
	apellidos_usu, 
    usuario_usu, 
    correo_usu, 
    password_usu, 
    foto_usu,
    id_tip_usu
) values (
	'hector', 
    'rubi', 
    'chip', 
    'hector21096@gmail.com', 
    md5('admin'), 
    '"../img/profile/acount.png"',
    1
);