<?php include __DIR__ . "/influencer-header.php"; ?>
<main class="seccion">
    <h1>Actualizar</h1>
    <a href="/influencers/admin" class="boton boton-verde">Volver</a>

    <form method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php"; ?>
        <input type="submit" value="Actualizar Influencer">
    </form>
</main>
<?php include __DIR__ . "/influencer-footer.php"; ?>