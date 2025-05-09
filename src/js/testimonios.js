document.addEventListener('DOMContentLoaded', function() {
    const testimonialAvatarDrop = document.getElementById('testimonialAvatarDrop');
    const testimonialAvatarInput = document.getElementById('imagen');
    let testimonialAvatarPreview = document.getElementById('testimonialAvatarPreview');
    const testimonialAvatarSize = document.getElementById('testimonialAvatarSize');
    const testimonialAvatarError = document.getElementById('testimonialAvatarError');
    const MAX_FILE_SIZE = 5 * 1024 * 1024; 

    testimonialAvatarInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

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

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];

            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                testimonialAvatarError.textContent = 'Formato no válido. Solo JPG, PNG o WEBP.';
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                testimonialAvatarError.textContent = 'El archivo es demasiado grande (máx 5MB).';
                return;
            }

            testimonialAvatarError.textContent = '';

            testimonialAvatarSize.textContent = formatFileSize(file.size);

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

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    const testimonialTextarea = document.getElementById('mensaje');
    const testimonialCounter = document.getElementById('testimonialCounter');

    if (testimonialTextarea && testimonialCounter) {
        testimonialTextarea.addEventListener('input', function() {
            testimonialCounter.textContent = this.value.length + ' characters';
        });
    }
});