<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/categories_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Category extends CategoryQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $foto = null;
    protected $ruta = '../../images/categories/';

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
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 128)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFoto($file)
    {
        if (Validator::validateImageFile($file, 100, 100)) {
            $this->foto = Validator::getFileName();
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

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
