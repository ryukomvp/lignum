<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/inventory_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Inventory extends InventoryQueries
{
    // Declaración de atributos (propiedades).
    protected $id_inventario = null;
    protected $codigo_inventario = null;
    protected $cantidad_entrante = null;
    protected $fecha_entrada = null;
    protected $producto = null;
    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdInventario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_inventario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCodigoInventario($value)
    {
        if (Validator::validateString($value, 1, 10)) {
            $this->codigo_inventario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidadEntrante($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad_entrante = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaEntrada($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_entrada = $value;
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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdInventario()
    {
        return $this->id_inventario;
    }

    public function getCodigoInventario()
    {
        return $this->codigo_inventario;
    }

    public function getCantidadEntrante()
    {
        return $this->cantidad_entrante;
    }

    public function getFechaEntrada()
    {
        return $this->fecha_entrada;
    }

    public function getProducto()
    {
        return $this->producto;
    }
}