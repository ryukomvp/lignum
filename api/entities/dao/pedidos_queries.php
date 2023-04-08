<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido y detalle pedido

class PedidosQueries{

//Se verifica si existe un pedido, si no es el caso se crea uno

public function startOrder()
{
    $sql = 'SELECT id_pedido FROM pedido WHERE estado_pedido = 1 AND id_cliente = ?';
    $params = array($_SESSION['id_cliente']);
    if($data = Database::getRow($sql, $params)){
        this->id_pedido = $data['id_pedido'];
        return true;
    }else{
        $sql = 'INSERT INTO pedido(direccion_pedido, id_cliente) VALUES((SELECT direccion_cliente from cliente WHERE id_cliente = ?), ?)';
        $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente'])
        if($this->id_pedido = Database::getLastRow($sql, $params)) {
            return true;
        }else{
            return false;
        }
    }
}

}


?>