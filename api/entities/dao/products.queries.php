<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ProductoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    /*metodo para buscar registros*/
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nomre_producto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, id_estado_producto, cantidad_existencias, imagen_producto
                FROM producto INNER JOIN categorias USING(id_categoria)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nomre_producto, descripcion_producto, precio_producto, codigo_producto, dimensiones, id_categoria, id_tipo_material, id_proveedor, id_estado_producto, cantidad_existencias, imagen_producto)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->codigo, $this->dimensiones, $this->categoria, $this->material, $this->proveedor, $this->estado, $this->cantidad,$this->imagen, $_SESSION['id_usuario_privado']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre_categoria, estado_producto
                FROM productos INNER JOIN categorias USING(id_categoria)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET nomre_producto = ?, precio_producto ,descripcion_producto = ?, codigo_producto = ?, dimensiones = ?, id_categoria = ?, id_tipo_material = ?, id_proveedor = ?, id_estado_producto = ?, cantidad_existencias = ?, imagen_producto = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->precio, $this->descripcion, $this->codigo, $this->dimenciones, $this->categoria, $this->material, $this->proveedor, $this->estado,  $this->existencia, $this->imagen);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readProductosCategoria()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto
                FROM productos INNER JOIN categorias USING(id_categoria)
                WHERE id_categoria = ? AND estado_producto = true
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */
    public function productosCategoria()
    {
        $sql = 'SELECT nombre_producto, precio_producto, estado_producto
                FROM productos INNER JOIN categorias USING(id_categoria)
                WHERE id_categoria = ?
                ORDER BY nombre_producto';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }
}
