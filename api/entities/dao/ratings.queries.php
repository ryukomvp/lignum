<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class RatingsQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT v.puntaje, v.comentario,  a.fecha, p.nombre_producto, c.nombre_cliente FROM cliente c
        INNER JOIN pedido d ON c.id_cliente = d.id_cliente
        INNER JOIN detalle_pedido a ON d.id_pedido = a.id_pedido
        INNER JOIN producto p ON a.id_producto = p.id_producto
        INNER JOIN valoracion v ON a.id_detalle_pedido = v.id_detalle_pedido
        WHERE p.nombre_producto ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO valoracion(puntaje, comentario, id_detalle_pedido)
                VALUES(?, ?, ?)';
        $params = array($this->puntaje, $this->comentario, $this->pedido);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT v.puntaje, v.comentario,  d.fecha, p.nombre_producto, c.nombre_cliente FROM valoracion v
                INNER JOIN detalle_pedido d ON v.id_detalle_pedido = d.id_detalle_pedido
                INNER JOIN pedido a ON d.id_pedido = a.id_pedido
                INNER JOIN cliente c ON a.id_cliente = c.id_cliente 
                INNER JOIN producto p ON d.id_producto = p.id_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
       $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
               FROM producto
               WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE valoracion
                SET  estado = ?
                WHERE id_valoracion = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    // public function deleteRow()
    // {
    //     $sql = 'DELETE FROM categoria
    //             WHERE id_categoria = ?';
    //     $params = array($this->id);
    //     return Database::executeRow($sql, $params);
    // }
}
