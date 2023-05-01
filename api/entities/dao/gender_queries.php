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
        $sql = 'SELECT id_tipo_cliente, tipo_cliente
                FROM tipo_cliente
                ORDER BY tipo_cliente';
        return Database::getRows($sql);
    }
}