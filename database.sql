 -- Database: lignum

-- DROP DATABASE IF EXISTS lignum;

-- CREATE DATABASE lignum
--     WITH
--     OWNER = postgres
--     ENCODING = 'UTF8'
--     LC_COLLATE = 'Spanish_Spain.1252'
--     LC_CTYPE = 'Spanish_Spain.1252'
--     TABLESPACE = pg_default
--     CONNECTION LIMIT = -1
--     IS_TEMPLATE = False;
	
CREATE TABLE cargo(
  id_cargo serial not null PRIMARY KEY,
  cargo varchar(30)
);

CREATE TABLE categoria(
	id_categoria serial not null PRIMARY KEY,
	categoria varchar(30)
);

CREATE TABLE estado_empleado(
  id_estado_empleado serial not null PRIMARY KEY,
  estado_empleado varchar(20)
);

CREATE TABLE estado_usuario(
  id_estado_usuario serial not null PRIMARY KEY,
  estado_usuario varchar(30)
);

CREATE TABLE tipo_cliente(
  id_tipo_cliente serial not null PRIMARY KEY,
  tipo_cliente varchar(30)
);

CREATE TABLE tipo_material(
  id_tipo_material serial not null PRIMARY KEY,
  tipo_material varchar(30)
);

CREATE TABLE tipo_usuario(
  id_tipo_usuario serial not null PRIMARY KEY,
  tipo_usuario varchar(30)
);

CREATE TYPE estado_pedido AS ENUM ('Anulado', 'Completado', 'En revisión', 'Pendiente');


CREATE TYPE genero AS ENUM ('Femenino','Masculino');

CREATE TABLE cliente(
	id_cliente serial not null PRIMARY KEY,
	nombre_cliente varchar(70) not null,
	apellido_cliente varchar(70) not null,
	foto varchar not null,
	dui_cliente varchar(10) null UNIQUE,
	correo_cliente varchar(120) not null,
	telefono_cliente varchar(9),
	genero genero not null,
	afiliado boolean DEFAULT false not null,
	direccion_cliente varchar(250) not null,

	usuario_publico varchar(30) not null UNIQUE,
	clave varchar(2048) not null,
	acceso boolean DEFAULT true not null
	
	-- CONSTRAINT dui_cliente_unique UNIQUE (dui_cliente),
	-- CONSTRAINT usuario_publico_unique UNIQUE (usuario_publico)
);

CREATE TABLE pedido(
	id_pedido serial not null PRIMARY KEY,
	codigo_pedido varchar(10) not null,
	descripcion_pedido varchar(120) not null,
	id_cliente int not null,
	estado_pedido estado_pedido DEFAULT 'Pendiente' not null,
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
	estado boolean DEFAULT true not null,
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
    dui_empleado varchar(10) not null UNIQUE,
    correo_empleado varchar(120) not null,
    telefono_empleado varchar(9) not null,
	genero genero not null,
	id_cargo int not null,

    usuario_privado varchar(30) not null UNIQUE,
    clave varchar(2048) not null,
	acceso boolean DEFAULT true not null

    -- CONSTRAINT dui_empleado_unique UNIQUE (dui_empleado),
	-- CONSTRAINT usuario_privado_unique UNIQUE (usuario_privado)
);

CREATE TABLE valoracion(
	id_valoracion serial not null PRIMARY KEY,
	puntaje int null,
	comentario varchar null,
	estado boolean DEFAULT true not null,
	id_detalle_pedido int not null
);

CREATE TABLE inventario(
	id_inventario serial not null PRIMARY KEY,
	codigo_inventario varchar(10) not null,
	cantidad_entrante int not null,
	fecha_entrada date not null,
	id_producto int not null,

	CONSTRAINT codigo_inventario_unique UNIQUE (codigo_inventario)
);

ALTER TABLE usuario_privado
ADD CONSTRAINT usuario_cargo_fkey FOREIGN KEY (id_cargo)
REFERENCES cargo(id_cargo);

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

INSERT INTO estado_empleado(estado_empleado)
VALUES	('Activo'),
		('Inactivo'),
		('Incapacitado'),
		('Ausente justificado'),
		('Ausente sin motivo');

INSERT INTO tipo_cliente(tipo_cliente)
VALUES  ('Estandar'),
		('Afiliado');

