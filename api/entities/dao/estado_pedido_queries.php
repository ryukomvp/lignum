<?php
require_once('../../helpers/database.php');

Class EstadoPedidoQueries{

    //Operaciones SCRUD

    public function readAll(){
        $sql = 'SELECT id_estado_pedido, estado_pedido FROM estado_pedido ORDER BY estado_pedido';
        return Database::getRows($sql);
    }

    
}

?>