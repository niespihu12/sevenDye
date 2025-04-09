<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Name:</label>
    <input type="text" id="nombre" name="testimonio[nombre]" placeholder="Name" value="<?php echo s($testimonio->nombre); ?>">

    <label for="imagen">Image:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="testimonio[imagen]">
    <?php if ($testimonio->imagen) { ?>
        <img src="/imagenes/<?php echo $testimonio->imagen; ?>" class="imagen-small">

    <?php } ?>


    <label for="rol">Rol:</label>
    <input type="text" id="rol" name="testimonio[rol]" placeholder="Rol" value="<?php echo s($testimonio->rol); ?>">

    <label for="mensaje">Message:</label>
    <textarea id="mensaje" name="testimonio[mensaje]"><?php echo s($testimonio->mensaje); ?></textarea>
</fieldset>