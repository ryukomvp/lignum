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
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario_privado, usuario_privado, id_empleado, id_tipo_usuario, id_estado_usuario
                FROM usuario_privado
                WHERE id_usuario_privado = ?';
        $params = array($_SESSION['id_usuario_privado']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuario_privado
                SET usuario_privado = ?
                WHERE id_usuario_privado = ?';
        $params = array($this->usuario_privado, $_SESSION['id_usuario_privado']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario_privado, usuario_privado, id_empleado, id_tipo_usuario, id_estado_usuario
                FROM usuario_privado
                WHERE usuario_privado ILIKE ?
                ORDER BY id_usuario_privado';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO id_usuario_privado(usuario_privado, clave, id_empleado, id_tipo_usuario, id_estado_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->usuario, $this->clave, $this->empleado, $this->tipo_usuario, $this->estado_usuario);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario_privado, usuario_privado, id_empleado, id_tipo_usuario, id_estado_usuario
                FROM usuario_privado
                ORDER BY usuario_privado';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario_privado, usuario_privado, id_empleado, id_tipo_usuario, id_estado_usuario
                FROM usuario_privado
                WHERE id_usuario_privado = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuario_privado 
                SET usuario_privado = ?, id_empleado = ?, id_tipo_usuario = ?, id_estado_usuario = ? 
                WHERE id_usuario_privado = ?';
        $params = array($this->usuario_privado, $this->empleado, $this->tipo_usuario, $this->estado_usuario, $this->id);
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
