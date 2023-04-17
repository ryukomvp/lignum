<?php
header('Access-Control-Allow-Origin');
require_once('config.php');


//Clase para realizar acciones en la base de datos
class Database
{
    //Propiedades de la base.
    private static $connection = null;
    private static $statement = null;
    private static $error = null;


    //Metodo para ejecucion de sentencias SQL
    public static function executeRows($query, $values)
    {
        try{
            //Creacion de coneccion mediante clase PDO
            self::$connection = new PDO('pgsql:host' . SERVER . ';dbname=' . DATABASE . ';port=5432', USERNAME, PASSWORD);
            //Preparacion de sentencia sql
            self::$statement = self::$connection->prepare($query);
            //Ejecucion de sentencia. Se retorna el resultado
            return self::$statement->execute($values);
        } catch (PDOException $error) {
            self::setException($error->getCode(), $error->getMessage());
            return false;
        }
    }

    //Metodo para obtencion de llave primaria del ultimo registro ingresado

    public static function getLastRow($query, $values)
    {
        if (self::executeRows($query, $values)) {
            $id = self::$connection->lastInsertId();
        } else {
            $id = 0;
        }
    }

    //Metodo de obtencion de un registro mediante sentencia tipo SELECT

    public static function getRows($query, $values = null)
    {
        if(self::executeRows($query, $values)){
           return self::$statement->fetch(PDO::FETCH_ASSOC);
        } else {
           return false;
        }
    }

    //Metodo de obtencion todos los registros mediante sentencia tipo SELECT

    public static function getRow($query, $values = null)
    {
        if(self::executeRows($query, $values)) {
           return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
           return false;
        }
    }

    //Metodo para obtener un error personalizado en caso de alguna excepcion

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

    //Metodo para obtencion de error personalizado
    
    public static function getException()
    {
        return self::$error;
    }
}


?>