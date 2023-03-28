CREATE TABLE cargo(
  id_cargo serial not null PRIMARY KEY,
  cargo varchar(20)
);

CREATE TABLE categoria(
	id_categoria serial not null PRIMARY KEY,
	categoria varchar(20)
);

CREATE TABLE estado_empleado(
  id_estado_empleado serial not null PRIMARY KEY,
  estado_empleado varchar(20)
);

CREATE TABLE estado_pedido(
  id_estado_pedido serial not null PRIMARY KEY,
  estado_pedido varchar(20)
);

CREATE TABLE estado_producto(
  id_estado_producto serial not null PRIMARY KEY,
  estado_producto varchar(20)
);

CREATE TABLE estado_usuario(
  id_estado_usuario serial not null PRIMARY KEY,
  estado_usuario varchar(20)
);

CREATE TABLE genero(
  id_genero serial not null PRIMARY KEY,
  genero varchar(20)
);

CREATE TABLE tipo_cliente(
  id_tipo_cliente serial not null PRIMARY KEY,
  tipo_cliente varchar(20)
);

CREATE TABLE tipo_material(
  id_tipo_material serial not null PRIMARY KEY,
  tipo_material varchar(20)
);

CREATE TABLE tipo_usuario(
  id_tipo_usuario serial not null PRIMARY KEY,
  tipo_usuario varchar(20)
);

CREATE TABLE proveedor(
	id_proveedor serial not null PRIMARY KEY,
	nombre_proveedor varchar(120) not null,
	direccion_proveedor varchar(256) not null,
	correo_proveedor varchar(120) not null,
	telefono_proveedor varchar(9) not null
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
	id_tipo_cliente int not null,

	usuario_publico varchar(20) not null,
	clave varchar(2048) not null,
	id_estado_usuario int not null,
	
	CONSTRAINT dui_cliente UNIQUE (dui_cliente),
	CONSTRAINT usuario_publico UNIQUE (usuario_publico)
);

CREATE TABLE empleado(
	id_empleado serial not null PRIMARY KEY,
	nombre_empleado varchar(70) not null,
	apellido_empleado varchar(70) not null,
	foto varchar not null,
	dui_empleado varchar(10) not null,
	nacimiento_empleado date not null,
	correo_empleado varchar(120) not null,
	telefono_empleado varchar(9),
	id_genero int not null,
	id_cargo int not null,
	
	CONSTRAINT dui_empleado UNIQUE (dui_empleado)
);

CREATE TABLE pedido(
	id_pedido serial not null PRIMARY KEY,
	codigo_pedido varchar(10) not null,
	descripcion_pedido varchar(120) not null,
	id_cliente int not null,
	id_estado_pedido  int not null,
	
	CONSTRAINT codigo_pedido UNIQUE (codigo_pedido)
);

CREATE TABLE detalle_pedido(
	id_detalle_pedido serial not null PRIMARY KEY,
	id_pedido int not null,
	id_producto int not null,
	precio_producto float not null,
	cantidad int null -- en caso de llevar más de un producto puede especificar aqui
);

