<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CategoryQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_categoria, categoria, descripcion, foto
                FROM categoria
                WHERE categoria ILIKE ?
                ORDER BY categoria';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO categoria(categoria, descripcion, foto)
                VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->foto);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_categoria, categoria, descripcion, foto
                FROM categoria
                ORDER BY categoria';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_categoria, categoria, descripcion, foto
                FROM categoria
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->foto) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->foto = $current_image;

        $sql = 'UPDATE categoria
                SET  categoria = ?, descripcion = ?, foto = ?
                WHERE id_categoria = ?';
        $params = array($this->nombre, $this->descripcion, $this->foto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM categoria
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
