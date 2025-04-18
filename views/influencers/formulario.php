<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Name</label>
            <input class="campo-admin__field" type="text" id="nombre" name="influencer[nombre]" placeholder="name" value="<?php echo s($influencer->nombre); ?>">
        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="youtube">Youtube</label>
            <input class="campo-admin__field" type="text" id="youtube" name="influencer[youtube]" placeholder="youtube" value="<?php echo s($influencer->youtube); ?>">
        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="descripcion">Description</label>
            <textarea id="descripcion" class="campo-admin__field campo-admin__field--textarea" name="influencer[descripcion]"><?php echo s($influencer->descripcion); ?></textarea>

        </div>
    </div>
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="instagram">Instagram</label>
            <input class="campo-admin__field" type="text" id="instagram" name="influencer[instagram]" placeholder="instagram" value="<?php echo s($influencer->instagram); ?>">
        </div>
        
        <div class="campo-admin">
            <label class="campo-admin__label" for="tiktok">Tiktok</label>
            <input class="campo-admin__field" type="text" id="tiktok" name="influencer[tiktok]" placeholder="tiktok" value="<?php echo s($influencer->tiktok); ?>">


        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="imagen">Image</label>
            <input class="campo-admin__field--archi" type="file" id="imagen" accept="image/jpeg, image/png" name="influencer[imagen]">
            <?php if ($influencer->imagen) { ?>
                <img class="campo-admin__image" src="/imagenes/<?php echo $influencer->imagen; ?>" class="imagen-small">

            <?php } ?>
        </div>

    </div>
</div>