INSERT INTO tipo_material(tipo_material)
VALUES	('Aglomerado'),
		('Madera contrachapada'),
		('Virutas orientadas');

INSERT INTO tipo_usuario(tipo_usuario)
VALUES	('root'), -- superusuario
		('Gerente'),
	    ('Empleado general'),
		('Cajero');
	
INSERT INTO cliente(nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, afiliado, direccion, usuario_publico, clave, acceso)
VALUES  ('Robina', 'Bonniface' , 'foto', '76168-013', 'rbonniface0@ifeng.com', '8566-9159', 'Femenino', 1, 'rbonniface0', 'QdNQFar', 1),
        ('Judd', 'Drew' , 'foto', '23138-014', 'jdrew1@ed.gov', '2412-7332', 'Masculino', 1, 'jdrew1', 'RXSxcTWyD', 1),
		('Gwyneth', 'Samsworth' , 'foto', '09123-224', 'gsamsworth2@accuweather.com', '7283-1345', 'Femenino', 1, 'gsamsworth2', 'BL7U44', 1),
        ('Hillary', 'Alonso' , 'foto', '12122-312', 'halonso3@privacy.gov.au', '2312-9120', 'Masculino', 1, 'halonso3', '6GFPKMEfvX', 1),
		('Halli', 'Gorey' , 'foto', '72341-901', 'hgorey4@wikia.com', '0213-4561', 'Femenino', 1, 'hgorey4', 'uFr4LUgmpr', 1),
		('Frank', 'Hemingway' , 'foto', '23455-134', 'fhemingway@yandex.com.ru', '1213-1752', 'Masculino', 1, 'fhemingw5', 'BtGRnqy', 1),
		('Eddie', 'Low' , 'foto', '09213-661', 'elow@eyesearch.com', '1979-2123', 'Masculino', 1, 'elow6', 'cZNxps', 1),
		('Jim', 'Sorrel' , 'foto', '27031-309', 'jsorrel@slideshare.net', '1427-2134', 'Masculino', 1, 'jsorrel7', 'Yqe9H8Bq7', 1),
		('Berton', 'Kivlin' , 'foto', '21034-123', 'bkivlin@gmail.com', '4321-3456', 'Masculino', 1, 'bkivlin8', '2D1XPXYxHRc7', 1),
		('John', 'Garcia' , 'foto', '12453-121', 'jgarcia@gmail.com', '1234-1234', 'Masculino', 1, 'jgarcia9', 'SVutvhE5R', 1);	

