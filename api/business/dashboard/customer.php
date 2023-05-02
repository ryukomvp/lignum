<?php
require_once('../../entities/dto/customer.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Customer;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $cliente->searchRows($_POST['search'])) {
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
                if (!$cliente->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$cliente->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellido incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$cliente->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$cliente->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (!$cliente->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecta';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione una genero';
                } elseif (!$cliente->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero incorrecto';
                } elseif (!$cliente->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$cliente->setUsuarioPublico($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$cliente->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $cliente->getRuta(), $cliente->getFoto())) {
                        $result['message'] = 'Cliente creado correctamente';
                    } else {
                        $result['message'] = 'Cliente creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$cliente->setIdCliente($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setIdCliente($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$cliente->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$cliente->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellido incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$cliente->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$cliente->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (!$cliente->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecta';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione una genero';
                } elseif (!$cliente->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero incorrecto';
                } elseif (!$cliente->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$cliente->setUsuarioPublico($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$cliente->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $cliente->getRuta(), $cliente->getFoto())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'delete':
                if (!$cliente->setIdCliente($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif ($cliente->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($cliente->getRuta(), $data['foto'])) {
                        $result['message'] = 'Cliente eliminado correctamente';
                    } else {
                        $result['message'] = 'Cliente eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // case 'cantidadProductosCategoria':
                //     if ($result['dataset'] = $cliente->cantidadProductosCategoria()) {
                //         $result['status'] = 1;
                //     } else {
                //         $result['exception'] = 'No hay datos disponibles';
                //     }
                //     break;
                // case 'porcentajeProductosCategoria':
                //     if ($result['dataset'] = $cliente->porcentajeProductosCategoria()) {
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
