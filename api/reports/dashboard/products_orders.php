<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/products.php');
require_once('../../entities/dto/orders.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por categoría');
// Se instancia el módelo Categoría para obtener los datos.
$product = new Product;
$order = new Order;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataorder = $order->report()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, 'Productos', 1, 0, 'C', 1);
    $pdf->cell(126, 10, 'Descripcion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Codigo producto', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Material', 1, 1, 'C', 1);
    $pdf->cell(30, 10, 'Cantidad', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataorder as $rowOrder) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('producto: ' . $rowOrder['nombre_producto']), 1, 1, 'C', 1);
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($products->setProducts($rowproducts['id_producto'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProducts = $products->productosCategoria()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProducts as $rowProducts) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $pdf->encodeString($rowProducto['descripcion_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['codigo_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['tipo_material'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['cantidad'], 1, 0);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Categoría incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
