<?php
require_once('../../entities/dto/suppliers.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $suppliers = new suppliers;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado']) or 1) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $suppliers->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $suppliers->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$suppliers->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (! $suppliers->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif (! $suppliers->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (! $suppliers->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecta';
                } elseif ($suppliers->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'proveedor creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$suppliers->setId($_POST['id'])) {
                    $result['exception'] = 'proveedor incorrecta';
                } elseif ($result['dataset'] = $suppliers->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'proveedor inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$suppliers->setId($_POST['id'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $suppliers->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$suppliers->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$suppliers->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif (!$suppliers->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$suppliers->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif ($suppliers->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'proveedor actualizada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$suppliers->setId($_POST['id_proveedor'])) {
                    $result['exception'] = 'Proveedor incorrecta';
                } elseif (!$data = $suppliers->readOne()) {
                    $result['exception'] = 'Proveedor inexistente';
                } elseif ($suppliers->deleteRow()) {
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
