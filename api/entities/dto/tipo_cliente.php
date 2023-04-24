<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/tipo_cliente_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Cliente extends ClienteQueries
{
    // Declaración de atributos (propiedades).
    protected $id_tipo_cliente = null;
    protected $tipo_cliente = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdTipoCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_tipo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoCliente($value)
    {
        if (Validator::validateAlphabetic($value, 1, 30)) {
            $this->tipo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdTipoCliente()
    {
        return $this->id_tipo_cliente;
    }

    public function getTipoCliente()
    {
        return $this->tipo_cliente;
    }
}
