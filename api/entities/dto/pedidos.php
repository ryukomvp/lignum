<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');

//Clase para manejar transferencia de datos de pedido y detalle pedido

class Pedidos extends PedidosQueries
{
    //Declaracion de atributos
    protected $id_pedido = null;
    protected $id_detalle_producto = null;
    protected $cliente = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $estado = null;


    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo de obtencion de valores de atributos
    public function getIdPedido()
    {
        return $this->id_pedido;
    }
}


?>