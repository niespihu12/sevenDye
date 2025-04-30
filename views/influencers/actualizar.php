<?php include_once __DIR__ . "/../templates/admin-header.php"; ?>
<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/influencers/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>

    <div  class="seccion-admin" class="profile-form-wide">
        <h1>Actualizar Influencer</h1>

        <form method="POST" enctype="multipart/form-data" class="profile-card-wide">
            <?php include __DIR__ . "/formulario.php"; ?>
            <input class="boton-primario" type="submit" value="Actualizar Influencer">
        </form>
    </div>

</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Avatar upload functionality
  const avatarDrop = document.getElementById('avatarDrop');
  const avatarInput = document.getElementById('imagen');
  let avatarPreview = document.getElementById('avatarPreview');
  const avatarSize = document.getElementById('avatarSize');
  const avatarError = document.getElementById('avatarError');
  const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

  // Handle file selection
  avatarInput.addEventListener('change', function(e) {
    handleFiles(e.target.files);
  });

  // Drag and drop functionality
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    avatarDrop.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    avatarDrop.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    avatarDrop.addEventListener(eventName, unhighlight, false);
  });

  function highlight() {
    avatarDrop.classList.add('highlight');
  }

  function unhighlight() {
    avatarDrop.classList.remove('highlight');
  }

  avatarDrop.addEventListener('drop', function(e) {
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
        avatarError.textContent = 'Formato no válido. Solo JPG, PNG o WEBP.';
        return;
      }
      
      // Validate file size
      if (file.size > MAX_FILE_SIZE) {
        avatarError.textContent = 'El archivo es demasiado grande (máx 5MB).';
        return;
      }
      
      avatarError.textContent = '';
      
      // Display file size
      avatarSize.textContent = formatFileSize(file.size);
      
      // Preview the image
      const reader = new FileReader();
      reader.onload = function(e) {
        if (avatarPreview.tagName === 'IMG') {
          avatarPreview.src = e.target.result;
        } else {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'profile-avatar-upload-wide__img';
          img.id = 'avatarPreview';
          avatarPreview.replaceWith(img);
          avatarPreview = img;
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

  // Character counter for description
  const descTextarea = document.getElementById('descripcion');
  const descCounter = document.getElementById('descCounter');
  
  if (descTextarea && descCounter) {
    descTextarea.addEventListener('input', function() {
      const currentLength = this.value.length;
      descCounter.textContent = `${currentLength}/300`;
      
      if (currentLength >= 300) {
        descCounter.style.color = '#ff0000';
      } else {
        descCounter.style.color = '#808080';
      }
    });
    
    // Initialize counter
    descTextarea.dispatchEvent(new Event('input'));
  }
});
</script>
<?php include_once __DIR__ . "/../templates/admin-footer.php"; ?>