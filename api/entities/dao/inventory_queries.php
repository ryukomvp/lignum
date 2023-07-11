<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class InventoryQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario_privado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado, acceso
                FROM inventario
                WHERE codigo_inventario ILIKE ?
                ORDER BY id_inventario';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO inventario(codigo_inventario, cantidad_entrante, fecha_entrada, id_producto)
                VALUES(?, ?, ?, ?)';
        $params = array($this->codigo_inventario, $this->cantidad_entrante, $this->fecha_entrada, $this->proveedor);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_inventario, codigo_inventario, cantidad_entrante, fecha_entrada, id_producto
                FROM inventario
                ORDER BY id_inventario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_inventario, codigo_inventario, cantidad_entrante, fecha_entrada, id_producto
                FROM inventario
                WHERE id_inventario = ?';
        $params = array($this->id_inventario);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE inventario 
                SET codigo_inventario = ?, cantidad_entrante = ?, fecha_entrada = ?, id_producto = ?
                WHERE id_inventario = ?';
        $params = array($this->nombre_empleado, $this->apellido_empleado, $this->dui_empleado, $this->correo_empleado, $this->id_inventario);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM inventario
                WHERE id_inventario = ?';
        $params = array($this->id_inventario);
        return Database::executeRow($sql, $params);
    }
}
