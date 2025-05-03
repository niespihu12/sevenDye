<div class="formulario-admin1">
    <div class="form-column1">
        <div class="form-section1">
            <h3 class="form-section-title1">
                <i class="fas fa-info-circle1"></i> Información Básica
            </h3>

            <div class="campo-admin1">
                <label class="campo-admin__label1" for="titulo">
                    <i class="fas fa-heading"></i> Título
                </label>
                <input class="campo-admin__field1" type="text" id="titulo" name="titulo" placeholder="Título de la publicación" value="<?php echo s($blog->titulo); ?>">
            </div>

            <div class="campo-admin1">
                <label class="campo-admin__label1" for="slug">
                    <i class="fas fa-link"></i> Slug
                </label>
                <input class="campo-admin__field1" type="text" id="slug" name="slug" placeholder="ej: mi-articulo-de-blog" value="<?php echo s($blog->slug); ?>">
            </div>

            <div class="campo-admin">
                <label for="activo" class="campo-admin__label">Estado</label>
                <select name="activo" id="activo" class="campo-admin__select">
                    <option value="0" <?php echo $blog->activo === '0' ? 'selected' : ''; ?>>Borrador</option>
                    <option value="1" <?php echo $blog->activo === '1' ? 'selected' : ''; ?>>Publicado</option>
                </select>
            </div>
            <div class="campo-admin">
                <label for="categoria" class="campo-admin__label">Categorias</label>
                <select name="blog_categorias_id" id="categoria"  class="campo-admin__select">
                    <option selected value="">--Seleccione--</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option
                            <?php echo $blog->blog_categorias_id === $categoria->id ? 'selected' : ''; ?>
                            value="<?php echo s($categoria->id) ?>">
                            <?php echo s($categoria->nombre) ?>
                        </option>
                    <?php } ?>
                </select>

            </div>


            <div class="campo-admin1">
                <label class="campo-admin__label1" for="contenido">
                    <i class="fas fa-align-left1"></i> Contenido
                </label>
                <div class="editor-container">
                    <!-- Barra de herramientas del editor -->
                    <div class="editor-toolbar">
                        <button type="button" class="toolbar-btn" data-command="bold"><i class="fas fa-bold"></i></button>
                        <button type="button" class="toolbar-btn" data-command="italic"><i class="fas fa-italic"></i></button>
                        <button type="button" class="toolbar-btn" data-command="underline"><i class="fas fa-underline"></i></button>
                        <button type="button" class="toolbar-btn" data-command="justifyLeft"><i class="fas fa-align-left"></i></button>
                        <button type="button" class="toolbar-btn" data-command="justifyCenter"><i class="fas fa-align-center"></i></button>
                        <button type="button" class="toolbar-btn" data-command="justifyRight"><i class="fas fa-align-right"></i></button>
                        <button type="button" class="toolbar-btn" data-command="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                        <button type="button" class="toolbar-btn" data-command="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                        <button type="button" class="toolbar-btn" data-command="createLink"><i class="fas fa-link"></i></button>
                        <button type="button" class="toolbar-btn" data-command="insertImage"><i class="fas fa-image"></i></button>
                        <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="H1"><i class="fas fa-heading"></i></button>
                        <button type="button" class="toolbar-btn" data-command="undo"><i class="fas fa-undo"></i></button>
                        <button type="button" class="toolbar-btn" data-command="redo"><i class="fas fa-redo"></i></button>
                    </div>

                    <!-- Área de edición de contenido -->
                    <div id="editor-content" class="editor-content" contenteditable="true"><?php echo $blog->contenido; ?></div>

                    <!-- Campo oculto para enviar el contenido HTML -->
                    <textarea name="contenido" id="contenido-hidden" style="display: none;"><?php echo s($blog->contenido); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-image"></i> Imagen Principal
            </h3>

            <div class="campo-admin">
                <label class="campo-admin__label" for="imagen">
                    <i class="fas fa-cloud-upload-alt"></i> Selecciona una imagen
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

                <?php if ($blog->imagen) { ?>
                    <div class="imagen-previa-container" style="margin-top: 2rem;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--darker); font-weight: 600;">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i> Imagen Actual
                        </h4>
                        <div class="imagen-previa">
                            <img src="/imagenes/<?php echo $blog->imagen; ?>" alt="Imagen actual del blog">
                            <div class="imagen-actions">
                                <label>
                                    <input type="checkbox" name="eliminar_imagen"> Eliminar imagen
                                </label>
                                <button type="button" class="btn-zoom" onclick="window.open('/imagenes/<?php echo $blog->imagen; ?>', '_blank')">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Funcionalidad del área de carga de imágenes
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('imagen');

        if (uploadArea && fileInput) {
            // Cambiar estilo al arrastrar sobre el área
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('active');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('active');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('active');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileName();
                }
            });

            // Cambiar estilo al seleccionar archivo
            fileInput.addEventListener('change', updateFileName);

            function updateFileName() {
                if (fileInput.files.length) {
                    const fileName = fileInput.files[0].name;
                    uploadArea.querySelector('.upload-text').textContent = fileName;
                    uploadArea.querySelector('.upload-icon').innerHTML = '<i class="fas fa-check-circle" style="color: var(--success);"></i>';
                }
            }
        }

        // Funcionalidad del editor de texto enriquecido
        const toolbar = document.querySelectorAll('.toolbar-btn');
        const editorContent = document.getElementById('editor-content');
        const hiddenInput = document.getElementById('contenido-hidden');

        // Inicializar con el contenido existente
        editorContent.innerHTML = hiddenInput.value;

        // Función para actualizar el campo oculto antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function() {
            hiddenInput.value = editorContent.innerHTML;
        });

        // Configurar botones de la barra de herramientas
        toolbar.forEach(item => {
            item.addEventListener('click', function() {
                const command = this.dataset.command;
                const value = this.dataset.value || null;

                if (command === 'createLink') {
                    const url = prompt('Ingresa la URL del enlace:', 'https://');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else if (command === 'insertImage') {
                    const imageUrl = prompt('Ingresa la URL de la imagen:', 'https://');
                    if (imageUrl) {
                        document.execCommand(command, false, imageUrl);
                    }
                } else if (command === 'formatBlock') {
                    document.execCommand(command, false, value);
                } else {
                    document.execCommand(command, false, null);
                }

                // Actualizar el campo oculto después de cada cambio
                hiddenInput.value = editorContent.innerHTML;
            });
        });

        // Generar slug automáticamente a partir del título
        const tituloInput = document.getElementById('titulo');
        const slugInput = document.getElementById('slug');

        if (tituloInput && slugInput) {
            tituloInput.addEventListener('blur', function() {
                if (!slugInput.value.trim()) {
                    slugInput.value = tituloInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            });
        }
    });
</script>

<style>
    .editor-container {
        display: flex;
        flex-direction: column;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .editor-toolbar {
        display: flex;
        flex-wrap: wrap;
        padding: 8px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }

    .toolbar-btn {
        width: 32px;
        height: 32px;
        margin: 2px;
        border: 1px solid #ccc;
        background-color: white;
        border-radius: 3px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toolbar-btn:hover {
        background-color: #e9e9e9;
    }

    .editor-content {
        min-height: 300px;
        padding: 15px;
        background-color: white;
        overflow-y: auto;
        line-height: 1.5;
    }

    .editor-content:focus {
        outline: none;
    }
</style>