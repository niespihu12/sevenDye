<div class="formulario-admin1">

    <div class="form-column1">
        <div class="form-section1">
            <h3 class="form-section-title1">
                <i class="fas fa-info-circle1"></i> Información Básica
            </h3>

            <div class="campo-admin1">
                <label class="campo-admin__label1" for="slug">
                    <i class="fas fa-link"></i> Slug
                </label>
                <input class="campo-admin__field1" type="text" id="slug" name="slug" placeholder="ej: categoria-productos" value="<?php echo s($categoria->slug); ?>">
            </div>

            <div class="campo-admin1">
                <label class="campo-admin__label1" for="nombre">
                    <i class="fas fa-tag1"></i> Nombre
                </label>
                <input class="campo-admin__field1" type="text" id="nombre" name="nombre" placeholder="Nombre de la categoría" value="<?php echo s($categoria->nombre); ?>">
            </div>
            <div class="campo-admin">
                <label for="importante" class="campo-admin__label">Importante</label>
                <select name="importante" id="importante" class="campo-admin__select">
                    <option value="0" <?php echo $categoria->importante === '0' ? 'selected' : ''; ?>>No Importante</option>
                    <option value="1" <?php echo $categoria->importante === '1' ? 'selected' : ''; ?>>Importante</option>
                </select>
            </div>

            <div class="campo-admin1">
                <label class="campo-admin__label1" for="descripcion">
                    <i class="fas fa-align-left1"></i> Descripción
                </label>
                <textarea id="descripcion" class="campo-admin_field campo-admin_field--textarea1" name="descripcion" placeholder="Descripción detallada de la categoría"><?php echo s($categoria->descripcion); ?></textarea>
            </div>
        </div>
    </div>


    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-image"></i> Imagen de Categoría
            </h3>

            <div class="campo-admin">
                <label class="campo-admin__label" for="imagen">
                    <i class="fas fa-cloud-upload-alt"></i> Imagen Principal
                </label>

                <div class="upload-container">
                    <label for="imagen" class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="upload-text">Arrastra tu imagen o haz clic para seleccionar</div>
                        <div class="upload-hint">Formatos soportados: JPG, PNG (Máx. 5MB)</div>
                    </label>
                    <input class="campo-admin__field--archi" type="file" id="imagen" accept="image/jpeg, image/png" name="imagen" style="display: none;">
                </div>

                <?php if ($categoria->imagen) { ?>
                    <div class="imagen-previa-container" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--darker); font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i> Imagen Actual
                        </h4>
                        <div class="imagen-previa">
                            <img src="/imagenes/<?php echo $categoria->imagen; ?>" alt="Imagen actual de la categoría">
                            <div class="imagen-actions">
                                <label>
                                    <input type="checkbox" name="eliminar_imagen"> Eliminar imagen
                                </label>
                                <button type="button" class="btn-zoom" onclick="window.open('/imagenes/<?php echo $categoria->imagen; ?>', '_blank')">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php $script = '<script src="/build/js/formulario.js"></script>'; ?>