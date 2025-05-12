<?php include __DIR__ . "/../templates/admin-header.php"; ?>

<main class="pedidos">
    <div class="pedidos__header">
        <h2>Pagos</h2>
    </div>

    <div class="tabla-contenedor">
        <table class="tabla">
            <thead>
                <tr>
                    <th>referencia</th>
                    <th>monto</th>
                    <th>estado</th>
                    <th>creado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagos as $pago) { ?>
                    <tr>
                        <td><?php echo $pago->referencia; ?></td>
                        <td>$<?php echo number_format($pago->monto, 2); ?></td>
                        <td>
                            <span class="estado estado--<?php echo $pago->estado; ?>">
                                <?php echo ucfirst($pago->estado); ?>
                            </span>
                        </td>
                        <td><?php echo $pago->creado ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>




<?php include __DIR__ . "/../templates/footer-header.php"; ?>