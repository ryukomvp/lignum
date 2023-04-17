<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre_empleado = null;
    protected $apellido_empleado = null;
    protected $dui_empleado = null;
    protected $correo_empleado = null;
    protected $telefono_empleado = null;
    protected $usuario_privado = null;
    protected $clave = null;

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

    public function setNombreEmpleado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 70)) {
            $this->nombre_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidoEmpleado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 70)) {
            $this->apellido_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDuiEmpleado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 10)) {
            $this->dui_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreoEmpleado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 120)) {
            $this->correo_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoEmpleado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 9)) {
            $this->telefono_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuarioPrivado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 30)) {
            $this->usuario_privado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
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

    public function getNombreEmpleado()
    {
        return $this->nombre_empleado;
    }

    public function getApellidoEmpleado()
    {
        return $this->apellido_empleado;
    }

    public function getDuiEmpleado()
    {
        return $this->dui_empleado;
    }

    public function getCorreoEmpleado()
    {
        return $this->correo_empleado;
    }

    public function getTelefonoEmpleado()
    {
        return $this->telefono_empleado;
    }

    public function getUsuarioPrivado()
    {
        return $this->usuario_privado;
    }

    public function getClave()
    {
        return $this->clave;
    }
}