INSERT INTO proveedor(nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor)
VALUES ('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
       ('McAllen Hardware Store', '81 Grove Avenue', 'mcallenhardware@support', '2134-0312');
	   
	   CREATE TABLE usuario_privado(
    id_usuario_privado serial not null PRIMARY KEY,
    nombre_empleado varchar(70) not null,
    apellido_empleado varchar(70) not null,
    dui_empleado varchar(10) not null UNIQUE,
    correo_empleado varchar(120) not null,
    telefono_empleado varchar(9) not null,
	genero genero not null,
	id_cargo int not null,

    usuario_privado varchar(30) not null UNIQUE,
    clave varchar(2048) not null,
	acceso boolean DEFAULT true not null

    -- CONSTRAINT dui_empleado_unique UNIQUE (dui_empleado),
	-- CONSTRAINT usuario_privado_unique UNIQUE (usuario_privado)
);
	   
	   
	   
INSERT INTO usuario_privado(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, genero, id_cargo, usuario_privado, clave, acceso)
VALUES ('jfuch', 'djaiAPS', 1, 1, 1),
       ('nbyron', 'Asdoq21', 2, 2, 1),
	   ('pamhatt', '21FWEp', 3, 2, 1),
	   ('rhawk', 'PkoAOP3', 4, 2, 1),
	   ('Echamb', 'KlSDa2', 5, 2, 1),
	   ('tobynew', 'DbO12sd', 6, 2, 1),
	   ('tpearl', 'IlOSD2', 7, 2, 1),
	   ('bmaloney', 'HSa123', 8, 3, 1),
	   ('mhoneywood', 'KjaVSA1', 9, 3, 1),
	   ('lmccoy', 'KLSo123', 10, 2, 2);

INSERT INTO producto(nombre_producto, foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias)
VALUES ('Mesa de centro', 'foto', 'Mesa pequeña de centro', 95.00, 'MC201AS2', '9x9', 5, 2, 1, 't', 10),
       ('Mueble para televisor', 'foto', 'Mueble para televisor', 80.00, 'TVA2003P', '14x10', 5, 1, 1, 't', 15),
	   ('Mesa de comedor', 'foto', 'Mesa grande para comedor', 125.00, 'PSAO0123', '20x15', 5, 1, 1, 'f', 0),
	   ('Escritorio pequeño', 'foto', 'Escritorio pequeño', 75.00, 'OSD1PO2S', '10x5', 5, 3, 1, 't', 10),
	   ('Escritorio de oficina', 'foto', 'Escritorio de oficina', 100.00, 'ESC3IL12', '10x15', 4, 1, 1, 't', 20),
	   ('Gavetero pequeño', 'foto', 'Gavetero pequeño', 75.00, 'LOS12XKA', '10x5', 5, 1, 1, 't', 20),
	   ('Gavetero grande', 'foto', 'Gavetero grande', 85.00, 'OASD0123', '10x15', 5, 1, 1, 't', 20),
	   ('Silla', 'foto', 'Silla de madera', 60.00, 'ASDF0032', '5x5', 5, 2, 1, 'f', 0),
	   ('Ropero', 'foto', 'Ropero de madera', 105.00, 'ALSJ0921', '20x20', 5, 1, 1, 't', 10),
	   ('Escalera', 'foto', 'Escalera de madera', 50.00, 'LADD0451', '20x5', 5, 2, 1, 'f', 15);

INSERT INTO pedido (codigo_pedido, descripcion_pedido, id_cliente, fecha, id_estado_pedido)
VALUES (1234567812, 'Mesa de centro de 9x9', 1, '2022-01-01', 'Pendiente'),
       (9855723656, 'Mueble para televisor 14x10', 2 , '2022-01-05', 'Pendiente'),
	   (2463563234, 'Mesa de centro de 9x9', 3 , '2022-01-10', 'Pendiente'),
	   (6332452635, 'Mesa de centro de 9x9', 4, '2022-01-10', 'Pendiente'),
	   (7656433577, 'Mesa de comedor de 20x15', 5 , '2022-01-15', 'Pendiente'),
	   (9876245785, 'Escritorio pequeño de 10x5', 6 , '2022-01-20', 'Pendiente'),
	   (3534635744, 'Escritorio de oficina de 10x15', 7 , '2022-01-25', 'Pendiente'),
	   (8954565353, 'Gavetero pequeño de 10x5', 8 , '2022-02-01', 'Pendiente'),
	   (7453546359, 'Mueble para televisor de 14x10', 9 , '2022-02-05', 'Pendiente'),
	   (7458769098, 'Mesa de centro de 9x9, Escritorio pequeño de 10x5, Mueble para televisor de 14x10', 9 , '2022-02-10', 'Pendiente');

INSERT INTO detalle_pedido (id_pedido, id_producto, precio_producto, cantidad)
VALUES (1, 1, 95, 3),
       (2, 2, 80, 1),
	   (3, 1, 95, 5),
	   (4, 1, 95, 2),
	   (5, 3, 125, 3),
	   (6, 4, 75, 3),
	   (7, 5, 100, 3),
	   (8, 6, 75, 3),
	   (9, 2, 80, 3),
	   (10, 1, 95, 3),
	   (10, 4, 95, 3),
       (10, 2, 95, 3);
	   
INSERT INTO valoracion(puntaje, comentario, id_detalle_pedido)
VALUES (5,'Esta super bonita la mesa de centro ', 1),
	   (4,'Esta bien el mueble es estable y esta seguro para mi TV', 2),
	   (3,'Esta super bonita la mesa de centro solo que no es simetrica', 3),
	   (2,'Esta super bonita la mesa de centro', 4),
	   (4,'Bonita la mesa de comedor', 5),
	   (5,'Bonito el escritorio me gusta por que es bastante minimalista', 6),
	   (5,'Me gusta por que tiene bastante espacio y puedo ordenar bien mis cables', 7),
	   (5,'Ta bonito', 8),
	   (3,'Esta raro no se como poner la tele', 9),
	   (5,'Todos los productos que he comprado ahi me gustan, me gustaria ver cosas nuevas en la tienda para seguir comprando', 10);
	   


-- punto 1	   
-- 3 consultas utilizando las claúsulas de join, order by, group by.


--  Producto mas pedido
    SELECT d.id_producto, p.nombre_producto, SUM (d.cantidad) as mayor_cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nombre_producto
	ORDER BY SUM(d.cantidad) DESC LIMIT 5;

--  Producto menos pedido
	SELECT d.id_producto, p.nombre_producto, SUM (d.cantidad) as menor_cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	GROUP BY d.id_producto, p.nombre_producto
	ORDER BY SUM(d.cantidad) ASC LIMIT 5;
	
-- Clientes con mayor cantidad de pedidos 
	
	SELECT c.id_cliente, c.nombre_cliente, SUM(d.cantidad) as Cantidad_pedidos
	FROM detalle_pedido d
	INNER JOIN pedido p ON d.id_pedido = p.id_pedido
	INNER JOIN cliente c ON p.id_cliente = c.id_cliente
	GROUP BY c.id_cliente, c.nombre_cliente
	ORDER BY SUM(d.cantidad) DESC LIMIT 5;


--Punto 2
--Procedimiento almacenado que agrega usuarios

CREATE PROCEDURE Insert_usuarios
(u_usuario_privado varchar(30),
u_clave varchar(2048),
u_id_empleado int,
u_id_tipo_usuario int,
u_id_estado_usuario int)
AS
$$
BEGIN
INSERT INTO usuario_privado(usuario_privado, clave, id_empleado, id_tipo_usuario, id_estado_usuario)
VALUES(u_usuario_privado, u_clave, u_id_empleado, u_id_tipo_usuario, u_id_estado_usuario);
END;
$$ LANGUAGE plpgsql;

CALL  Insert_usuarios ('user1','password',1,2,1);

--Punto 3
--Consulta para precio total en un pedido
SELECT precio_producto * cantidad FROM detalle_pedido; 

--Punto 4
--Consulta para filtros de productos
SELECT * FROM producto WHERE id_categoria NOT IN (1,3);

--Punto 5
--Consulta para determinar los productos con el mayor precio en el catalogo
SELECT MAX(precio_producto), nombre_producto, descripcion_producto FROM producto
GROUP BY nombre_producto, descripcion_producto, precio_producto
ORDER BY precio_producto DESC;

-- Punto 6
--consultas parametrizadas para generar reportes

-- Reporte para ver los datos de los empleados que tengan x tipo de usuario
SELECT 	a.id_empleado AS "ID Empleado",
        a.nombre_empleado AS "Nombres",
        a.apellido_empleado AS "Apellidos",
        a.dui_empleado AS "DUI",
        a.nacimiento_empleado AS "Fecha de nacimiento",
        a.correo_empleado AS "Correo",
        a.telefono_empleado AS "Telefono"
		FROM empleado a
		INNER JOIN usuario_privado b
		ON a.id_empleado = b.id_empleado
		WHERE b.id_tipo_usuario = 3
		ORDER BY a.apellido_empleado ASC

-- Reporte para ver los productos que se encuentren entre un rango de puntaje
SELECT 	a.id_producto AS "ID Producto",
        a.nombre_producto AS "Nombre",
        a.descripcion_producto AS "Descripción",
        a.precio_producto AS "Precio",
        a.codigo_producto AS "Codigo"
		FROM producto a
		INNER JOIN detalle_pedido b
		INNER JOIN valoracion c
		ON c.id_detalle_pedido = b.id_detalle_pedido ON b.id_producto = a.id_producto
		WHERE c.puntaje >= 3
		ORDER BY c.puntaje DESC

-- Reporte para ver el produto que mas se repite en los pedido
SELECT 	b.id_producto AS "ID Producto",
        b.nombre_producto AS "Nombre",
        b.descripcion_producto AS "Descripción",
        b.precio_producto AS "Precio",
        b.codigo_producto AS "Codigo",
        COUNT(a.id_producto) AS total FROM detalle_pedido a
		INNER JOIN producto b
		ON a.id_producto = b.id_producto
		GROUP BY b.id_producto
		ORDER BY total DESC

-- Reporte para ver a que proveedor perteneces los productos que mas se vender
SELECT 	c.id_proveedor AS "ID Proveedor",
        c.nombre_proveedor AS "Nombre",
        c.direccion_proveedor AS "Dirección",
        c.correo_proveedor AS "Correo",
        c.telefono_proveedor AS "Teléfono",
        COUNT(a.id_producto) AS total 
		FROM detalle_pedido a
		INNER JOIN producto b
		ON b.id_producto = a.id_producto
		INNER JOIN proveedor c
		ON b.id_proveedor = c.id_proveedor
		GROUP BY c.id_proveedor
		ORDER BY total DESC

-- Clientes con mas pedidos
SELECT 	a.id_cliente AS "ID Cliente",
		a.nombre_cliente AS "Nombres",
		a.apellido_cliente AS "Apellidos",
		a.dui_cliente AS "DUI",
		a.correo_cliente AS "Correo",
		a.telefono_cliente AS "Telefono",
		COUNT(b.id_cliente) AS total 
		FROM cliente a
		INNER JOIN pedido b
		ON a.id_cliente = b.id_cliente
		GROUP BY a.id_cliente
		ORDER BY total DESC

-- Punto 7
-- 3 consultas parametrizadas por rango de fechas para generar reportes útiles para el rubro del proyecto.

--  Producto mas vendido de la semana 
    SELECT d.id_producto, p.nombre_producto, d.fecha, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto	
	WHERE d.fecha  BETWEEN '2022-01-01' AND '2022-01-07'
	GROUP BY d.id_producto, p.nombre_producto, d.fecha
	ORDER BY SUM(d.cantidad) DESC;
	
-- 	SELECT d.id_producto, p.nombre_producto, d.fecha, SUM (d.cantidad) as cantidad
-- 	FROM detalle_pedido d  
-- 	INNER JOIN producto p ON  d.id_producto = p.id_producto	
-- 	WHERE d.fecha = current_date -7
-- 	GROUP BY d.id_producto, p.nombre_producto, d.fecha
-- 	ORDER BY SUM(d.cantidad) DESC;
	
--  Producto mas vendido de el mes 	
	SELECT d.id_producto, p.nombre_producto, d.fecha, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	WHERE d.fecha BETWEEN '2022-01-01' AND '2022-02-01'
	GROUP BY d.id_producto, p.nombre_producto, d.fecha
	ORDER BY d.fecha ASC LIMIT 10;
	
	SELECT*FROM detalle_pedido;
	
--  Productos mas vendido de el año
	SELECT d.id_producto, p.nombre_producto, d.fecha, SUM (d.cantidad) as cantidad
	FROM detalle_pedido d  
	INNER JOIN producto p ON  d.id_producto = p.id_producto
	WHERE d.fecha BETWEEN '2022-01-01' AND '2023-01-01'
	GROUP BY d.id_producto, p.nombre_producto, d.fecha
	ORDER BY d.fecha ASC LIMIT 10;
	
-- valoraciones de el mes 
   SELECT v.puntaje, v.comentario, d.fecha, p.nombre_producto
   FROM valoracion v
   INNER JOIN detalle_pedido d ON  d.id_detalle_pedido = v.id_detalle_pedido
   INNER JOIN producto p ON p.id_producto = d.id_producto
   WHERE d.fecha BETWEEN '2022-01-01' AND '2022-02-01'
   GROUP BY v.puntaje, v.comentario, d.fecha, p.nombre_producto
   ORDER BY d.fecha DESC;


-- Sentencias INSERT, UPDATE , DELETE

--Daniel
INSERT INTO valoracion(puntaje, comentario, id_detalle_pedido)
VALUES (4, 'Muy bonito', 1),
(2, 'Puede mejorar', 2);

-- Kevin 
UPDATE producto p 
SET id_categoria = 2 
FROM detalle_pedido d
WHERE p.id_producto = d.id_producto 
AND id_tipo_material = 1 AND id_estado_producto = 1;
-- Alec
DELETE producto p
FROM detalle_pedido d
JOIN detalle_pedido ON p.id_producto = d.id_producto 
WHERE precio_producto > 90;


DELETE FROM producto p
USING detalle_pedido d
WHERE p.id_producto=d.id_producto and precio_producto > 90;