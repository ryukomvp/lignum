<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/customers_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Cliente extends ClienteQueries
{
    // Declaración de atributos (propiedades).
    protected $id_cliente = null;
    protected $nombre_cliente = null;
    protected $apellido_cliente = null;
    protected $foto = null;
    protected $dui_cliente = null;
    protected $correo_cliente = null;
    protected $telefono_cliente = null;
    protected $genero = null;
    protected $tipo_cliente = null;
    protected $direccion_cliente = null;
    protected $usuario_publico = null;
    protected $clave = null;
    protected $acceso = null; // Valor por defecto en la base de datos: true
    protected $ruta = '../../images/clientes/';

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreCliente($value)
    {
        if (Validator::validateAlphabetic($value, 1, 70)) {
            $this->nombre_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidoCliente($value)
    {
        if (Validator::validateAlphabetic($value, 1, 70)) {
            $this->apellido_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFoto($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->foto = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setDuiCliente($value)
    {
        if (Validator::validateAlphabetic($value)) {
            $this->dui_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreoCliente($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefonoCliente($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuarioPublico($value)
    {
        if (Validator::validateString($value, 1, 30)) {
            $this->usuario_publico = $value;
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

    public function setAcceso($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->acceso = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getNombreCliente()
    {
        return $this->nombre_cliente;
    }

    public function getApellidoCliente()
    {
        return $this->apellido_cliente;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getDuiCliente()
    {
        return $this->dui_cliente;
    }

    public function getCorreoCliente()
    {
        return $this->correo_cliente;
    }

    public function getTelefonoCliente()
    {
        return $this->telefono_cliente;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getTipoCliente()
    {
        return $this->tipo_cliente;
    }

    public function getUsuarioPublico()
    {
        return $this->usuario_publico;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getAcceso()
    {
        return $this->acceso;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
