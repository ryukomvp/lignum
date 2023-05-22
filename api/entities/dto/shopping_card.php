<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/shopping.card.queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Shopping extends ShoppingQueries
{
    // Declaración de atributos (propiedades).
    protected $id_pedido = null;
    protected $id_detalle = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $codigo = null;
    protected $descripcion = null;
    protected $cliente = null;
    protected $estado = null;
    protected $fecha = null;

    /*   ESTADOS PARA UN PEDIDO
    *   1: Anulado. Es cuando el cliente se arrepiente de haber realizado el pedido.
    *   2: Entregado. Es cuando la tienda ha entregado el pedido al cliente.
    *   3: Pendiente. Es cuando el pedido esta en proceso por parte del cliente y se puede modificar el detalle.
    *   4: procesando. Es cuando el cliente finaliza el pedido y ya no es posible modificar el detalle.
    */

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
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
            $this->id_detalle = $value;
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

    public function setCodigo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 250)) {
            $this->descripcion = $value;
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

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }


    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function getIdDetalle()
    {
        return $this->id_detalle;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
