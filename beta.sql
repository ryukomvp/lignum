-- CREATE TABLE cargo(
--   id_cargo serial not null PRIMARY KEY,
--   cargo varchar(30)
-- );

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
	afiliado boolean DEFAULT false not null,
	direccion_cliente varchar(250) not null,
	usuario_publico varchar(30) not null,
	clave varchar(2048) not null,
	acceso boolean DEFAULT true not null,
	
	CONSTRAINT dui_cliente_unique UNIQUE (dui_cliente),
	CONSTRAINT usuario_publico_unique UNIQUE (usuario_publico)
);

CREATE TABLE pedido(
	id_pedido serial not null PRIMARY KEY,
	codigo_pedido varchar(10) not null,
	descripcion_pedido varchar(120) not null,
	id_cliente int not null,
	id_estado_pedido  int not null,
	direccion_pedido varchar(250) not null,
	fecha date null,

	CONSTRAINT codigo_pedido_unique UNIQUE (codigo_pedido)
);

CREATE TABLE detalle_pedido(
	id_detalle_pedido serial not null PRIMARY KEY,
	id_pedido int not null,
	id_producto int not null,
	precio_producto float not null,
	cantidad int null -- en caso de llevar más de un producto puede especificar aqui
);

CREATE TABLE valoracion(
	id_valoracion serial not null PRIMARY KEY,
	puntaje int null,
	comentario varchar null,
	id_detalle_pedido int not null
	estado boolean DEFAULT true not null
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
	estado_producto boolean DEFAULT true not null,
	cantidad_existencias int not null,
	
	
	CONSTRAINT codigo_producto_unique UNIQUE (codigo_producto)
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

CREATE TABLE usuario_privado(
    id_usuario_privado serial not null PRIMARY KEY,
    nombre_empleado varchar(70) not null,
    apellido_empleado varchar(70) not null,
    dui_empleado varchar(10) not null,
    correo_empleado varchar(120) not null,
    telefono_empleado varchar(9) not null,

    usuario_privado varchar(30) not null,
    clave varchar(2048) not null,
	acceso boolean DEFAULT true not null,

    CONSTRAINT dui_empleado_unique UNIQUE (dui_empleado),
	CONSTRAINT usuario_privado_unique UNIQUE (usuario_privado)
);

CREATE TABLE inventario(
	id_inventario serial not null PRIMARY KEY,
	codigo_inventario varchar(10) not null,
	cantidad_entrada int not null,
	fecha_entrada date not null,
	id_proveedor int not null
)

ALTER TABLE cliente
ADD CONSTRAINT cliente_genero_fkey FOREIGN KEY (id_genero)
REFERENCES genero(id_genero);

ALTER TABLE producto
ADD CONSTRAINT categoria_producto_fkey FOREIGN KEY (id_categoria)
REFERENCES categoria(id_categoria);

ALTER TABLE producto
ADD CONSTRAINT proveedor_producto_fkey FOREIGN KEY (id_proveedor)
REFERENCES proveedor(id_proveedor);

ALTER TABLE producto
ADD CONSTRAINT material_producto_fkey FOREIGN KEY (id_tipo_material)
REFERENCES tipo_material(id_tipo_material);

ALTER TABLE valoracion
ADD CONSTRAINT pedido_valoracion_fkey FOREIGN KEY (id_detalle_pedido)
REFERENCES detalle_pedido(id_detalle_pedido);

ALTER TABLE inventario
ADD CONSTRAINT inventario_proveedor_fkey FOREIGN KEY(id_proveedor)
REFERENCES proveedor(id_proveedor)