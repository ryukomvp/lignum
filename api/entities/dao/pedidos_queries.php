<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido

class PedidosQueries{

//Operaciones SCRUD

public function searchOrder()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, nombre_cliente, estado_pedido FROM pedido INNER JOIN cliente USING(id_cliente) INNER JOIN estado_pedido USING(id_estado_pedido) WHERE codigo_pedido ILIKE ? or descripcion_pedido ILIKE ? ORDER BY id_producto';
    $params = array("%$value%", "%$value%");
    return Database::getRows($sql, $params);
}


public function createOrder()
{
    $sql = 'INSERT INTO pedido(codigo_pedido, descripcion_pedido, id_cliente, id_estado_pedido) VALUES(?, ?, ?, ?)';
    $params = array($this->codigo, $this->descripcion, $this->cliente, $this->estado);
    return Database::executeRow($sql, $params)
}

public function readAll()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, nombre_cliente, estado_pedido from pedido INNER JOIN cliente USING(id_cliente) INNER JOIN estado_pedido USING(id_estado_pedido) ORDER BY id_pedido';
    return Database::getRows($sql);
}

public function readOne()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, id_cliente, id_estado_pedido from pedido WHERE id_producto = ?';
    $params = array(this->id_pedido);
    return Database::getRows($sql, $params);
}

public function updateOrder()
{
    $sql = 'UPDATE pedido SET codigo_pedido = ?, descripcion_pedido = ?, id_cliente = ?, id_estado_pedido= ? WHERE id_pedido = ?';
    $params = array($this->codigo, $this->descripcion, $this->cliente, $this->estado);
    return Database::executeRows($sql, $params);
}

public function deleteOrder()
{
    $sql = 'DELETE FROM pedido WHERE id_pedido = ?';
    $params = array($this->id_pedido);
    return Database::executeRows($sql, $params);
}

}

?>