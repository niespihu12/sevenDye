<div class="influencer-dashboard">
    <?php include_once __DIR__ . '/../templates/side-bar.php' ?>



    <div class="dashboard">
        <header class="dashboard-header">
            <div class="dashboard-header__texto">
                <h2>Dashboard</h2>
                <p>Admin</p>
            </div>
        </header>

        <div class="estadisticas">
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3>Ventas totales</h3>
                </div>
                <p class="dashboard-card__cantidad"><?php echo MONEDA . number_format($pagosTotal["SUM(monto)"], 2); ?></p>

            </div>

            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3>Clientes</h3>
                </div>
                <p class="dashboard-card__cantidad"><?php echo number_format($usuarios); ?> Clientes</p>
            </div>
        </div>

        <div class="pedidos">
            <div class="pedidos__header">
                <h2>Pagos Recientes</h2>
                <button class="btn-todos">Ver todos</button>
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
        </div>
    </div>