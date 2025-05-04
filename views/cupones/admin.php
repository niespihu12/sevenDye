<?php include_once __DIR__ . "/../templates/admin-header.php"; ?>

<main class="dashboard__content">
    <div class="influencers">
        <div class="dashboard__breadcrumb">
            <p>
                <a href="/admin">Admin</a>
                <span>></span>
                <?php echo $pageTitle; ?>
            </p>
        </div>
        <div class="influencers__header">
            <h2>Cupones de Descuento</h2>
            <a href="/cupones/crear" class="influencers__nuevo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Nuevo Cupón
            </a>
        </div>
        
        <?php if(isset($_GET['resultado'])) { 
            if($_GET['resultado'] === "1") { ?>
                <div class="alerta exito">
                    El cupón se ha creado correctamente
                </div>
            <?php } else if($_GET['resultado'] === "2") { ?>
                <div class="alerta exito">
                    El cupón se ha actualizado correctamente
                </div>
            <?php } else if($_GET['resultado'] === "3") { ?>
                <div class="alerta exito">
                    El cupón se ha eliminado correctamente
                </div>
            <?php }
        } ?>
        
        <table class="influencers__tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Descuento</th>
                    <th>Mín. Pedido</th>
                    <th>Expiración</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cupones as $cupon) { ?>
                    <tr>
                        <td><?php echo $cupon->id; ?></td>
                        <td><?php echo $cupon->codigo; ?></td>
                        <td>
                            <div class="influencers__descripcion"><?php echo $cupon->descripcion; ?></div>
                        </td>
                        <td>
                            <?php echo $cupon->tipo_descuento === 'porcentaje' ? $cupon->descuento . '%' : '$' . $cupon->descuento; ?>
                        </td>
                        <td>
                            <?php 
                                if($cupon->tipo_pedido_minimo === 'ninguno') {
                                    echo 'No aplica';
                                } else {
                                    echo '$' . $cupon->minimo_pedido;
                                }
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($cupon->expira)); ?></td>
                        <td>
                            <?php 
                                $estado = $cupon->estaActivo() ? 'Activo' : 'Expirado';
                                $clase = $cupon->estaActivo() ? 'estado-activo' : 'estado-inactivo';
                            ?>
                            <span class="<?php echo $clase; ?>"><?php echo $estado; ?></span>
                        </td>
                        <td>
                            <div class="influencers__acciones">
                                <form method="POST" action="/cupones/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $cupon->id; ?>">
                                    <button type="submit" class="boton-eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                                <a href="/cupones/actualizar?id=<?php echo $cupon->id; ?>" class="boton-actualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                    Actualizar
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once __DIR__ . "/../templates/admin-footer.php"; ?>