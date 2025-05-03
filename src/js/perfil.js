document.addEventListener('DOMContentLoaded', function() {
 
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('active');
      });
      input.addEventListener('blur', function() {
        if (!this.value) {
          this.parentElement.classList.remove('active');
        }
      });
     
      if (input.value) {
        input.parentElement.classList.add('active');
      }
    });
  
  
    const inputImagen = document.getElementById('imagen');
    const previewImagen = document.querySelector('.form-group__imagen img') || document.querySelector('.form-group__imagen .no-image');
    
    inputImagen.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
       
          if (previewImagen.tagName === 'IMG') {
            previewImagen.src = e.target.result;
          } else {
        
            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.alt = 'Vista previa';
            previewImagen.parentElement.replaceChild(imgElement, previewImagen);
          }
        }
        reader.readAsDataURL(file);
      }
    });
  
  
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
      button.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
      });
      button.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
      });
    });
  
  
    inputs.forEach(input => {
      if (!input.disabled) {
        input.addEventListener('input', function() {
          this.style.borderColor = '#FF77E5';
        });
      }
    });
  
  
    const profileImage = document.querySelector('.user-avatar img') || document.querySelector('.avatar-placeholder');
    if (profileImage) {
      profileImage.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1) rotate(5deg)';
        this.style.transition = 'all 0.5s ease';
      });
      profileImage.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1) rotate(0deg)';
      });
    }
  });