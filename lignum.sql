CREATE TABLE categoria(
	id_categoria serial not null PRIMARY KEY,
	categoria varchar(30)
);

CREATE TYPE estado_pedido AS ENUM ('Anulado', 'Completado', 'En revisión', 'Pendiente');

CREATE TYPE genero AS ENUM ('Femenino', 'Masculino');

CREATE TABLE tipo_material(
  id_tipo_material serial not null PRIMARY KEY,
  tipo_material varchar(30)
);

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
	usuario_publico varchar(30) not null,
	clave varchar(2048) not null,
	acceso boolean DEFAULT true not null,
	
	-- CONSTRAINT dui_cliente_unique UNIQUE (dui_cliente),
	CONSTRAINT usuario_publico_unique UNIQUE (usuario_publico)
);

CREATE TABLE pedido(
	id_pedido serial not null PRIMARY KEY,
	codigo_pedido varchar(10) not null,
	descripcion_pedido varchar(120) not null,
	id_cliente int not null,
	estado_pedido estado_pedido DEFAULT 'Pendiente' not null,
	direccion_pedido varchar(250) null,
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
	id_detalle_pedido int not null,
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

    usuario_privado varchar(30) not null,
    clave varchar(2048) not null,
	acceso boolean DEFAULT true not null,

    -- CONSTRAINT dui_empleado_unique UNIQUE (dui_empleado),
	CONSTRAINT usuario_privado_unique UNIQUE (usuario_privado)
);

CREATE TABLE inventario(
	id_inventario serial not null PRIMARY KEY,
	codigo_inventario varchar(10) not null,
	cantidad_entrante int not null,
	fecha_entrada date not null,
	id_producto int not null,

	CONSTRAINT codigo_inventario_unique UNIQUE (codigo_inventario)
);

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
ADD CONSTRAINT inventario_producto_fkey FOREIGN KEY(id_producto)
REFERENCES producto(id_producto);

INSERT INTO categoria(categoria)
VALUES	('Cocina'),
		('Gamer'),
		('Jardin'),
		('Oficina'),
		('Sala de estar');

INSERT INTO tipo_material(tipo_material)
VALUES	('Aglomerado'),
		('Fibras de baja densidad'),
		('Fibras de densidad media'),
		('Fibras de alta densidad'),
		('Madera contrachapada'),
		('Virutas orientadas');

		
INSERT INTO cliente(nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, direccion_cliente, usuario_publico, clave)
VALUES  ('Robina', 'Bonniface' , 'foto', '55912790-1', 'rbonniface0@ifeng.com', '8566-9159', 'Femenino', '0 Westport Trail', 'rbonniface0', 'QdNQFar'),
        ('Judd', 'Drew' , 'foto', '90621783-8', 'jdrew1@ed.gov', '2412-7332', 'Masculino', '44 Messerschmidt Plaza', 'jdrew1', 'RXSxcTWyD'),
		('Gwyneth', 'Samsworth' , 'foto', '70274521-1', 'gsamsworth2@accuweather.com', '7283-1345', 'Femenino', '6 Schurz Hill', 'gsamsworth2', 'BL7U44'),
        ('Hillary', 'Alonso' , 'foto', '52279444-8', 'halonso3@privacy.gov.au', '2312-9120', 'Femenino', '423 Pierstorff Avenue', 'halonso3', '6GFPKMEfvX'),
		('Halli', 'Gorey' , 'foto', '85031034-4', 'hgorey4@wikia.com', '0213-4561', 'Masculino', '3 American Ash Circle', 'hgorey4', 'uFr4LUgmpr'),
		('Frank', 'Hemingway' , 'foto', '88887930-6', 'fhemingway@yandex.com.ru', '1213-1752', 'Femenino', '8 Columbus Drive', 'fhemingw5', 'BtGRnqy'),
		('Eddie', 'Low' , 'foto', '43667637-3', 'elow@eyesearch.com', '1979-2123', 'Femenino', '669 Pennsylvania Lane', 'elow6', 'cZNxps'),
		('Jim', 'Sorrel' , 'foto', '10539686-4', 'jsorrel@slideshare.net', '1427-2134', 'Femenino', '45 High Crossing Center', 'jsorrel7', 'Yqe9H8Bq7'),
		('Berton', 'Kivlin' , 'foto', '85080671-6', 'bkivlin@gmail.com', '4321-3456', 'Femenino', '67609 Dapin Park', 'bkivlin8', '2D1XPXYxHRc7'),
		('John', 'Garcia' , 'foto', '97442969-7', 'jgarcia@gmail.com', '1234-1234', 'Femenino', '02037 Montana Way', 'jgarcia9', 'SVutvhE5R');

