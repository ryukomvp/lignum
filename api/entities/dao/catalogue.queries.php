<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class CatalogueQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto INNER JOIN categoria USING(id_categoria)
                WHERE estado = true AND nombre_producto ILIKE ? OR descripcion_producto ILIKE ? OR categoria ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto INNER JOIN categoria USING(id_categoria)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readCatalogue()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto INNER JOIN categoria USING(id_categoria)
                WHERE estado = true
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto , descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readproductoCategoria()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto,  descripcion_producto, precio_producto
                FROM producto INNER JOIN categoria USING(id_categoria)
                WHERE id_categoria = ? AND estado = true
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