CREATE TABLE producto(
	id_producto serial not null PRIMARY KEY,
	nomre_producto varchar(70) not null,
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

CREATE TABLE imagenes(
	id_imagen serial not null PRIMARY KEY,
	ruta_imagen varchar not null,
	id_producto int not null
)

CREATE TABLE usuario_privado(
	id_usuario_privado serial not null PRIMARY KEY,
	usuario_privado varchar(20) not null,
	clave varchar(2048) not null,
	id_empleado int not null,
	id_tipo_usuario int not null,
	id_estado_usuario int not null,
	
	CONSTRAINT usuario_privado UNIQUE (usuario_privado)
);

CREATE TABLE valoracion(
	id_valoracion serial not null PRIMARY KEY,
	puntaje int null,
	comentario varchar null,
	id_detalle_pedido int not null
);

ALTER TABLE cliente
ADD CONSTRAINT cliente_genero_fkey FOREIGN KEY (id_genero)
REFERENCES genero(id_genero);

ALTER TABLE cliente
ADD CONSTRAINT tipo_cliente_fkey FOREIGN KEY (id_tipo_cliente)
REFERENCES tipo_cliente(id_tipo_cliente);

ALTER TABLE cliente
ADD CONSTRAINT estado_usuario_fkey FOREIGN KEY (id_estado_usuario)
REFERENCES estado_usuario(id_estado_usuario);

ALTER TABLE empleado
ADD CONSTRAINT empleado_genero_fkey FOREIGN KEY (id_genero)
REFERENCES genero(id_genero);

ALTER TABLE empleado
ADD CONSTRAINT empleado_cargo_fkey FOREIGN KEY (id_cargo)
REFERENCES cargo(id_cargo);

ALTER TABLE pedido
ADD CONSTRAINT pedido_estado_fkey FOREIGN KEY (id_estado_pedido)
REFERENCES estado_pedido(id_estado_pedido);

ALTER TABLE detalle_pedido
ADD CONSTRAINT detalle_pedido_fkey FOREIGN KEY (id_pedido)
REFERENCES pedido(id_pedido);

ALTER TABLE detalle_pedido
ADD CONSTRAINT pedido_producto_fkey FOREIGN KEY (id_producto)
REFERENCES producto(id_producto);

ALTER TABLE valoracion
ADD CONSTRAINT pedido_valoracion_fkey FOREIGN KEY (id_detalle_pedido)
REFERENCES detalle_pedido(id_detalle_pedido);

ALTER TABLE producto
ADD CONSTRAINT categoria_producto_fkey FOREIGN KEY (id_categoria)
REFERENCES categoria(id_categoria);

ALTER TABLE producto
ADD CONSTRAINT proveedor_producto_fkey FOREIGN KEY (id_proveedor)
REFERENCES proveedor(id_proveedor);

ALTER TABLE producto
ADD CONSTRAINT material_producto_fkey FOREIGN KEY (id_tipo_material)
REFERENCES tipo_material(id_tipo_material);

ALTER TABLE imagenes
ADD CONSTRAINT imagen_producto_fkey FOREIGN KEY (id_producto)
REFERENCES producto(id_producto);

ALTER TABLE usuario_privado
ADD CONSTRAINT usuario_privado_empleado_fkey FOREIGN KEY (id_empleado)
REFERENCES empleado(id_empleado);

ALTER TABLE usuario_privado
ADD CONSTRAINT usuario_privado_tipo_fkey FOREIGN KEY (id_tipo_usuario)
REFERENCES tipo_usuario(id_tipo_usuario);

ALTER TABLE usuario_privado
ADD CONSTRAINT usuario_privado_estado_fkey FOREIGN KEY (id_estado_usuario)
REFERENCES estado_usuario(id_estado_usuario);

INSERT INTO cargo(cargo)
VALUES	('Gerente general'),
				('Asistente de gerencia'),
				('Carpinteria general'),
				('Mozo de almacén'),
				('Encargado de limpieza');

INSERT INTO categoria(categoria)
VALUES	('Cocina'),
				('Gamer'),
				('Jardin'),
				('Oficina'),
				('Sala de estar');

INSERT INTO estado_empleado(id_estado_empleado)
VALUES	('Activo'),
				('Inactivo'),
				('Incapacitado'),
				('Ausente justificado'),
				('Ausente sin motivo');

INSERT INTO estado_pedido(estado_pedido)
VALUES	('Anulado'),
				('Completado'),
				('En revisión'),
				('Procesando');
			
INSERT INTO estado_producto(estado_producto)
VALUES	('Inexistente'),
				('En existencia'),
				('En camino');

INSERT INTO estado_usuario(estado_usuario)
VALUES	('Inhabilitado'),
                ('Habilitado'),

INSERT INTO estado_producto(estado_producto)
VALUES	('En existencia'),
				('Agotado');

INSERT INTO estado_usuario(estado_usuario)
VALUES	('Activo'),
				('Inactivo'),
				('Bloqueado');

INSERT INTO genero(genero)
VALUES	('Femenino'),
				('Masculino');

INSERT INTO tipo_cliente(tipo_cliente)
VALUES	('Estandar'),
				('Afiliado');

INSERT INTO tipo_material(tipo_material)
VALUES	('Aglomerado'),
				('Madera contrachapada'),
				('Virutas orientadas');

INSERT INTO tipo_usuario(tipo_usuario)
VALUES	('root'), -- superusuario
				('Gerente'),
				('Empleado general'),
				('Cajero')



-- 3 consultas utilizando las claúsulas de join, order by, group by.


--  Producto mas pedido
    SELECT d.id_producto, p.nomre_producto, SUM (d.cantidad) as mayor_cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nomre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 1;

--  Producto menos pedido
	SELECT d.id_producto, p.nomre_producto, MIN (d.cantidad) as menor_cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nomre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 1;
	
-- Clientes con mayor cantidad de pedidos 
	
	SELECT c.id_cliente, c.nombre_cliente, SUM(d.cantidad) as Cliente_con_mas_pedidos
	FROM detalle_pedido d
	INNER JOIN pedido p ON d.id_pedido = p.id_pedido
	INNER JOIN cliente c ON p.id_cliente = c.id_cliente
	GROUP BY c.id_cliente, c.nombre_cliente
	ORDER BY MAX(d.cantidad);

-- 3 consultas parametrizadas por rango de fechas para generar reportes útiles para el rubro del proyecto.

--  Producto mas vendido de la semana 
    SELECT d.id_producto, p.nomre_producto, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nomre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 1;
	WHERE d.fecha BETWEEN '2022-01-01' AND '2022-01-07';
	
--  Producto mas vendido de el mes 	
	SELECT d.id_producto, p.nomre_producto, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nomre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 1;
	WHERE d.fecha BETWEEN '2022-01-01' AND '2022-02-01';
	
--  Producto mas vendido de el año
	SELECT d.id_producto, p.nomre_producto, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nomre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 1;
	WHERE d.fecha BETWEEN '2021-01-01' AND '2022-01-01';
	
-- valoraciones de el mes 
   SELECT v.puntaje, v.comentario, d.fecha
   FROM valoracion v, detalle_pedido d
   WHERE d.fecha BETWEEN '2022-01-01' AND '2022-02-01';