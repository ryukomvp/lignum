<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_categoria'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/categories.php');
    require_once('../../entities/dto/products.php');
    // Se instancian las entidades correspondientes.
    $categoria = new Category;
    $producto = new Product;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($categoria->setId($_GET['id_categoria']) && $producto->setCategoria($_GET['id_categoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCategoria = $categoria->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la categoría ' . $rowCategoria['categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(46.5, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, $pdf->encodeString('Categoría'), 1, 0, 'C', 1);
                $pdf->cell(46.5, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(46.5, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(46.5, 10, $pdf->encodeString($rowProducto['tipo_material']), 1, 0);
                    $pdf->cell(46.5, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría seleccionada'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'productos_categoria.pdf');
        } else {
            print('Categoría inexistente');
        }
    } else {
        print('Categoría incorrecta');
    }
} else {
    print('Debe seleccionar una categoría');
}
