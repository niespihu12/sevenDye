<?php include __DIR__ . "/../templates/admin-header.php"; ?>

<div class="orden-container">
    <div class="orden-header">
        <h1>Detalles de la Orden</h1>
        <a href="/orders/admin" class="btn-volver"><i class="fas fa-arrow-left"></i> Volver a Órdenes</a>
    </div>

    <div class="orden-content">
        <div class="panel billing-details">
            <div class="panel-header">
                <h2><i class="fas fa-user"></i> Detalles de Facturación</h2>
            </div>
            <div class="panel-body">
                <div class="datos-cliente">
                    <div class="campo">
                        <span class="etiqueta">Nombre Completo:</span>
                        <span class="valor"><?php echo $billing_details->nombre . ' ' . $billing_details->apellido; ?></span>
                    </div>
                    
                    <?php if(!empty($billing_details->compania)): ?>
                    <div class="campo">
                        <span class="etiqueta">Compañía:</span>
                        <span class="valor"><?php echo $billing_details->compania; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="campo">
                        <span class="etiqueta">Email:</span>
                        <span class="valor"><?php echo $billing_details->email; ?></span>
                    </div>
                    
                    <div class="campo">
                        <span class="etiqueta">Teléfono:</span>
                        <span class="valor"><?php echo $billing_details->telefono; ?></span>
                    </div>
                </div>
                
                <div class="datos-direccion">
                    <h3>Dirección de Envío</h3>
                    <p>
                        <?php echo $billing_details->direccion; ?>
                        <?php if(!empty($billing_details->apartamento)): ?>
                            <br>Apto: <?php echo $billing_details->apartamento; ?>
                        <?php endif; ?>
                        <br><?php echo $billing_details->ciudad; ?>, <?php echo $billing_details->postal; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Panel de Productos -->
        <div class="panel productos-panel">
            <div class="panel-header">
                <h2><i class="fas fa-shopping-cart"></i> Productos Ordenados</h2>
            </div>
            <div class="panel-body">
                <div class="productos-lista">
                    <table class="productos-tabla">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Talla</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($articulos_pedidos as $articulo): 
                                // Obtener datos del producto
                                $producto = \Model\Producto::find($articulo->productos_id);
                                
                                // Obtener nombre de la talla
                                $talla = \Model\Talla::find($articulo->tallas_id);
                                
                                // Calcular subtotal
                                $subtotal = $articulo->cantidad * $articulo->costo_por_unidad;
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td class="producto-info">
                                    <div>
                                        <strong><?php echo $producto ? $producto->nombre : 'Producto #' . $articulo->productos_id; ?></strong>
                                        <span class="ref">REF: <?php echo $producto ? $producto->referencia : 'N/A'; ?></span>
                                    </div>
                                </td>
                                <td><?php echo $talla ? $talla->nombre : 'Talla #' . $articulo->tallas_id; ?></td>
                                <td><?php echo $articulo->cantidad; ?></td>
                                <td>$<?php echo number_format($articulo->costo_por_unidad, 2); ?></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="total-label">Total:</td>
                                <td class="total-value">$<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $script = "<script src='build/js/orden.js'></script>"; ?>

<?php include __DIR__ . "/../templates/admin-footer.php"; ?>