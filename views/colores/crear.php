<?php include __DIR__ . "/../templates/admin-header.php"; ?>

<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/colores/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>

    <div class="seccion-admin">

        <form method="POST" action="/colores/crear" enctype="multipart/form-data">
            <?php include __DIR__ . "/formulario.php"; ?>
        </form>
    </div>


</main>
<?php $script = "<script src='/build/js/colores.js'></script>"; ?>
<?php include __DIR__ . "/../templates/admin-footer.php"; ?>