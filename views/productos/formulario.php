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
            <label for="precio" class="campo-admin__label">Precio Base:</label>
            <input type="number" class="campo-admin__field" id="precio" name="precio" step="0.01" value="<?php echo s($producto->precio); ?>">
        </div>

        <div class="campo-admin">
            <label for="cantidad" class="campo-admin__label">Cantidad:</label>
            <input type="number" class="campo-admin__field" id="cantidad" name="cantidad" min="0" value="<?php echo s($producto->cantidad); ?>">
        </div>

        <div class="campo-admin">
            <label for="tallas" class="campo-admin__label">Tallas disponibles</label>

            <?php foreach ($tallas as $talla): ?>
                <div class="campo-admin__talla">
                    <div class="talla-opciones">
                        <div class="talla-nombre">
                            <label><?php echo $talla->nombre; ?></label>
                        </div>
                        <div class="talla-precio">
                            <span>Precio Específico:</span>
                            <input
                                class="campo-admin__field"
                                type="number"
                                name="talla_precios[<?php echo $talla->id; ?>]"
                                step="0.01"
                                placeholder="Precio"
                                value="<?php echo isset($preciosTallas[$talla->id]) ? $preciosTallas[$talla->id] : ''; ?>">
                        </div>
                        <div class="talla-activa">
                            <span>Disponible:</span>
                            <input
                                type="checkbox"
                                name="tallas_activas[]"
                                value="<?php echo $talla->id; ?>"
                                <?php echo in_array($talla->id, $tallasActivas ?? []) ? 'checked' : ''; ?>>
                        </div>
                    </div>
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
                <option value="0" <?php echo $producto->destacado === '0' ? 'selected' : ''; ?>>No destacado</option>
                <option value="1" <?php echo $producto->destacado === '1' ? 'selected' : ''; ?>>Destacado</option>
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

<style>
    .talla-opciones {
        display: grid;
        grid-template-columns: 80px 1fr auto;
        gap: 1rem;
        align-items: center;
        margin-bottom: 0.5rem;
        padding: 0.5rem;
        border-bottom: 1px solid #e9e9e9;
    }

    .talla-nombre {
        font-weight: bold;
    }

    .talla-precio span,
    .talla-activa span {
        display: block;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .talla-activa {
        text-align: center;
    }

    .imagen-previa {
        position: relative;
        border: 1px solid #e1e1e1;
        padding: 0.5rem;
        border-radius: 0.5rem;
    }

    .imagen-previa img {
        width: 100%;
        height: auto;
        display: block;
    }

    .galeria-imagenes {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
</style>