CREATE TABLE categoria(
	id_categoria serial not null PRIMARY KEY,
	categoria varchar(30) not null,
	descripcion varchar(128) not null,
	foto varchar not null
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

	usuario_publico varchar(30) not null UNIQUE,
	clave varchar(2048) not null,
	acceso boolean DEFAULT true not null
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

	codigo_producto varchar(10) not null UNIQUE,
	dimensiones varchar(100) not null,
	id_categoria int not null,
	id_tipo_material int not null,
	id_proveedor int not null,
	estado boolean DEFAULT true not null,
	cantidad_existencias int not null
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

    usuario_privado varchar(30) not null UNIQUE,
    clave varchar(2048) not null,
	acceso boolean DEFAULT true not null
);

CREATE TABLE inventario(
	id_inventario serial not null PRIMARY KEY,
	codigo_inventario varchar(10) not null UNIQUE,
	cantidad_entrante int not null,
	fecha_entrada date not null,
	id_producto int not null
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

ALTER TABLE detalle_pedido
ADD CONSTRAINT detalle_producto_fkey FOREIGN KEY (id_producto)
REFERENCES producto(id_producto);

ALTER TABLE valoracion
ADD CONSTRAINT pedido_valoracion_fkey FOREIGN KEY (id_detalle_pedido)
REFERENCES detalle_pedido(id_detalle_pedido);

ALTER TABLE inventario
ADD CONSTRAINT inventario_producto_fkey FOREIGN KEY(id_producto)
REFERENCES producto(id_producto);

TRUNCATE categoria RESTART IDENTITY;

INSERT INTO categoria(categoria, descripcion, foto)
VALUES	('Cocina', 'Muebles para cocina', '646bdd4f950c4.png'),
		('Gamer', 'Muebles para habitación', '646bdd4f950c4.png'),
		('Jardin', 'Muebles para jardin', '646bdd4f950c4.png'),
		('Oficina', 'Muebles para oficina', '646bdd4f950c4.png'),
		('Sala de estar', 'Muebles para sala de estar', '646bdd4f950c4.png');

TRUNCATE tipo_material RESTART IDENTITY;

INSERT INTO tipo_material(tipo_material)
VALUES	('Aglomerado'),
		('Fibras de baja densidad'),
		('Fibras de densidad media'),
		('Fibras de alta densidad'),
		('Madera contrachapada'),
		('Virutas orientadas');

TRUNCATE proveedor RESTART IDENTITY;

INSERT INTO proveedor(nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor)
VALUES	('Weston Logging Co.', '9355 Blackbird Way', 'westonlogging@contact', '0381-0101'),
		('Medhurst, Wunsch and Purdy', '804 Hoard Drive', 'mlange0@infoseek.co.jp', '2468-5067'),
		('Romaguera-Crona', '6102 Tennessee Center', 'bmcshirie1@homestead.com', '0206-1449'),
		('Borer and Sons', '8 Elmside Trail', 'ssainsburybrown2@jalbum.net', '5508-8170'),
		('Beahan, Franecki and Erdman', '33329 Dayton Center', 'cbernardon3@mayoclinic.com', '6617-7391'),
		('Quitzon LLC', '6 Chive Terrace', 'pkosel4@etsy.com', '5495-8077'),
		('Kihn-Kuhic', '81025 Bultman Trail', 'oshouler0@hhs.gov', '2941-7262'),
		('Auer and Sons', '51 Daystar Hill', 'tskittreal1@youku.com', '0124-7935'),
		('Beer, Beier and Bayer', '9 Gina Alley', 'nbilyard2@linkedin.com', '1558-5376'),
       	('McAllen Hardware Store', '81 Grove Avenue', 'mcallenhardware@support', '2134-0312');

TRUNCATE producto RESTART IDENTITY;

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

TRUNCATE pedido RESTART IDENTITY;

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

TRUNCATE detalle_pedido RESTART IDENTITY;

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

TRUNCATE usuario_privado RESTART IDENTITY;

INSERT INTO usuario_privado(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado, clave)
VALUES	('Daniel Alejandro', 'Hernández Figueroa', '06795006-2', 'daniel123hernandez15@gmail.com', '7053-7276', 'rookie', '$2y$10$YxzUkuwpSz7wyKRi42mpOu6MashaUYQQscPbp7UzScI.LviEy0ifW'),
		('Manya', 'Praundl', '20523865-6', 'mpraundl0@sphinn.com', '4925-3672', 'mpraundl0', '3hS1joaI6m'),
		('Quinta', 'Knotton', '15075023-8', 'qknotton1@gmpg.org', '1805-1272', 'qknotton1', '9xCz9g'),
		('Nanon', 'Stother', '03624448-7', 'nstother2@stanford.edu', '5675-9510', 'nstother2', '7Cn72Dql'),
		('Ina', 'Calles', '12969091-0', 'icalles3@altervista.org', '7252-8782', 'icalles3', 'NsOxG5'),
		('Roxine', 'Gravenall', '44228264-9', 'rgravenall4@123-reg.co.uk', '8422-9837', 'rgravenall4', 'PBzmOfrN'),
		('Bianka', 'Keers', '37418417-0', 'bkeers5@fda.gov', '6910-2694', 'bkeers5', 'snX0IowZ'),
		('Parrnell', 'Caress', '43023674-3', 'pcaress6@artisteer.com', '9787-7573', 'pcaress6','GJoEeWAVuaBE'),
		('Myranda', 'Dehmel', '60768877-6', 'mdehmel7@furl.net', '2877-1107', 'mdehmel7', 'ZqtgvSEnU'),
		('Rene', 'Stops', '13192485-7', 'rstops8@com.com', '1989-2425', 'rstops8', 'ThY1w0K');

TRUNCATE cliente RESTART IDENTITY;

INSERT INTO cliente(nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, direccion_cliente, usuario_publico, clave)
VALUES  ('Daniel Alejandro', 'Hernández Figueroa', 'foto', '55912790-1', 'daniel123hernandez15@gmail.com', '7053-7276', 'Masculino', '0 Westport Trail', 'rookie', '$2y$10$YxzUkuwpSz7wyKRi42mpOu6MashaUYQQscPbp7UzScI.LviEy0ifW'),
        ('Judd', 'Drew' , 'foto', '90621783-8', 'jdrew1@ed.gov', '2412-7332', 'Masculino', '44 Messerschmidt Plaza', 'jdrew1', 'RXSxcTWyD'),
		('Gwyneth', 'Samsworth' , 'foto', '70274521-1', 'gsamsworth2@accuweather.com', '7283-1345', 'Femenino', '6 Schurz Hill', 'gsamsworth2', 'BL7U44'),
        ('Hillary', 'Alonso' , 'foto', '52279444-8', 'halonso3@privacy.gov.au', '2312-9120', 'Femenino', '423 Pierstorff Avenue', 'halonso3', '6GFPKMEfvX'),
		('Halli', 'Gorey' , 'foto', '85031034-4', 'hgorey4@wikia.com', '0213-4561', 'Masculino', '3 American Ash Circle', 'hgorey4', 'uFr4LUgmpr'),
		('Frank', 'Hemingway' , 'foto', '88887930-6', 'fhemingway@yandex.com.ru', '1213-1752', 'Femenino', '8 Columbus Drive', 'fhemingw5', 'BtGRnqy'),
		('Eddie', 'Low' , 'foto', '43667637-3', 'elow@eyesearch.com', '1979-2123', 'Femenino', '669 Pennsylvania Lane', 'elow6', 'cZNxps'),
		('Jim', 'Sorrel' , 'foto', '10539686-4', 'jsorrel@slideshare.net', '1427-2134', 'Femenino', '45 High Crossing Center', 'jsorrel7', 'Yqe9H8Bq7'),
		('Berton', 'Kivlin' , 'foto', '85080671-6', 'bkivlin@gmail.com', '4321-3456', 'Femenino', '67609 Dapin Park', 'bkivlin8', '2D1XPXYxHRc7'),
		('John', 'Garcia' , 'foto', '97442969-7', 'jgarcia@gmail.com', '1234-1234', 'Femenino', '02037 Montana Way', 'jgarcia9', 'SVutvhE5R');

-- Actualizaciones para dar variedad a los tipos de materiales en los productos
UPDATE producto SET id_categoria = 1 WHERE id_producto % 2 = 0 AND id_producto < 5;
UPDATE producto SET id_categoria = 2 WHERE id_producto % 2 != 0 AND id_producto < 5;
UPDATE producto SET id_categoria = 3 WHERE id_producto = 5;
UPDATE producto SET id_categoria = 4 WHERE id_producto % 2 = 0 AND id_producto > 5;
UPDATE producto SET id_categoria = 5 WHERE id_producto % 2 != 0 AND id_producto > 5;
UPDATE producto SET id_categoria = 3 WHERE id_producto = 10;

-- Actualizaciones para dar variedad a los tipos de materiales en los productos
UPDATE producto SET id_tipo_material = 1 WHERE id_producto % 2 = 0 AND id_producto < 5;
UPDATE producto SET id_tipo_material = 2 WHERE id_producto % 2 != 0 AND id_producto < 5;
UPDATE producto SET id_tipo_material = 3 WHERE id_producto = 5;
UPDATE producto SET id_tipo_material = 4 WHERE id_producto % 2 = 0 AND id_producto > 5;
UPDATE producto SET id_tipo_material = 5 WHERE id_producto % 2 != 0 AND id_producto > 5;
UPDATE producto SET id_tipo_material = 6 WHERE id_producto = 10;

-- Actualizaciones para dar variedad a los proveedores
UPDATE producto SET id_proveedor = 1 WHERE id_producto = 1;
UPDATE producto SET id_proveedor = 2 WHERE id_producto = 2;
UPDATE producto SET id_proveedor = 3 WHERE id_producto = 3;
UPDATE producto SET id_proveedor = 4 WHERE id_producto = 4;
UPDATE producto SET id_proveedor = 5 WHERE id_producto = 5;
UPDATE producto SET id_proveedor = 6 WHERE id_producto = 6;
UPDATE producto SET id_proveedor = 7 WHERE id_producto = 7;
UPDATE producto SET id_proveedor = 8 WHERE id_producto = 8;
UPDATE producto SET id_proveedor = 9 WHERE id_producto = 9;
UPDATE producto SET id_proveedor = 10 WHERE id_producto = 10;

-- Actualizaciones para dar variedad a los accesos de los usuarios privados
UPDATE usuario_privado SET acceso = false WHERE id_usuario_privado % 2 = 0;
-- Actualizaciones para dar variedad a los accesos de los usuarios públicos
UPDATE cliente SET acceso = false WHERE id_cliente % 2 = 0;