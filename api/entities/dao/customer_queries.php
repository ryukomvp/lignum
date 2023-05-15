<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class CustomerQueries
{
    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function checkUser($usuario_publico)
    {
        $sql = 'SELECT id_cliente, acceso FROM cliente WHERE usuario_publico = ?';
        $params = array($usuario_publico);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_cliente = $data['id_cliente'];
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
        $params = array($this->id_cliente);
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
        $sql = 'SELECT id_cliente, foto, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, id_genero, afiliado, direccion_cliente, usuario_publico, acceso 
                FROM cliente
                WHERE apellido_cliente ILIKE ? OR nombre_cliente ILIKE ? OR usuario_publico ILIKE ?
                ORDER BY id_cliente';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente(nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, direccion_cliente, usuario_publico, clave)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->foto, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->genero, $this->direccion_cliente, $this->usuario_publico, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, afiliado, direccion_cliente, usuario_publico, acceso
                FROM cliente
                ORDER BY id_cliente';
        return Database::getRows($sql);
    }

    
    public function readAllGender()
    {
        $sql = 'SELECT unnest(enum_range(NULL::genero))';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, foto, dui_cliente, correo_cliente, telefono_cliente, genero, afiliado, direccion_cliente, usuario_publico, acceso
                FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cliente
                SET nombre_cliente = ?, apellido_cliente = ?, foto = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?,
                genero = ?, afiliado = ?, direccion_cliente = ?, usuario_publico = ?, acceso = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->foto, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->genero, $this->afiliado, $this->direccion_cliente,  $this->usuario_publico, $this->acceso,  $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::executeRow($sql, $params);
    }
}
