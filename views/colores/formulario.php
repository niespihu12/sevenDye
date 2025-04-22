<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Name</label>
            <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Name" value="<?php echo s($color->nombre); ?>">
        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="color">Color</label>
            <input class="campo-admin__color" type="color" name="hexadecimal" id="color" value="<?php echo s($color->hexadecimal); ?>" >
        </div>


    </div>
</div>