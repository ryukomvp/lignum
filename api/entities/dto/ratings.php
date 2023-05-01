<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/ratings.queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Ratings extends RatingsQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $puntaje = null;
    protected $comentario = null;
    protected $producto = null;
    protected $fecha = null;
    protected $cliente = null;
    protected $pedido = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPuntaje($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->puntaje = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setComentario($value)
    {
        if (Validator::validateString($value, 1, 150)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateString($value, 1, 150)) {
            $this->producto = $value;
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

    public function setCliente($value)
    {
        if (Validator::validateString($value, 1, 150)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPedido($value)
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
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
}
