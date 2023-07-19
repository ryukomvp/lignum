<?php
require_once('../../entities/dto/materials.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $material = new Material;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado']) or 1) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] =  $material->readAll()) {
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
                    $result['dataset'] =  $material->readAll();
                    $result['status'] = 1;
                } elseif ($result['dataset'] =  $material->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (! $material->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }  elseif ( $material->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Material creado correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (! $material->setId($_POST['id'])) {
                    $result['exception'] = 'Material incorrecta';
                } elseif ($result['dataset'] =  $material->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Material inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (! $material->setId($_POST['id'])) {
                    $result['exception'] = 'Material incorrecta';
                } elseif (!$data =  $material->readOne()) {
                    $result['exception'] = 'Material inexistente';
                } elseif (! $material->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif ( $material->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Material actualizada correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (! $material->setId($_POST['id_tipo_material'])) {
                    $result['exception'] = 'Material incorrecta';
                } elseif (!$data =  $material->readOne()) {
                    $result['exception'] = 'Material inexistente';
                } elseif ( $material->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Material eliminada correctamente';
                }else {
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
