<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Nombre del Producto</label>
            <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Nombre del Producto" value="<?php echo s($producto->nombre); ?>">
        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="descripcion">Descripción</label>
            <textarea class="campo-admin__field campo-admin__field--textarea" id="descripcion" name="descripcion"><?php echo s($producto->descripcion); ?></textarea>
        </div>


        <div class="campo-admin">
            <label for="precio" class="campo-admin__label">Precio:</label>
            <input type="number" class="campo-admin__field" id="precio" name="precio" value="<?php echo s($producto->precio); ?>">
        </div>

        <div class="campo-admin">
            <label for="precio" class="campo-admin__label">Precio Con Descuento:</label>
            <input type="number" class="campo-admin__field" id="precio" name="precio_descuento" value="<?php echo $producto->precio_descuento === '' ? '0' : s($producto->precio_descuento); ?>">
        </div>
    </div>

    <div>
        <div class="campo-admin">
            <label for="color" class="campo-admin__label">Color</label>
            <select name="colores_id" id="color">
                <option selected value="">--Seleccione--</option>
                <?php foreach ($colores as $color) { ?>
                    <option
                        <?php echo $producto->colores_id === $color->id ? 'selected' : ''; ?>
                        value="<?php echo s($color->id) ?>">
                        <?php echo s($color->nombre) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="campo-admin">
            <label for="categoria" class="campo-admin__label">Categoria</label>
            <select name="categorias_id" id="categoria">
                <option selected value="">--Seleccione--</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option
                        <?php echo $producto->categorias_id === $categoria->id ? 'selected' : ''; ?>
                        value="<?php echo s($categoria->id) ?>">
                        <?php echo s($categoria->nombre) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="campo-admin">
            <label for="activo" class="campo-admin__label">Activo</label>
            <select name="activo" id="activo">
                <option selected value="">--Seleccione--</option>
                <?php if ($producto->activo == 1) { ?>
                    <option selected value="1">Activo</option>
                    <option value="0">No activo</option>
                <?php } else { ?>
                    <option value="1">Activo</option>
                    <option selected value="0">No activo</option>
                <?php } ?>
            </select>
        </div>
        <div class="campo-admin">
            <label for="destacado" class="campo-admin__label">Destacado</label>
            <select name="destacado" id="destacado">
                <option selected value="">--Seleccione--</option>
                <?php if ($producto->destacado == 1) { ?>
                    <option selected value="1">Desctacado</option>
                    <option value="0">No destacado</option>
                <?php } else { ?>
                    <option value="1">Desctacado</option>
                    <option selected value="0">No destacado</option>
                <?php } ?>
            </select>
        </div>
        <div class="campo-admin">
            <label for="imagenes" class="campo-admin__label">Imagen</label>
            <input type="file" class="campo-admin__field" id="imagenes" name="imagen[]" accept="image/*" multiple>

           

        </div>

    </div>
</div>