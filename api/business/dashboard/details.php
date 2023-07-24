<?php
require_once('../../entities/dto/deatils.php.php');


if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $details = new Details;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_usuario_privado'])) {
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $details->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay ningun pedido en curso';
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


?>