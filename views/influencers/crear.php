<main class="seccion">
    <h1>Crear</h1>
    <a href="/influencers/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>


    <form method="POST" action="/influencers/crear" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php"; ?>
        <input type="submit" value="Crear Testimonio">
    </form>
</main>