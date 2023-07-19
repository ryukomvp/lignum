<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class MaterialQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_tipo_material, tipo_material
                FROM tipo_material
                WHERE tipo_material ILIKE ?
                ORDER BY tipo_material';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipo_material(tipo_material)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT tipo_material
                FROM tipo_material
                ORDER BY tipo_material';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_tipo_material, tipo_material
                FROM tipo_material
                WHERE id_tipo_material = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tipo_material
                SET  tipo_material = ?
                WHERE id_tipo_material = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_material
                WHERE id_tipo_material = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
