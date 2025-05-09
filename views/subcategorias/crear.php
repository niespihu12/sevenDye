<?php include_once __DIR__ . "/../templates/admin-header.php"; ?>

<main class="formularios-admin">
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/subcategories/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>

    <div class="seccion-admin">
        <h1><i class="fas fa-folder-plus"></i> Crear Subcategoría</h1>

        <form method="POST" action="/subcategories/create">
            <?php include __DIR__ . "/formulario.php"; ?>
            <input class="boton-primario" type="submit" value="Crear Subcategoría">
        </form>
    </div>
</main>

<?php include_once __DIR__ . "/../templates/admin-footer.php"; ?>