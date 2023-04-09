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

//Metodo para agregar un producto al carrito

public function createDetail()
{
    $sql = 'INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad, id_pedido) VALUES(?, (SELECT precio_producto FROM producto where id_producto = ?), ?, ?)';
    $params = array($this->producto, $this->producto, $this->cantidad, $this->id_pedido);
    return Database::executeRow($sql, $params)
}

//Metodo para obtener los productos en el carrito

public function ReadOrderDetail()
{
    $sql = "SELECT id_detalle_pedido, nombre_producto, detalle_pedido.precio_producto, detalle_pedido.cantidad FROM pedido INNER JOIN detalle_pedido USING(id_pedido) INNER JOIN producto USING(id_producto) WHERE id_pedido = ?";
    $params = array($this->id_pedido);
    return Database::getRows($sql, $params);
}

//Metodo para terminar/cerrar un pedido del lado del cliente

public function finishOrder()
{
    date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $this->estado = 1;
        $sql = 'UPDATE pedido
                SET id_estado_pedido = ?, fecha = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
}

// Método para actualizar la cantidad de un producto agregado al carrito de compras.
public function updateDetail()
{
    $sql = 'UPDATE detalle_pedido
            SET cantidad_producto = ?
            WHERE id_detalle = ? AND id_pedido = ?';
    $params = array($this->cantidad, $this->id_detalle, $_SESSION['id_pedido']);
    return Database::executeRow($sql, $params);
}

// Método para eliminar un producto que se encuentra en el carrito de compras.
public function deleteDetail()
{
    $sql = 'DELETE FROM detalle_pedido
            WHERE id_detalle = ? AND id_pedido = ?';
    $params = array($this->id_detalle, $_SESSION['id_pedido']);
    return Database::executeRow($sql, $params);
}

}

?>