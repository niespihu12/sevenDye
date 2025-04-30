<div class="formulario-color">
    <h2 class="formulario-color__titulo">Gestión de Colores</h2>

    <div>

        <div>
            <div class="campo-color">
                <div class="campo-admin">
                    <label class="campo-admin__label" for="nombre">Name</label>
                    <input class="campo-admin__field" type="text" id="nombre" name="nombre" placeholder="Nombre del color" value="<?php echo s($color->nombre); ?>">
                </div>
            </div>

            <div class="campo-color">
                <div class="campo-admin">
                    <label class="campo-admin__label" for="color">Color</label>
                    <div class="campo-admin__color-wrapper" data-value="<?php echo s($color->hexadecimal); ?>">
                        <input class="campo-admin__color" type="color" name="hexadecimal" id="color" value="<?php echo s($color->hexadecimal); ?>">
                    </div>
                </div>

            </div>

        </div>
        <div>
            <div class="color-preview">
                <span class="color-preview__label">Vista Previa</span>
                <div class="color-preview__box" id="colorPreview" style="background-color: <?php echo s($color->hexadecimal); ?>">
                    <span class="color-preview__box-text">Texto de ejemplo</span>
                </div>

                <div class="color-preview__info">
                    <span class="color-preview__info-item color-preview__info-item--hex" id="hexValue"><?php echo s($color->hexadecimal); ?></span>
                    <span class="color-preview__info-item color-preview__info-item--rgb" id="rgbValue">RGB: 255, 255, 255</span>
                    <span class="color-preview__info-item color-preview__info-item--hsl" id="hslValue">HSL: 0, 0%, 100%</span>
                </div>
            </div>
            <div class="similar-colors">
                <h3 class="similar-colors__title">Colores Similares</h3>
                <div class="similar-colors__grid" id="similarColors">
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="formulario-admin__actions">
        <a type="button" class="btn btn--cancelar" href="/colores/admin">Cancelar</a>
        <button type="submit" class="btn btn--guardar">Guardar Color</button>
    </div>
</div>