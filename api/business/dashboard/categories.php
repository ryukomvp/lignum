<?php
require_once('../../entities/dto/categories.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $category = new Category;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $category->readAll()) {
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
                    $result['dataset'] = $category->readAll();
                } elseif ($result['dataset'] = $category->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$category->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$category->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecto';
                } elseif (!$category->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif ($category->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $category->getRuta(), $category->getFoto())) {
                        $result['message'] = 'Categoria creada correctamente';
                    } else {
                        $result['message'] = 'Categoria creada pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$category->setId($_POST['id'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif ($result['dataset'] = $category->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoría inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$category->setId($_POST['id'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $category->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$category->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$category->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecto';
                } elseif (!$category->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif ($category->updateRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $category->getRuta(), $category->getFoto())) {
                        $result['message'] = 'Categoria creada correctamente';
                    } else {
                        $result['message'] = 'Categoria creada pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$category->setId($_POST['id_categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $category->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif ($category->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'categoria eliminada correctamente';
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
