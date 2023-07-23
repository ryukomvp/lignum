<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/orders.queries.php');

//Clase para manejar transferencia de datos de pedido y detalle pedido

class Order extends OrderQueries
{
    //Declaracion de atributos
    protected $id = null;
    protected $codigo = null;
    protected $descripcion = null;
    protected $cliente = null;
    protected $estado = null;
    protected $direccion = null;
    protected $fecha = null;
    protected $product = null;


    public function setId($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setCodigo($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->codigo = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if(Validator::validateString($value, 1, 250)){
            $this->descripcion = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setCliente($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->cliente = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setEstado($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->estado = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setDireccion($value)
    {
        if(Validator::validateAlphanumeric($value, 1, 250))
        {
            $this->direccion = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setFecha($value)
    {
        if(Validator::validateDate($value))
        {
            $this->fecha = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setProduct($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->product = $value;
            return true;
        }else{
            return false;
        }
    }

    //Metodo de obtencion de valores de atributos
    public function getId()
    {
        return $this->id_pedido;
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

    public function getIdEstado()
    {
        return $this->estado;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getProduct()
    {
        return $this->product;
    }
}


?>