<div class="formulario-admin">
    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-info-circle"></i> Información Básica
            </h3>

            <div class="campo-admin">
                <label class="campo-admin__label" for="nombre">
                    <i class="fas fa-tag"></i> Nombre
                </label>
                <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Nombre de la subcategoría" value="<?php echo s($subcategoria->nombre); ?>" required>
            </div>

            <div class="campo-admin">
                <label class="campo-admin__label" for="descripcion">
                    <i class="fas fa-align-left"></i> Descripción
                </label>
                <textarea id="descripcion" class="campo-admin__field campo-admin__field--textarea" name="descripcion" placeholder="Descripción detallada de la subcategoría" required><?php echo s($subcategoria->descripcion); ?></textarea>
            </div>

            <div class="campo-admin">
                <label class="campo-admin__label" for="categorias_id">
                    <i class="fas fa-folder"></i> Categoría
                </label>
                <select class="campo-admin__select" id="categorias_id" name="categorias_id" required>
                    <option value="">-- Seleccionar Categoría --</option>
                    <?php foreach($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->id; ?>" <?php echo $subcategoria->categorias_id == $categoria->id ? 'selected' : ''; ?>>
                            <?php echo $categoria->nombre; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>