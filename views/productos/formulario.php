<div class="formulario-admin">
    <div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="nombre">Nombre del Producto</label>
            <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Nombre del Producto" value="<?php echo s($producto->nombre); ?>">
        </div>
        <div class="campo-admin">
            <label class="campo-admin__label" for="slug">Slug</label>
            <input class="campo-admin__field" type="text" id="slug" name="slug" placeholder="Nombre del slug" value="<?php echo s($producto->slug); ?>">
        </div>
       
        <div class="campo-admin">
            <label for="precio" class="campo-admin__label">Precio:</label>
            <input type="number" class="campo-admin__field" id="precio" name="precio" step="0.01" value="<?php echo s($producto->precio); ?>">
        </div>

        <div class="campo-admin">
            <label for="precio_descuento" class="campo-admin__label">Precio Con Descuento:</label>
            <input type="number" class="campo-admin__field" id="precio_descuento" name="precio_descuento" step="0.01" value="<?php echo $producto->precio_descuento === '' ? '0' : s($producto->precio_descuento); ?>">
        </div>

        <div class="campo-admin">
            <label for="tallas" class="campo-admin__label">Tallas disponibles</label>

            <?php foreach ($tallas as $talla): ?>
                <div class="campo-admin__talla">
                    <label><?php echo $talla->nombre; ?></label>
                    <input
                        class="campo-admin__field"
                        type="number"
                        name="tallas[<?php echo $talla->id; ?>]"
                        min="0"
                        value="<?php echo isset($cantidadesTallas[$talla->id]) ? $cantidadesTallas[$talla->id] : 0; ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <div class="campo-admin">
            <label class="campo-admin__label">Colores disponibles</label>
            <?php foreach ($colores as $color): ?>
                <div class="campo-admin__color">
                    <input
                        type="checkbox"
                        name="colores[]"
                        value="<?php echo $color->id; ?>"
                        <?php echo in_array($color->id, $coloresSeleccionados ?? []) ? 'checked' : ''; ?>>
                    <label><?php echo s($color->nombre); ?></label>
                </div>
            <?php endforeach; ?>
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
                <option value="1" <?php echo $producto->activo === '1' ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $producto->activo === '0' ? 'selected' : ''; ?>>No activo</option>
            </select>
        </div>

        <div class="campo-admin">
            <label for="destacado" class="campo-admin__label">Destacado</label>
            <select name="destacado" id="destacado">
                <option value="1" <?php echo $producto->destacado === '1' ? 'selected' : ''; ?>>Destacado</option>
                <option value="0" <?php echo $producto->destacado === '0' ? 'selected' : ''; ?>>No destacado</option>
            </select>
        </div>
        <div class="campo-admin">
            <label for="imagenes" class="campo-admin__label">Imagen</label>
            <input
                type="file"
                class="campo-admin__field"
                id="imagenes"
                name="imagen[]"
                accept="image/*"
                multiple>

            <?php if (!empty($imagenes)): ?>
                <div class="galeria-imagenes">
                    <?php foreach ($imagenes as $imagen): ?>
                        <div class="imagen-previa">
                            <img
                                src="/imagenes/<?php echo $imagen->imagen; ?>"
                                alt="Imagen producto">
                            <label>
                                <input
                                    type="checkbox"
                                    name="eliminar_imagenes[]"
                                    value="<?php echo $imagen->id; ?>">
                                Eliminar
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="descripcion">Descripción</label>
            <textarea class="campo-admin__field campo-admin__field--textarea" id="descripcion" name="descripcion"><?php echo s($producto->descripcion); ?></textarea>
        </div>



    </div>
</div>