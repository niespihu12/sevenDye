<main class="seccion">
    <h1>Actualizar</h1>
    <a href="/influencers/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <form method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php"; ?>
        <input type="submit" value="Actualizar Influencer">
    </form>
</main>