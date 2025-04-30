<?php include __DIR__ . "/../templates/admin-header.php"; ?>
<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/testimonios/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>
    <div class="seccion-admin">
        <form method="POST" enctype="multipart/form-data" id="testimonialForm" class="testimonial-card-wide">
            <?php include __DIR__ . "/formulario.php"; ?>
        </form>

    </div>

</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar upload functionality
        const testimonialAvatarDrop = document.getElementById('testimonialAvatarDrop');
        const testimonialAvatarInput = document.getElementById('imagen');
        let testimonialAvatarPreview = document.getElementById('testimonialAvatarPreview');
        const testimonialAvatarSize = document.getElementById('testimonialAvatarSize');
        const testimonialAvatarError = document.getElementById('testimonialAvatarError');
        const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

        // Handle file selection
        testimonialAvatarInput.addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            testimonialAvatarDrop.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            testimonialAvatarDrop.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            testimonialAvatarDrop.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            testimonialAvatarDrop.classList.add('highlight');
        }

        function unhighlight() {
            testimonialAvatarDrop.classList.remove('highlight');
        }

        testimonialAvatarDrop.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        });

        // Handle the selected files
        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    testimonialAvatarError.textContent = 'Formato no válido. Solo JPG, PNG o WEBP.';
                    return;
                }

                // Validate file size
                if (file.size > MAX_FILE_SIZE) {
                    testimonialAvatarError.textContent = 'El archivo es demasiado grande (máx 5MB).';
                    return;
                }

                testimonialAvatarError.textContent = '';

                // Display file size
                testimonialAvatarSize.textContent = formatFileSize(file.size);

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (testimonialAvatarPreview.tagName === 'IMG') {
                        testimonialAvatarPreview.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'testimonial-avatar-upload-wide__img';
                        img.id = 'testimonialAvatarPreview';
                        testimonialAvatarPreview.replaceWith(img);
                        testimonialAvatarPreview = img;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Character counter for testimonial
        const testimonialTextarea = document.getElementById('mensaje');
        const testimonialCounter = document.getElementById('testimonialCounter');

        if (testimonialTextarea && testimonialCounter) {
            testimonialTextarea.addEventListener('input', function() {
                testimonialCounter.textContent = this.value.length + ' characters';
            });
        }
    });
</script>
<?php include __DIR__ . "/../templates/admin-footer.php"; ?>