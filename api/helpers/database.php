<?php
header('Access-Control-Allow-Origin')
require_once('config.php')

class Database
{
    private static $connection = null;
    private static $statement = null;
    private static $error = null;

    public static function executeRow($query, $values)
    {
        try{
            self::$connection = new PDO('pgsql:host' . SERVER . ';dbname=' . DATABASE . ';port=5432', USERNAME, PASSWORD);
            self::$statement = self::$connection->prepare($query);
            return self::$statement->execute($values);
        } catch (PDOException $error) {
            self::setException($errorgetCode(), $error->getMessage());
            return false;
        }
    }

    public static function getLastRow($query, $values)
    {
        if (self::executeRow($query, $values)) {
            $id = self::$connection->lastInsertId();
        } else {
            $id = 0;
        }
    }

    public static function getRow($query, $values = null)
    {
        if(self::executeRow($query, $values)){
           return self::$statement->fetch(PDO::FETCH_ASSOC);
        } else {
           return false;
        }
    }

    public static function getRow($query, $values = null)
    {
        if(self::executeRow($query, $values)) {
           return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
           return false;
        }
    }

    private static function setException($code, $message)
    {
        // Se asigna el mensaje del error original por si se necesita.
        self::$error = $message . PHP_EOL;
        // Se compara el código del error para establecer un error personalizado.
        switch ($code) {
            case '7':
                self::$error = 'Existe un problema al conectar con el servidor';
                break;
            case '42703':
                self::$error = 'Nombre de campo desconocido';
                break;
            case '23505':
                self::$error = 'Violación de unicidad';
                break;
            case '42P01':
                self::$error = 'Nombre de tabla desconocido';
                break;
            case '23503':
                self::$error = 'Violación de llave foránea';
                break;
            default:
                self::$error = 'Ocurrió un problema en la base de datos';
        }
    }

    /*
    *   Método para obtener un error personalizado cuando ocurre una excepción.
    *   Parámetros: ninguno.
    *   Retorno: error personalizado.
    */
    public static function getException()
    {
        return self::$error;
    }
}


?>