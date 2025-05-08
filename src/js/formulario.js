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