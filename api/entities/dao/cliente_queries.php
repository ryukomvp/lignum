<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class ClienteQueries
{
    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function checkUser($usuario_publico)
    {
        $sql = 'SELECT id_cliente, acceso FROM cliente WHERE usuario_publico = ?';
        $params = array($correo);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->acceso = $data['acceso'];
            $this->usuario_publico = $usuario_publico;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM cliente WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE cliente SET clave = ? WHERE id_cliente = ?';
        $params = array($this->clave, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, apellido_cliente = ?, foto = ?, correo_cliente = ?, telefono_cliente = ?, direccion_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->foto, $this->correo_cliente, $this->telefono_cliente, $this->direccion_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE cliente
                SET acceso = ?
                WHERE id_cliente = ?';
        $params = array($this->acceso, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, correo_cliente, dui_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente
                FROM cliente
                WHERE apellido_cliente ILIKE ? OR nombre_cliente ILIKE ? OR usuario_publico ILIKE ?
                ORDER BY apellido_cliente';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    // public function createRow()
    // {
    //     $sql = 'INSERT INTO clientes(nombres_cliente, apellidos_cliente, correo_cliente, dui_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, clave_cliente)
    //             VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
    //     $params = array($this->nombres, $this->apellidos, $this->correo, $this->dui, $this->telefono, $this->nacimiento, $this->direccion, $this->clave);
    //     return Database::executeRow($sql, $params);
    // }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, tipo_cliente, direccion_cliente, usuario_publico
                FROM cliente
                ORDER BY apellido_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, tipo_cliente, direccion_cliente, usuario_publico
                FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cliente
                SET nombre_cliente = ?, apellido_cliente = ?, foto = ?, correo_cliente = ?, telefono_cliente = ?, direccion_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->foto, $this->correo_cliente, $this->telefono_cliente, $this->direccion_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
