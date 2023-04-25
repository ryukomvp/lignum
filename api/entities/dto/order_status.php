<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/');

class EstadoPedido extends EstadoPedidoQueries
{
    protected $id_estado_pedido = null;
    protected $estado_pedido = null;

    public function setIdEstadoPedido($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->id_estado_pedido = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setEstadoPedido($value)
    {
        if(Validator::validateAlphanumeric($value,1,30)){
            $this->estado_pedido = $value;
            return true;
        }else{
            return false;
        }
    }

    public function getIdEstadoPedido()
    {
        return $this->id_estado_pedido;
    }

    public function getEstadoPedido()
    {
        return $this->estado_pedido;
    }
}
?>