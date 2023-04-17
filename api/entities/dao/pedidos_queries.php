<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido y detalle pedido

class PedidosQueries{

//Se verifica si existe un pedido, si no es el caso se crea uno

public function startOrder()
{
    $sql = 'SELECT id_pedido FROM pedido WHERE estado_pedido = 1 AND id_cliente = ?';
    $params = array($_SESSION['id_cliente']);
    if($data = Database::getRow($sql, $params)){
        this->id_pedido = $data['id_pedido'];
        return true;
    }else{
        $sql = 'INSERT INTO pedido(direccion_pedido, id_cliente) VALUES((SELECT direccion_cliente from cliente WHERE id_cliente = ?), ?)';
        $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente'])
        if($this->id_pedido = Database::getLastRow($sql, $params)) {
            return true;
        }else{
            return false;
        }
    }
}

//Operaciones SCRUD

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