INSERT INTO pedido(codigo_pedido, descripcion_pedido, id_cliente, fecha)
VALUES 	(1234567812, 'Mesa de centro de 9x9', 1, '2022-01-01'),
       	(9855723656, 'Mueble para televisor 14x10', 2, '2022-01-05'),
	   	(2463563234, 'Mesa de centro de 9x9', 3, '2022-01-10'),
	  	(6332452635, 'Mesa de centro de 9x9', 4, '2022-01-15'),
	   	(7656433577, 'Mesa de comedor de 20x15', 5, '2022-01-20'),
	   	(9876245785, 'Escritorio pequeño de 10x5', 6, '2022-01-25'),
	   	(3534635744, 'Escritorio de oficina de 10x15', 7, '2022-02-01'),
	   	(8954565353, 'Gavetero pequeño de 10x5', 8, '2022-02-05'),
	   	(7453546359, 'Mueble para televisor de 14x10', 9, '2022-02-10'),
	   	(7458769098, 'Mesa de centro de 9x9, Escritorio pequeño de 10x5, Mueble para televisor de 14x10', 9, '2022-12-15');

INSERT INTO detalle_pedido(id_pedido, id_producto, precio_producto, cantidad)
VALUES 	(1, 1, 95, 3),
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

INSERT INTO producto(nombre_producto, foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, cantidad_existencias)
VALUES 	('Mesa de centro', 'foto', 'Mesa pequeña de centro', 95.00, 'MC201AS2', '9x9', 5, 2, 1, 10),
       	('Mueble para televisor', 'foto', 'Mueble para televisor', 80.00, 'TVA2003P', '14x10', 5, 1, 1, 15),
	   	('Mesa de comedor', 'foto', 'Mesa grande para comedor', 125.00, 'PSAO0123', '20x15', 5, 1, 1, 0),
		('Escritorio pequeño', 'foto', 'Escritorio pequeño', 75.00, 'OSD1PO2S', '10x5', 5, 3, 1, 10),
	   	('Escritorio de oficina', 'foto', 'Escritorio de oficina', 100.00, 'ESC3IL12', '10x15', 4, 1, 1, 20),
	  	('Gavetero pequeño', 'foto', 'Gavetero pequeño', 75.00, 'LOS12XKA', '10x5', 5, 1, 1, 20),
	  	('Gavetero grande', 'foto', 'Gavetero grande', 85.00, 'OASD0123', '10x15', 5, 1, 1, 20),
	   	('Silla', 'foto', 'Silla de madera', 60.00, 'ASDF0032', '5x5', 5, 2, 1, 0),
	   	('Ropero', 'foto', 'Ropero de madera', 105.00, 'ALSJ0921', '20x20', 5, 1, 1, 10),
	   	('Escalera', 'foto', 'Escalera de madera', 50.00, 'LADD0451', '20x5', 5, 2, 1, 15);

INSERT INTO proveedor(nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor)
VALUES	('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
       	('McAllen Hardware Store', '81 Grove Avenue', 'mcallenhardware@support', '2134-0312');

INSERT INTO usuario_privado(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado, clave)
VALUES	('Daniel Alejandro', 'Hernández Figueroa', '06795006-2', 'daniel123hernandez15@gmail.com', '7053-7276', 'rookie', '$2y$10$23qci/810Kh1kXTSivFhEO4Lblnzjv4iPW3SzRaSNkIbmMe5cB6/G'),
		('Manya', 'Praundl', '20523865-6', 'mpraundl0@sphinn.com', '4925-3672', 'mpraundl0', '3hS1joaI6m'),
		('Quinta', 'Knotton', '15075023-8', 'qknotton1@gmpg.org', '1805-1272', 'qknotton1', '9xCz9g'),
		('Nanon', 'Stother', '03624448-7', 'nstother2@stanford.edu', '5675-9510', 'nstother2', '7Cn72Dql'),
		('Ina', 'Calles', '12969091-0', 'icalles3@altervista.org', '7252-8782', 'icalles3', 'NsOxG5'),
		('Roxine', 'Gravenall', '44228264-9', 'rgravenall4@123-reg.co.uk', '8422-9837', 'rgravenall4', 'PBzmOfrN'),
		('Bianka', 'Keers', '37418417-0', 'bkeers5@fda.gov', '6910-2694', 'bkeers5', 'snX0IowZ'),
		('Parrnell', 'Caress', '43023674-3', 'pcaress6@artisteer.com', '9787-7573', 'pcaress6','GJoEeWAVuaBE'),
		('Myranda', 'Dehmel', '60768877-6', 'mdehmel7@furl.net', '2877-1107', 'mdehmel7', 'ZqtgvSEnU'),
		('Rene', 'Stops', '13192485-7', 'rstops8@com.com', '1989-2425', 'rstops8', 'ThY1w0K');