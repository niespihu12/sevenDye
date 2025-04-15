<main class="seccion">
    <h1>Crear</h1>
    <a href="/testimonios/admin" class="boton boton-verde">Volver</a>


    <form method="POST" action="/testimonios/crear" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php"; ?>
        <input type="submit" value="Crear Testimonio">
    </form>
</main>