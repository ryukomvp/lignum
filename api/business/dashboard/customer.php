<?php
require_once('../../entities/dto/customer.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $customer = new Customer;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $customer->readAll()) {
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
                } elseif ($result['dataset'] = $customer->searchRows($_POST['search'])) {
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
                if (!$customer->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$customer->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellido incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$customer->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$customer->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$customer->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (!$customer->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecta';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione una genero';
                } elseif (!$customer->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero incorrecto';
                } elseif (!$customer->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$customer->setUsuarioPublico($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$customer->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($customer->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $customer->getRuta(), $customer->getFoto())) {
                        $result['message'] = 'Cliente creado correctamente';
                    } else {
                        $result['message'] = 'Cliente creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$customer->setIdCliente($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $customer->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$customer->setIdCliente($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $customer->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif (!$customer->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrecto';
                } elseif (!$customer->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellidos incorrecta';
                } elseif (!$customer->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$customer->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$customer->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$customer->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero incorrecto';
                } elseif (!$customer->setAfiliado(isset($_POST['afiliado']) ? 1 : 0)) {
                    $result['exception'] = 'Afiliado incorrecto';
                } elseif (!$customer->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecta';
                } elseif (!$customer->setUsuarioPublico($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$customer->setAcceso(isset($_POST['acceso']) ? 1 : 0)) {
                    $result['exception'] = 'acceso incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($customer->updateRow($data['foto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Cliente modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$customer->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($customer->updateRow($data['foto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $customer->getRuta(), $customer->getFoto())) {
                        $result['message'] = 'Cliente modificado correctamente';
                    } else {
                        $result['message'] = 'Cliente modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$customer->setIdCliente($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $customer->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif ($customer->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($customer->getRuta(), $data['foto'])) {
                        $result['message'] = 'Cliente eliminado correctamente';
                    } else {
                        $result['message'] = 'Cliente eliminado pero no se borró la imagen';
                    }
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
