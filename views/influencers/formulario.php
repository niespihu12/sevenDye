<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Name:</label>
    <input type="text" id="nombre" name="influencer[nombre]" placeholder="name" value="<?php echo s($influencer->nombre); ?>">
    <label for="youtube">Youtube:</label>
    <input type="text" id="youtube" name="influencer[youtube]" placeholder="youtube" value="<?php echo s($influencer->youtube); ?>">
    <label for="tiktok">Tiktok:</label>
    <input type="text" id="tiktok" name="influencer[tiktok]" placeholder="tiktok" value="<?php echo s($influencer->tiktok); ?>">
    <label for="instagram">Instagram:</label>
    <input type="text" id="instagram" name="influencer[instagram]" placeholder="instagram" value="<?php echo s($influencer->instagram); ?>">

    <label for="imagen">Image:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="influencer[imagen]">
    <?php if ($influencer->imagen) { ?>
        <img src="/imagenes/<?php echo $influencer->imagen; ?>" class="imagen-small">

    <?php } ?>

    <label for="descripcion">Description:</label>
    <textarea id="descripcion" name="influencer[descripcion]"><?php echo s($influencer->descripcion); ?></textarea>
</fieldset>