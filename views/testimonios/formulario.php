<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Name</label>
            <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Name" value="<?php echo s($testimonio->nombre); ?>">
        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="imagen">Image</label>
            <input class="campo-admin__field--archi" type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <?php if ($testimonio->imagen) { ?>
                <img class="campo-admin__image" src="/imagenes/<?php echo $testimonio->imagen; ?>" class="imagen-small">

            <?php } ?>
        </div>
    </div>
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="rol">Rol</label>
            <input class="campo-admin__field" type="text" id="rol" name="rol" placeholder="Rol" value="<?php echo s($testimonio->rol); ?>">

        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="mensaje">Message</label>
            <textarea class="campo-admin__field campo-admin__field--textarea" id="mensaje" name="mensaje"><?php echo s($testimonio->mensaje); ?></textarea>

        </div>
    </div>
</div>