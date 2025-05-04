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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.querySelector('#drop-zone input[type="file"]');
        const previsualizacionContainer = document.getElementById('previsualizacion-container');

        // Manejar el evento de arrastrar y soltar
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                mostrarPrevisualizaciones(fileInput.files);
            }
        });

        // Manejar la selección de archivos
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                mostrarPrevisualizaciones(fileInput.files);
            }
        });

        // Función para mostrar previsualizaciones
        function mostrarPrevisualizaciones(files) {
            previsualizacionContainer.innerHTML = '';

            if (files.length > 0) {
                const titulo = document.createElement('h4');
                titulo.className = 'previsualizacion-titulo';
                titulo.textContent = `Imágenes seleccionadas: ${files.length}`;
                previsualizacionContainer.appendChild(titulo);

                const contenedor = document.createElement('div');
                contenedor.className = 'previsualizacion-grid';
                previsualizacionContainer.appendChild(contenedor);

                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = (e) => {
                            const prevItem = document.createElement('div');
                            prevItem.className = 'previsualizacion-item';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = `Previsualización ${index + 1}`;

                            const nombre = document.createElement('div');
                            nombre.className = 'previsualizacion-nombre';
                            nombre.textContent = file.name.length > 20 ?
                                file.name.substring(0, 17) + '...' :
                                file.name;

                            const tamano = document.createElement('div');
                            tamano.className = 'previsualizacion-tamano';
                            tamano.textContent = formatFileSize(file.size);

                            prevItem.appendChild(img);
                            prevItem.appendChild(nombre);
                            prevItem.appendChild(tamano);

                            contenedor.appendChild(prevItem);
                        };

                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>