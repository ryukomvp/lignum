CREATE TABLE cargo(
  id_cargo serial not null PRIMARY KEY,
  cargo varchar(30)
);

CREATE TABLE categoria(
	id_categoria serial not null PRIMARY KEY,
	categoria varchar(30)
);

CREATE TABLE estado_pedido(
  id_estado_pedido serial not null PRIMARY KEY,
  estado_pedido varchar(30)
);

CREATE TABLE genero(
  id_genero serial not null PRIMARY KEY,
  genero varchar(30)
);

CREATE TABLE tipo_material(
  id_tipo_material serial not null PRIMARY KEY,
  tipo_material varchar(30)
);

CREATE TABLE cliente(
	id_cliente serial not null PRIMARY KEY,
	nombre_cliente varchar(70) not null,
	apellido_cliente varchar(70) not null,
	foto varchar not null,
	dui_cliente varchar(10) null,
	correo_cliente varchar(120) not null,
	telefono_cliente varchar(9),
	id_genero int not null,
	afiliado boolean not null,
	direccion_cliente varchar(250) not null,
	usuario_publico varchar(30) not null,
	clave varchar(2048) not null,
	acceso boolean not null,
	
	CONSTRAINT dui_cliente UNIQUE (dui_cliente),
	CONSTRAINT usuario_publico UNIQUE (usuario_publico)
);

CREATE TABLE pedido(
	id_pedido serial not null PRIMARY KEY,
	codigo_pedido varchar(10) not null,
	descripcion_pedido varchar(120) not null,
	id_cliente int not null,
	id_estado_pedido  int not null,
	direccion_pedido varchar(250) not null,
	fecha date null,

	CONSTRAINT codigo_pedido UNIQUE (codigo_pedido)
);

CREATE TABLE detalle_pedido(
	id_detalle_pedido serial not null PRIMARY KEY,
	id_pedido int not null,
	id_producto int not null,
	precio_producto float not null,
	cantidad int null, -- en caso de llevar más de un producto puede especificar aqui
);

CREATE TABLE valoracion(
	id_valoracion serial not null PRIMARY KEY,
	puntaje int null,
	comentario varchar null,
	id_detalle_pedido int not null
	estado boolean NOT NULL,
);

CREATE TABLE producto(
	id_producto serial not null PRIMARY KEY,
	nombre_producto varchar(70) not null,
	foto varchar not null,
	descripcion_producto varchar(120) not null,
	precio_producto float not null,

	codigo_producto varchar(10) not null,
	dimensiones varchar(100) not null,
	id_categoria int not null,
	id_tipo_material int not null,
	id_proveedor int not null,
	id_estado_producto int not null,
	cantidad_existencias int not null,
	
	
	CONSTRAINT codigo_producto UNIQUE (codigo_producto)
);

CREATE TABLE imagen(
	id_imagen serial not null PRIMARY KEY,
	ruta varchar(2048) not null
);

CREATE TABLE proveedor(
	id_proveedor serial not null PRIMARY KEY,
	nombre_proveedor varchar(120) not null,
	direccion_proveedor varchar(256) not null,
	correo_proveedor varchar(120) not null,
	telefono_proveedor varchar(9) not null
);

ALTER TABLE valoracion
ADD CONSTRAINT pedido_valoracion_fkey FOREIGN KEY (id_detalle_pedido)
REFERENCES detalle_pedido(id_detalle_pedido);