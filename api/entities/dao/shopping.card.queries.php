<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class ShoppingQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function startOrder()
    {
        $sql = 'SELECT id_pedido
                FROM pedido
                WHERE estado_pedido = 0 AND id_cliente = ?';
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedido(id_cliente)
                    VALUES((FROM cliente WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id_pedido = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

 // Método para agregar un producto al carrito de compras.
 public function createDetail()
 {
     // Se realiza una subconsulta para obtener el precio del producto.
     $sql = 'INSERT INTO detalle_pedido(id_producto, precio_producto, cantidad, id_pedido, fecha)
             VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?)';
     $params = array($this->producto, $this->producto, $this->cantidad, $this->id_pedido);
     return Database::executeRow($sql, $params);
 }

 // Método para obtener los productos que se encuentran en el carrito de compras.
 public function readOrderDetail()
 {
     $sql = 'SELECT id_detalle_pedido, nombre_producto, d.precio_producto, d.cantidad_producto
             FROM pedido a
             INNER JOIN detalle_pedido d USING(id_pedido) 
             INNER JOIN producto p USING(id_producto)
             WHERE id_pedido = ?';
     $params = array($this->id_pedido);
     return Database::getRows($sql, $params);
 }

 // Método para actualizar la cantidad de un producto agregado al carrito de compras.
 public function updateDetail()
 {
     $sql = 'UPDATE detalle_pedido
             SET cantidad= ?
             WHERE id_detalle_pedido = ? AND id_pedido = ?';
     $params = array($this->cantidad, $this->id_detalle, $_SESSION['id_pedido']);
     return Database::executeRow($sql, $params);
 }

 // Método para eliminar un producto que se encuentra en el carrito de compras.
 public function deleteDetail()
 {
     $sql = 'DELETE FROM detalle_pedido
             WHERE id_detalle_pedido = ? AND id_pedido = ?';
     $params = array($this->id_detalle, $_SESSION['id_pedido']);
     return Database::executeRow($sql, $params);
 }

 // Método para finalizar un pedido por parte del cliente.
 public function finishOrder()
    {
        // Se establece la zona horaria local para obtener la fecha del servidor.
        $date = date('Y-m-d');
        $this->estado = 1;
        $sql = 'UPDATE pedido
                SET id_estado_pedido = ?, fecha = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }
}
