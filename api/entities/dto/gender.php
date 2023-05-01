<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/gender_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Gender extends GenderQueries
{
    // Declaración de atributos (propiedades).
    protected $id_genero = null;
    protected $genero = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_genero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGenero($value)
    {
        if (Validator::validateAlphabetic($value, 1, 30)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdGenero()
    {
        return $this->id_genero;
    }

    public function getGenero()
    {
        return $this->genero;
    }
}
