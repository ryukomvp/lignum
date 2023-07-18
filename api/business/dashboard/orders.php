<?php
require_once('../../entities/dto/order.php');


if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $order = new Order;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_usuario_privado'])) {
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $orders->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay ningun pedido en curso';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if($_POST['search'] == ''){
                    $result['exception'] = 'Ingrese un valor para buscar';
                }elseif($result['dataset'] = $orders->searchOrder($_POST['search'])){
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()){
                    $result['exception'] = Database::getException();
                }else{
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$orders->setCodigo($_POST['codigo'])){
                    $result['exception'] = 'Codigo incorrecto';
                }elseif(!$orders->setDescripcion($_POST['descripcion'])){
                    $result['exception'] = 'Descripción incorrecta';
                }elseif(!isset($_POST['cliente'])){
                    $result['exception'] = 'Seleccione un cliente';
                }elseif(!$orders->setIdCliente($_POST['cliente'])){
                    $result['exception'] = 'Cliente incorrecto';
                }elseif(!isset($_POST['estado'])){
                    $result['exception'] = 'Seleccione un estado';
                }elseif(!$orders->setEstado($_POST['estado'])){
                    $result['exception'] = 'Estado incorrecto';
                }elseif(!$orders->setDireccion($_POST['direccion'])){
                    $result['exception'] = 'Direccion incorrecta';
                }elseif(!$orders->setFecha($_POST['fecha'])){
                    $result['exception'] = 'Fecha incorrecta';
                }elseif($orders->createOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido ingresado correctamente';
                }else{
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$orders->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $orders->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if(!$orders->setIdPedido($_POST['id_pedido'])){
                  $result['exception'] = 'Pedido incorrecto';
                }elseif(!$data->readOne()){
                  $result['exception'] = 'Pedido inexistente'; 
                }elseif (!$orders->setCodigo($_POST['codigo'])){
                    $result['exception'] = 'Nombre incorrecto';
                }elseif(!$orders->setDescripcion($_POST['descripcion'])){
                    $result['exception'] = 'Descripción incorrecta';
                }elseif(!$orders->setIdCliente($_POST['cliente'])){
                    $result['exception'] = 'Seleccione un cliente';
                }elseif(!$orders->setEstado($_POST['estado'])){
                    $result['exception'] = 'Seleccione un estado';
                }elseif(!$orders->updateOrder()){
                    $result['status'] = 1;
                    $result['message'] = 'Pedido Actualizado Correctamente';
                }
                break;
            case 'delete':
                if (!$orders->setIdPedido($_POST['id_producto'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif (!$orders->deleteOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
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


?>