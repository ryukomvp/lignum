<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/details.queries.php');

//Clase para manejar transferencia de datos de pedido y detalle pedido

class Details extends DetailsQueries
{
    //Declaracion de atributos
    protected $id = null;
    protected $pedido = null;
    protected $producto = null;
    protected $precio = null;
    protected $cantidad = null;



    public function setId($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setPedido($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->pedido = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setProducto($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->producto = $value;
            return true;
        }else{
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

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo de obtencion de valores de atributos
    public function getId()
    {
        return $this->id_pedido;
    }

    public function getPedido()
    {
        return $this->pedido;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
}


?>