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

CREATE TABLE estado_pedido(
  id_estado_pedido serial not null PRIMARY KEY,
  estado_pedido varchar(30)
);

CREATE TABLE estado_producto(
  id_estado_producto serial not null PRIMARY KEY,
  estado_producto varchar(30)
);

CREATE TABLE estado_usuario(
  id_estado_usuario serial not null PRIMARY KEY,
  estado_usuario varchar(30)
);

CREATE TABLE genero(
  id_genero serial not null PRIMARY KEY,
  genero varchar(30)
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

	usuario_publico varchar(30) not null,
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

CREATE TABLE proveedor(
	id_proveedor serial not null PRIMARY KEY,
	nombre_proveedor varchar(120) not null,
	direccion_proveedor varchar(256) not null,
	correo_proveedor varchar(120) not null,
	telefono_proveedor varchar(9) not null
);

CREATE TABLE usuario_privado(
	id_usuario_privado serial not null PRIMARY KEY,
	usuario_privado varchar(30) not null,
	clave varchar(2048) not null,
	id_empleado int not null,
	id_tipo_usuario int not null,
	id_estado_usuario int not null
	
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

INSERT INTO estado_empleado(estado_empleado)
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
VALUES  ('Afiliado'),
		('Estandar');

INSERT INTO tipo_material(tipo_material)
VALUES	('Aglomerado'),
		('Madera contrachapada'),
		('Virutas orientadas');

INSERT INTO tipo_usuario(tipo_usuario)
VALUES	('root'), -- superusuario
		('Gerente'),
	    ('Empleado general'),
		('Cajero');

INSERT INTO cliente(nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, id_genero, id_tipo_cliente, usuario_publico, clave, id_estado_usuario)
VALUES  ('Robina', 'Bonniface' , 'foto', '76168-013', 'rbonniface0@ifeng.com', '8566-9159', 1, 1, 'rbonniface0', 'QdNQFar', 1),
        ('Judd', 'Drew' , 'foto', '23138-014', 'jdrew1@ed.gov', '2412-7332', 2, 1, 'jdrew1', 'RXSxcTWyD', 1),
		('Gwyneth', 'Samsworth' , 'foto', '09123-224', 'gsamsworth2@accuweather.com', '7283-1345', 1, 1, 'gsamsworth2', 'BL7U44', 1),
        ('Hillary', 'Alonso' , 'foto', '12122-312', 'halonso3@privacy.gov.au', '2312-9120', 2, 1, 'halonso3', '6GFPKMEfvX', 1),
		('Halli', 'Gorey' , 'foto', '72341-901', 'hgorey4@wikia.com', '0213-4561', 1, 1, 'hgorey4', 'uFr4LUgmpr', 1),
		('Frank', 'Hemingway' , 'foto', '23455-134', 'fhemingway@yandex.com.ru', '1213-1752', 2, 1, 'fhemingw5', 'BtGRnqy', 1),
		('Eddie', 'Low' , 'foto', '09213-661', 'elow@eyesearch.com', '1979-2123', 2, 1, 'elow6', 'cZNxps', 1),
		('Jim', 'Sorrel' , 'foto', '27031-309', 'jsorrel@slideshare.net', '1427-2134', 2, 1, 'jsorrel7', 'Yqe9H8Bq7', 1),
		('Berton', 'Kivlin' , 'foto', '21034-123', 'bkivlin@gmail.com', '4321-3456', 2, 1, 'bkivlin8', '2D1XPXYxHRc7', 1),
		('John', 'Garcia' , 'foto', '12453-121', 'jgarcia@gmail.com', '1234-1234', 2, 1, 'jgarcia9', 'SVutvhE5R', 1);
		
INSERT INTO empleado(nombre_empleado, apellido_empleado, foto, dui_empleado, nacimiento_empleado, correo_empleado, telefono_empleado, id_genero, id_cargo)
VALUES  ('Jerome', 'Fruchon' , 'foto', '56187-013', '11-02-1990', 'jfruchon@lignum.com', '8576-9123', 2, 1),
        ('Nevile', 'Byron' , 'foto', '12942-212', '23-06-1997', 'nbyron@lignum.com', '8213-9812', 2, 2),
		('Pammie', 'Hatt' , 'foto', '41234-233', '02-11-1989', 'pamhatt@lignum.com', '1456-9031', 1, 3),
		('Richard', 'Hawke' , 'foto', '44512-413', '11-08-1995', 'rhawke@lignum.com', '0912-9182', 2, 2),
		('Eric', 'Chamberlain' , 'foto', '54123-541', '01-05-1992', 'ericcham@lignum.com', '1236-4012', 2, 2),
		('Tobyn', 'Newart' , 'foto', '12345-012', '14-03-1997', 'tnewart@lignum.com', '8431-2212', 2, 2),
		('Trey', 'Pearl' , 'foto', '44214-110', '18-12-1990', 'tpearl@lignum.com' , '8339-7812', 2, 3),
		('Bobby', 'Maloney' , 'foto', '31417-003', '28-09-1993', 'bmaloney@lignum.com', '1234-4123', 2, 4),
		('Morty', 'Honeywood' , 'foto', '23347-053', '09-07-1993', 'mhoneywood0@lignum.com', '9102-0301', 2, 4),
		('Louis', 'McCoy' , 'foto', '12357-995', '27-03-1990', 'lmccoy@lignum.com', '3012-3312', 2, 5);
		
INSERT INTO proveedor(nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor)
VALUES ('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
       ('McAllen Hardware Store', '81 Grove Avenue', 'mcallenhardware@support', '2134-0312');
	   
INSERT INTO usuario_privado(usuario_privado, clave, id_empleado, id_tipo_usuario, id_estado_usuario)
VALUES ('jfuch', 'djaiAPS', 1, 2, 1),
       ('nbyron', 'Asdoq21', 2, 3, 1),
	   ('pamhatt', '21FWEp', 3, 3, 1),
	   ('rhawk', 'PkoAOP3', 4, 3, 1),
	   ('Echamb', 'KlSDa2', 5, 3, 1),
	   ('tobynew', 'DbO12sd', 6, 3, 1),
	   ('tpearl', 'IlOSD2', 7, 3, 1),
	   ('bmaloney', 'HSa123', 8, 4, 1),
	   ('mhoneywood', 'KjaVSA1', 9, 4, 1),
	   ('lmccoy', 'KLSo123', 10, 3, 2);

INSERT INTO producto(nomre_producto, foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, id_estado_producto, cantidad_existencias)
VALUES ('Mesa de centro', 'foto', 'Mesa pequeña de centro', 95.00, 'MC201AS2', '9x9', 5, 2, 1, 1, 10),
       ('Mueble para televisor', 'foto', 'Mueble para televisor', 80.00, 'TVA2003P', '14x10', 5, 1, 1, 1, 15),
	   ('Mesa de comedor', 'foto', 'Mesa grande para comedor', 125.00, 'PSAO0123', '20x15', 5, 1, 1, 2, 0),
	   ('Escritorio pequeño', 'foto', 'Escritorio pequeño', 75.00, 'OSD1PO2S', '10x5', 5, 3, 1, 1, 10),
	   ('Escritorio de oficina', 'foto', 'Escritorio de oficina', 100.00, 'ESC3IL12', '10x15', 4, 1, 1, 1, 20),
	   ('Gavetero pequeño', 'foto', 'Gavetero pequeño', 75.00, 'LOS12XKA', '10x5', 5, 1, 1, 1, 20),
	   ('Gavetero grande', 'foto', 'Gavetero grande', 85.00, 'OASD0123', '10x15', 5, 1, 1, 1, 20),
	   ('Silla', 'foto', 'Silla de madera', 60.00, 'ASDF0032', '5x5', 5, 2, 1, 2, 0),
	   ('Ropero', 'foto', 'Ropero de madera', 105.00, 'ALSJ0921', '20x20', 5, 1, 1, 1, 10),
	   ('Escalera', 'foto', 'Escalera de madera', 50.00, 'LADD0451', '20x5', 5, 2, 1, 1, 15);