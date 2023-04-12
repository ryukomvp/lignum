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
    protected $usuario_privado = null;
    protected $clave = null;
    protected $empleado = null;
    protected $tipo_usuario = null;
    protected $estado_usuario = null;

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

    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstadoUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
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

    public function getUsuarioPrivado()
    {
        return $this->usuario_privado;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getEmpleado()
    {
        return $this->empleado;
    }

    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }

    public function getEstadoUsuario()
    {
        return $this->estado_usuario;
    }
}
