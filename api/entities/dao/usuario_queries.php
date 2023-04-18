<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($usuario_privado)
    {
        $sql = 'SELECT id_usuario_privado FROM usuario_privado WHERE usuario_privado = ?';
        $params = array($usuario_privado);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario_privado'];
            $this->usuario_privado = $usuario_privado;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM usuario_privado WHERE id_usuario_privado = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuario_privado SET clave = ? WHERE id_usuario_privado = ?';
        $params = array($this->clave, $_SESSION['id_usuario_privado']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario_privado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado
                FROM usuario_privado
                WHERE id_usuario_privado = ?';
        $params = array($_SESSION['id_usuario_privado']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado
                SET nombre_empleado = ?, apellido_empleado = ?, dui_empleado = ?, correo_empleado = ?, telefono_empleado = ?, usuario_privado = ?
                WHERE id_usuario_privado = ?';
        $params = array($this->nombre_empleado, $this->apellido_empleado, $this->dui_empleado, $this->correo_empleado, $this->telefono_empleado, $this->usuario_privado, $_SESSION['id_usuario_privado']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario_privado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado
                FROM usuario_privado
                WHERE nombre_empleado ILIKE ? OR apellido_empleado ILIKE ?
                ORDER BY apellido_empleado';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuario_privado(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado, clave)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_empleado, $this->apellido_empleado, $this->dui_empleado, $this->correo_empleado, $this->telefono_empleado, $this->usuario_privado, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario_privado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado
                FROM usuario_privado
                ORDER BY apellido_empleado';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario_privado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, usuario_privado
                FROM usuario_privado
                WHERE id_usuario_privado = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuario_privado 
                SET nombre_empleado = ?, apellido_empleado = ?, dui_empleado = ?, correo_empleado = ?, telefono_empleado = ?, usuario_privado = ?
                WHERE id_usuario_privado = ?';
        $params = array($this->nombre_empleado, $this->apellido_empleado, $this->dui_empleado, $this->correo_empleado, $this->telefono_empleado, $this->usuario_privado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario_privado
                WHERE id_usuario_privado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
