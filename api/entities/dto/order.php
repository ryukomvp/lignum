<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');

//Clase para manejar transferencia de datos de pedido y detalle pedido

class Pedidos extends PedidosQueries
{
    //Declaracion de atributos
    protected $id_pedido = null;
    protected $codigo = null;
    protected $descripcion = null;
    protected $cliente = null;
    protected $estado = null;
    protected $direccion = null;
    protected $fecha = null;


    public function setIdPedido($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->codigo = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setCodigo($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->id_pedido = $value;
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

    public function setIdCliente($value)
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

    //Metodo de obtencion de valores de atributos
    public function getIdPedido()
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

    public function getIdCliente()
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
}


?>