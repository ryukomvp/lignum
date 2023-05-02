<?php
require_once('../../entities/dto/inventory.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $inventario = new Inventory;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $inventario->readAll()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' registros';
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
                } elseif ($result['dataset'] = $inventario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$inventario->setCodigoInventario($_POST['codigo'])) {
                    $result['exception'] = 'Código de inventario incorrecto';
                } elseif (!$inventario->setCantidadEntrante($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad entrante incorrecta';
                } elseif (!$inventario->setFechaEntrada($_POST['fecha'])) {
                    $result['exception'] = 'Fecha de entrada incorrecto';
                }  elseif (!isset($_POST['producto'])) {
                    $result['exception'] = 'Seleccione un producto';
                } elseif (!$inventario->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Producto incorrecta';
                } elseif ($inventario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Entrada de inventario registrada correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$inventario->setIdInventario($_POST['id'])) {
                    $result['exception'] = 'Inventario incorrecto';
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Entrada en inventario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$inventario->setIdInventario($_POST['id'])) {
                    $result['exception'] = 'Entrada en inventario incorrecta';
                } elseif (!$data = $inventario->readOne()) {
                    $result['exception'] = 'Entrada en inventario inexistente';
                } elseif (!$inventario->setCodigoInventario($_POST['codigo'])) {
                    $result['exception'] = 'Codigo de inventario incorrecto';
                } elseif (!$inventario->setCantidadEntrante($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad entrante incorrecta';
                } elseif (!$inventario->setFechaEntrada($_POST['fecha'])) {
                    $result['exception'] = 'Fecha de entrada incorrecta';
                } elseif (!$inventario->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Seleccione un producto';
                } elseif ($inventario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Entrada en inventario modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$inventario->setIdInventario($_POST['id_producto'])) {
                    $result['exception'] = 'Entrada en inventario incorrecta';
                } elseif (!$data = $inventario->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($inventario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Entrada en inventario eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            // case 'cantidadProductosCategoria':
            //     if ($result['dataset'] = $producto->cantidadProductosCategoria()) {
            //         $result['status'] = 1;
            //     } else {
            //         $result['exception'] = 'No hay datos disponibles';
            //     }
            //     break;
            // case 'porcentajeProductosCategoria':
            //     if ($result['dataset'] = $producto->porcentajeProductosCategoria()) {
            //         $result['status'] = 1;
            //     } else {
            //         $result['exception'] = 'No hay datos disponibles';
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
