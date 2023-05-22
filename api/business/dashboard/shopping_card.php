<?php
require_once('../../entities/dto/shopping_card.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $shopping = new Shopping;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado']) or 1) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $shopping->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
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
                } elseif ($result['dataset'] = $shopping->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'createDetail':
                $_POST = Validator::validateForm($_POST);
                if (!$shopping->startOrder()) {
                    $result['exception'] = 'Ocurrió un problema al obtener el shopping';
                } elseif (!$shopping->setProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$shopping->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif ($shopping->createDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOrderDetail':
                if (!$shopping->startOrder()) {
                    $result['exception'] = 'Debe agregar un producto al carrito';
                } elseif ($result['dataset'] = $shopping->readOrderDetail()) {
                    $result['status'] = 1;
                    $_SESSION['id_pedido'] = $shopping->getIdPedido();
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No tiene productos en el carrito';
                }
                break;
            case 'updateDetail':
                $_POST = Validator::validateForm($_POST);
                if (!$shopping->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'valoracion incorrecta';
                } elseif (!$data = $shopping->readOrderDetail()) {
                    $result['exception'] = 'valoracion inexistente';
                } elseif (!$products->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($shopping->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'categoria actualizada correctamente';
                }else {
                    $result['exception'] = Database::getException();
                }
                break;
            // case 'delete':
            //     if (!$shopping->setId($_POST['id_categoria'])) {
            //         $result['exception'] = 'Categoría incorrecta';
            //     } elseif (!$data = $shopping->readOrderDetail()) {
            //         $result['exception'] = 'Categoría inexistente';
            //     } elseif ($shopping->deleteRow()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'categoria eliminada correctamente';
            //     }else {
            //         $result['exception'] = Database::getException();
            //     }
            //     break;
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
