<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="slug">Slug</label>
            <input class="campo-admin__field" type="text" id="slug" name="slug" placeholder="Slug" value="<?php echo s($categoria->slug); ?>">
        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Name</label>
            <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Name" value="<?php echo s($categoria->nombre); ?>">
        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="descripcion">Description</label>
            <textarea id="descripcion" class="campo-admin__field campo-admin__field--textarea" name="descripcion"><?php echo s($categoria->descripcion); ?></textarea>

        </div>
    </div>
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="imagen">Image</label>
            <input class="campo-admin__field--archi" type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <?php if ($categoria->imagen) { ?>
                <img class="campo-admin__image" src="/imagenes/<?php echo $categoria->imagen; ?>" class="imagen-small">

            <?php } ?>
        </div>

    </div>
</div>