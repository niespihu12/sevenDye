<div class="formulario-admin1">

    <div class="form-column1">
        <div class="form-section1">
            <div class="campo-admin">
                <label class="campo-admin__label" for="email">
                     Email
                </label>
                <input class="campo-admin__field" type="email" id="email" name="email" value="<?php echo s($usuario->email); ?>">
            </div>
            <div class="campo-admin">
            <label for="rol" class="campo-admin__label">Categoria</label>
            <select name="rolId" id="rol" class="campo_admin__select">
                <option selected value="">--Seleccione--</option>
                <?php foreach ($roles as $rol) { ?>
                    <option
                        <?php echo $usuario->rolId === $rol->id ? 'selected' : ''; ?>
                        value="<?php echo s($rol->id) ?>">
                        <?php echo s($rol->nombre) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        </div>
    </div>


    
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>