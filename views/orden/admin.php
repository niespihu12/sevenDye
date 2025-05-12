<?php include __DIR__ . "/../templates/admin-header.php"; ?>

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
            <h2>ordenes</h2>
        </div>

        <table class="influencers__tabla">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Referencia</th>
                    <th>Estado</th>
                    <th>Usuarios_id</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($ordenes as $orden) { ?>
                    <tr>
                        <td><?php echo $orden->id; ?></td>
                        <td><?php echo $orden->referencia; ?></td>
                        <td><?php echo $orden->estado; ?></td>
                        <td>
                            <?php echo $orden->usuarios_id; ?>
                        </td>
                        <td>
                            <div class="influencers__acciones">
                                <a href="/orders/see?id=<?php echo $orden->id; ?>" class="boton-actualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                    ver
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>


<?php include __DIR__ . "/../templates/admin-footer.php"; ?>