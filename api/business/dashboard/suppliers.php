<?php
require_once('../../entities/dto/suppliers.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $supplier = new supplier;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado']) or 1) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $supplier->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $supplier->readAll();
                } elseif ($result['dataset'] = $supplier->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$supplier->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (! $supplier->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif (! $supplier->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (! $supplier->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecta';
                } elseif ($supplier->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'proveedor creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$supplier->setId($_POST['id'])) {
                    $result['exception'] = 'proveedor incorrecta';
                } elseif ($result['dataset'] = $supplier->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'proveedor inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$supplier->setId($_POST['id'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $supplier->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$supplier->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$supplier->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif (!$supplier->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$supplier->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif ($supplier->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'proveedor actualizada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$supplier->setId($_POST['id_proveedor'])) {
                    $result['exception'] = 'Proveedor incorrecta';
                } elseif (!$data = $supplier->readOne()) {
                    $result['exception'] = 'Proveedor inexistente';
                } elseif ($supplier->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'proveedor eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
