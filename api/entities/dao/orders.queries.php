<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido

class OrderQueries{

//Operaciones SCRUD 

public function searchOrder($value)
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, nombre_cliente, estado_pedido FROM pedido INNER JOIN cliente USING(id_cliente) INNER JOIN estado_pedido USING(id_estado_pedido) WHERE codigo_pedido ILIKE ? or descripcion_pedido ILIKE ? ORDER BY id_producto';
    $params = array("%$value%", "%$value%");
    return Database::getRows($sql, $params);
}


public function createOrder()
{
    date_default_timezone_set('America/El_Salvador');
    $date = date('Y-m-d');
    $sql = 'INSERT INTO pedido(codigo_pedido, descripcion_pedido, id_cliente, id_estado_pedido, direccion_pedido, fecha) VALUES(?, ?, ?, ?, ?, ?)';
    $params = array($this->codigo, $this->descripcion, $this->cliente, $this->estado, $this->direccion, $this->fecha);
    return Database::executeRows($sql, $params);
}

public function readAll()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, nombre_cliente, estado_pedido, direccion_pedido, fecha from pedido INNER JOIN cliente USING(id_cliente) INNER JOIN estado_pedido USING(id_estado_pedido) ORDER BY id_pedido';
    return Database::getRows($sql);
}

public function readOne()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, id_cliente, id_estado_pedido, direccion_pedido, fecha from pedido WHERE id_producto = ?';
    $params = array($this->id_pedido);
    return Database::getRows($sql, $params);
}

public function updateOrder()
{
    $sql = 'UPDATE pedido SET codigo_pedido = ?, descripcion_pedido = ?, id_cliente = ?, id_estado_pedido = ? direccion_pedido = ?, fecha = ? WHERE id_pedido = ?';
    $params = array($this->codigo, $this->descripcion, $this->cliente, $this->estado);
    return Database::executeRows($sql, $params);
}

public function deleteOrder()
{
    $sql = 'DELETE FROM pedido WHERE id_pedido = ?';
    $params = array($this->id_pedido);
    return Database::executeRows($sql, $params);
}

// report
public function report()
{
    $sql = 'SELECT p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material, COUNT(d.id_producto) as cantidad
    FROM producto p
    INNER JOIN tipo_material t ON  p.id_tipo_material = t.id_tipo_material
    INNER JOIN detalle_pedido d ON p.id_producto = d.id_producto
    GROUP BY p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material';
    return Database::getRows($sql);
}

public function pedidosClientes()
{
   $sql = 'SELECT nombre_cliente, COUNT(id_pedido) cantidad FROM pedido INNER JOIN cliente USING(id_cliente) GROUP BY nombre_cliente ORDER BY cantidad DESC LIMIT 5';
   return Database::getRows($sql); 
}

}




?>