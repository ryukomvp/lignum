<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class CatalogueQueries
{
    /*metodo para buscar registros*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, p.foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto p INNER JOIN categoria c USING(id_categoria)
                WHERE estado = true AND (nombre_producto ILIKE ? OR descripcion_producto ILIKE ? OR categoria ILIKE ?)
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function readCatalogue()
    {
        $sql = 'SELECT id_producto, nombre_producto, p.foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto p INNER JOIN categoria c USING(id_categoria)
                WHERE estado = true
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readCategories()
    {
        $sql = 'SELECT id_producto, nombre_producto, p.foto,  descripcion_producto, precio_producto
                FROM producto p INNER JOIN categoria c USING(id_categoria)
                WHERE estado = true AND (id_categoria = ?)
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function readAllCategories()
    {
        $sql = 'SELECT id_categoria, categoria, descripcion, foto
                FROM categoria
                ORDER BY categoria';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, foto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, estado, cantidad_existencias
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
}
