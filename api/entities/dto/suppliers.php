<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/suppliers.queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Suppliers extends SuppliersQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $direccion = null;
    protected $correo = null;
    protected $telefono = null;


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

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 250)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value, 1, 250)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->telefono = $value;
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

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
}
