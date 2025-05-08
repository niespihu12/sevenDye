<div class="formulario-admin">
    <div class="formulario-columna">
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
            <label for="categoria" class="campo-admin__label">Categoria</label>
            <div class="select-wrapper">
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
        </div>

        <div class="campo-admin">
            <label for="subcategoria" class="campo-admin__label">Subcategoria</label>
            <div class="select-wrapper">
                <select name="subcategorias_id" id="subcategoria">
                    <option value="">--Seleccione primero una categoría--</option>
                    <?php foreach ($subcategorias as $subcategoria) { ?>
                        <option
                            <?php echo ($producto->subcategorias_id === $subcategoria->id) ? 'selected' : ''; ?>
                            value="<?php echo s($subcategoria->id) ?>">
                            <?php echo s($subcategoria->nombre) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="campo-admin">
            <label for="activo" class="campo-admin__label">Estado</label>
            <div class="select-wrapper">
                <select name="activo" id="activo">
                    <option value="1" <?php echo $producto->activo === '1' ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo $producto->activo === '0' ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
        </div>

        <div class="campo-admin">
            <label for="destacado" class="campo-admin__label">Destacado</label>
            <div class="select-wrapper">
                <select name="destacado" id="destacado">
                    <option value="0" <?php echo $producto->destacado === '0' ? 'selected' : ''; ?>>No destacado</option>
                    <option value="1" <?php echo $producto->destacado === '1' ? 'selected' : ''; ?>>Destacado</option>
                </select>
            </div>
        </div>
    </div>

    <div class="formulario-columna">
        <div class="campo-admin">
            <label class="campo-admin__label">Colores disponibles</label>
            <div class="colores-container">
                <?php foreach ($colores as $color): ?>
                    <div class="campo-admin__color">
                        <label class="color-checkbox">
                            <input
                                type="checkbox"
                                name="colores[]"
                                value="<?php echo $color->id; ?>"
                                <?php echo in_array($color->id, $coloresSeleccionados ?? []) ? 'checked' : ''; ?>>
                            <span class="checkmark"></span>
                            <span class="color-name"><?php echo s($color->nombre); ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
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
                            <span>Precio:</span>
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
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    name="tallas_activas[]"
                                    value="<?php echo $talla->id; ?>"
                                    <?php echo in_array($talla->id, $tallasActivas ?? []) ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="campo-admin">
            <label class="campo-admin__label" for="descripcion">Descripción</label>
            <textarea class="campo-admin__field campo-admin__field--textarea" id="descripcion" name="descripcion"><?php echo s($producto->descripcion); ?></textarea>
        </div>
    </div>

    <div class="campo-admin campo-admin__imagenes">
        <label class="campo-admin__label">Imágenes del Producto (Puedes subir varias a la vez)</label>
        <div class="drop-zone" id="drop-zone">
            <div class="drop-icon">📷📷📷</div>
            <div class="drop-text">Arrastra múltiples imágenes aquí</div>
            <div class="drop-subtext">o haz clic para seleccionar archivos (Ctrl+Click para seleccionar varias)</div>
            <input
                type="file"
                id="imagenes"
                name="imagen[]"
                accept="image/*"
                multiple>
        </div>

        <div class="previsualizacion-container" id="previsualizacion-container">
            <!-- Aquí se mostrarán las previsualizaciones -->
        </div>

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
</div>

<?php $script= "<script src='/build/js/productos.js'></script>"; ?>