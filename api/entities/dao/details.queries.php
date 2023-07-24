<?php
require_once('../../helpers/database.php');

//Clase para manejar datos de entrada de pedido

class DetailsQueries{

//Operaciones SCRUD 

public function readAll()
{
    $sql = 'SELECT d.id_detalle_pedido, d.id_pedido, d.id_producto, d.precio_producto, d.cantidad 
    from detalle_pedido d
    INNER JOIN producto p ON d.id_producto =  p.id_producto
    INNER JOIN pedido e ON d.id_pedido = e.id_pedido
    ORDER BY id_detalle_pedido';
    return Database::getRows($sql);
}

public function report()
{
    $sql = 'SELECT p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material, COUNT(d.id_producto) as cantidad
    FROM producto p
    INNER JOIN tipo_material t ON  p.id_tipo_material = t.id_tipo_material
    INNER JOIN detalle_pedido d ON p.id_producto = d.id_producto
    GROUP BY p.nombre_producto, p.descripcion_producto, p.codigo_producto, t.tipo_material
    order by cantidad desc';
    return Database::getRows($sql);
}

}

?>