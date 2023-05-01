<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class GenderQueries
{
    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function readAll()
    {
        $sql = 'SELECT id_genero, genero
                FROM genero
                ORDER BY id_genero';
        return Database::getRows($sql);
    }
}