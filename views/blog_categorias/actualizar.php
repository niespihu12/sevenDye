<?php include_once __DIR__ . "/../templates/admin-header.php"; ?>
<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/blog_categorias/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>

    <div  class="seccion-admin">
        <h1>Actualizar Categoria</h1>

        <form method="POST" enctype="multipart/form-data">
            <?php include __DIR__ . "/formulario.php"; ?>
        </form>
    </div>

</main>
<?php include_once __DIR__ . "/../templates/admin-footer.php"; ?>