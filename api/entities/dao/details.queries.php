<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido

class DetailsQueries{

//Operaciones SCRUD 

public function readAll()
{
    $sql = 'SELECT id_pedido, codigo_pedido, descripcion_pedido, nombre_cliente, estado_pedido, direccion_pedido, fecha from pedido INNER JOIN cliente USING(id_cliente) INNER JOIN estado_pedido USING(id_estado_pedido) ORDER BY id_pedido';
    return Database::getRows($sql);
}


}

?>