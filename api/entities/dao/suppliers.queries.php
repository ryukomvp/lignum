<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class SupplierQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_proveedor, nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor
                FROM proveedor
                WHERE nombre_proveedor ILIKE ? OR correo_proveedor ILIKE ? OR telefono_proveedor ILIKE ?
                ORDER BY nombre_proveedor';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO proveedor(nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor)
                VALUES(?,?,?,?)';
        $params = array($this->nombre, $this->direccion, $this->correo, $this->telefono);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_proveedor, nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor
                FROM proveedor
                ORDER BY id_proveedor';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_proveedor, nombre_proveedor, direccion_proveedor, correo_proveedor, telefono_proveedor
                FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE proveedor
                SET  nombre_proveedor = ?, direccion_proveedor = ?, correo_proveedor = ?, telefono_proveedor = ?
                WHERE id_proveedor = ?';
        $params = array($this->nombre,  $this->direccion, $this->correo, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function report()
{
    $sql = 'SELECT p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material, COUNT(d.id_producto) as cantidad
    FROM producto p
    INNER JOIN tipo_material t ON  p.id_tipo_material = t.id_tipo_material
    INNER JOIN detalle_pedido d ON p.id_producto = d.id_producto
    GROUP BY p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material
    order by cantidad desc';
    return Database::getRows($sql);
}
}
