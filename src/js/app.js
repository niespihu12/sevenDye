document.addEventListener('DOMContentLoaded', function () {
  if (window.location.pathname !== "/login" && window.location.pathname !== "/register" && window.location.pathname !== "/blog") {
    header();
  }
  if (window.location.pathname === "/") {
    descuento();
    modalProductos();
    community_section();
    ofertas();
    testimoniales();
    weekle_categories();
    slider();
    cambioArrival();
  } else if (window.location.pathname === "/carro") {
    carro();
  } else if (window.location.pathname === "/detail-product") {
    incremento();
  } else if (window.location.pathname === "/register" || window.location.pathname === "/login") {
    login();
  } else if (window.location.pathname === "/categorias/admin" || window.location.pathname === "/influencers/admin" || window.location.pathname === "/testimonios/admin") {
    // logica de javaScript
    admin();
  }
})



function cambioArrival() {
  const categoryButtons = document.querySelectorAll('.arrival__contenido--botones button');

  categoryButtons.forEach(button => {
    button.addEventListener('click', function () {
      const categoriaId = this.getAttribute('data-categoria');
      document.querySelectorAll('.arrival__contenido--productos').forEach(section => {
        section.style.display = 'none';
      });
      document.getElementById('categoria-' + categoriaId).style.display = 'grid';
      categoryButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
    });
  });
  if (categoryButtons.length > 0) {
    categoryButtons[0].classList.add('active');
  }
}


function header() {
  const nav = document.querySelector('#nav-mob');
  const abrir = document.querySelector('#abrir');
  const cerrar = document.querySelector('#cerrar');

  abrir.addEventListener('click', () => {
    nav.classList.add('mostrar');
  });

  cerrar.addEventListener('click', () => {
    nav.classList.remove('mostrar');
  });
}

function testimoniales() {
  jQuery(document).ready(function ($) {
    "use strict";
    $('#customers-testimonials').owlCarousel({
      loop: true,
      center: true,
      items: 3,
      margin: 0,
      autoplay: true,
      dots: true,
      autoplayTimeout: 8500,
      smartSpeed: 450,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1170: {
          items: 3
        }
      }
    });
  });
}

function modalProductos() {
  document.querySelectorAll('.quick-views').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const card = this.closest('.producto');
      const productData = {
        image: card.querySelector('img').src,
        title: card.querySelector('.producto-titulo a').textContent,
        price: card.querySelector('.producto-precio').textContent,
        rating: card.querySelector('.rating-count').textContent
      };

      showQuickViewModal(productData);
    });
  });

  function showQuickViewModal(productData) {
    const modal = document.createElement('div');
    modal.classList.add('quick-view-modal');
    modal.innerHTML = `
        <div class="modal-content">
            <button class="close-modal">&times;</button>
            <div class="modal-body">
                <div class="product-image">
                    <img loading="lazy" width="100" height="100" src="${productData.image}" alt="${productData.title}">
                </div>
                <div class="product-details">
                    <h3>${productData.title}</h3>
                    <div class="price">${productData.price}</div>
                    <div class="rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span>${productData.rating}</span>
                    </div>
                
                    <a class="add-to-cart centrar-texto">Añadir al carrito</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('show'), 100);

    modal.querySelector('.close-modal').addEventListener('click', () => {
      modal.classList.remove('show');
      setTimeout(() => modal.remove(), 300);
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('show');
        setTimeout(() => modal.remove(), 300);
      }
    });

    const quantityInput = modal.querySelector('.quantity-controls input');
    modal.querySelector('.decrease').addEventListener('click', () => {
      if (quantityInput.value > 1) quantityInput.value--;
    });
    modal.querySelector('.increase').addEventListener('click', () => {
      if (quantityInput.value < 10) quantityInput.value++;
    });

    modal.querySelectorAll('.size-options button').forEach(button => {
      button.addEventListener('click', () => {
        modal.querySelectorAll('.size-options button').forEach(btn => {
          btn.classList.remove('selected');
        });
        button.classList.add('selected');
      });
    });
  }


}


function carro() {
  const precioSlider = document.querySelector('.precio-slider input');
  const precioRango = document.querySelector('.precio-rango span');

  if (precioSlider) {
    precioSlider.addEventListener('input', function () {
      precioRango.textContent = `$${this.value} - $565.99`;
    });
  }

  const coloresOpciones = document.querySelectorAll('.color-opcion');

  coloresOpciones.forEach(color => {
    color.addEventListener('click', function () {
      coloresOpciones.forEach(c => c.classList.remove('activo'));
      this.classList.add('activo');
    });
  });
}




function descuento() {
  const dias = document.getElementById('days');
  const horas = document.getElementById('hours');
  const minutos = document.getElementById('minutes');
  const segundos = document.getElementById('seconds');
  const slider = document.querySelector('.dynamic-gallery-slider');

  if (!dias || !horas || !minutos || !segundos || !slider) {
    console.error("Error: No se encontraron los elementos del DOM.");
    return;
  }

  const fechaFin = new Date();
  fechaFin.setDate(fechaFin.getDate() + 6);

  function actualizarTemporizador() {
    const ahora = new Date();
    const tiempoRestante = fechaFin - ahora;

    if (tiempoRestante <= 0) {
      dias.textContent = "00";
      horas.textContent = "00";
      minutos.textContent = "00";
      segundos.textContent = "00";
      clearInterval(intervalo);
      return;
    }

    const d = Math.floor(tiempoRestante / (1000 * 60 * 60 * 24));
    const h = Math.floor((tiempoRestante % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const m = Math.floor((tiempoRestante % (1000 * 60 * 60)) / (1000 * 60));
    const s = Math.floor((tiempoRestante % (1000 * 60)) / 1000);

    dias.textContent = d.toString().padStart(2, '0');
    horas.textContent = h.toString().padStart(2, '0');
    minutos.textContent = m.toString().padStart(2, '0');
    segundos.textContent = s.toString().padStart(2, '0');
  }

  const intervalo = setInterval(actualizarTemporizador, 1000);
  actualizarTemporizador(); // Llamada inicial para evitar el primer segundo vacío

  function moveSlider() {
    const slides = Array.from(slider.children);
    if (slides.length === 0) return;

    const firstSlide = slides.shift();
    firstSlide.style.opacity = "0";
    firstSlide.style.transform = "scale(0.8)";

    setTimeout(() => {
      slider.appendChild(firstSlide);
      slides.push(firstSlide);
      slides.forEach((slide, index) => {
        slide.classList.remove("dynamic-gallery-slide--featured");
        slide.style.opacity = "0.6";
        slide.style.transform = "scale(0.9)";
        if (index === 0) {
          slide.classList.add("dynamic-gallery-slide--featured");
          slide.style.opacity = "1";
          slide.style.transform = "scale(1)";
        }
      });
    }, 500);
  }

  setInterval(moveSlider, 4000);
}


function incremento() {
  const decremento = document.getElementById('decremento')
  const incremento = document.getElementById('incremento')
  const input = document.querySelector('.contador-input')


  decremento.addEventListener("click", (event) => {
    event.preventDefault();
    if (input.value > input.min) {
      input.value = parseInt(input.value) - 1;
    }
  });

  incremento.addEventListener("click", (event) => {
    event.preventDefault();
    if (input.value > input.min) {
      input.value = parseInt(input.value) + 1;
    }
  });
}

function ofertas() {
  const track = document.querySelector('.carousel-track');
  const slides = track.querySelectorAll('.product-card');
  const prevButton = document.querySelector('.carousel-nav .prev');
  const nextButton = document.querySelector('.carousel-nav .next');

  let currentIndex = 0;
  const slidesPerView = window.innerWidth < 768 ? 1 :
    window.innerWidth < 1024 ? 2 : 4;
  const totalSlides = slides.length - slidesPerView;
  let touchStartX = 0;
  let touchEndX = 0;

  function updateCarousel() {
    const slideWidth = slides[0].offsetWidth + 16;
    track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex >= totalSlides;
  }

  function showNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
      notification.classList.add('show');
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
      }, 2000);
    }, 100);
  }

  function showQuickViewModal(productData) {
    const modal = document.createElement('div');
    modal.classList.add('quick-view-modal');
    modal.innerHTML = `
          <div class="modal-content">
              <button class="close-modal">&times;</button>
              <div class="modal-body">
                  <div class="product-image">
                      <img loading="lazy" width="100" height="100" src="${productData.image}" alt="${productData.title}">
                  </div>
                  <div class="product-details">
                      <h3>${productData.title}</h3>
                      <div class="price">${productData.price}</div>
                      <div class="rating">
                          <div class="stars">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                          </div>
                          <span>${productData.rating}</span>
                      </div>
                      <div class="product-description">
                          <p>Chaqueta denim con diseño tie-dye único. Perfecta para un look casual y moderno. Material de alta calidad y confección premium.</p>
                      </div>
                      
                      <button class="add-to-cart centrar-texto">Añadir al carrito</button>
                  </div>
              </div>
          </div>
      `;

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('show'), 100);

    modal.querySelector('.close-modal').addEventListener('click', () => {
      modal.classList.remove('show');
      setTimeout(() => modal.remove(), 300);
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('show');
        setTimeout(() => modal.remove(), 300);
      }
    });

    const quantityInput = modal.querySelector('.quantity-controls input');
    modal.querySelector('.decrease').addEventListener('click', () => {
      if (quantityInput.value > 1) quantityInput.value--;
    });
    modal.querySelector('.increase').addEventListener('click', () => {
      if (quantityInput.value < 10) quantityInput.value++;
    });

    modal.querySelectorAll('.size-options button').forEach(button => {
      button.addEventListener('click', () => {
        modal.querySelectorAll('.size-options button').forEach(btn => {
          btn.classList.remove('selected');
        });
        button.classList.add('selected');
      });
    });
  }

  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0 && currentIndex < totalSlides) {
        currentIndex++;
        updateCarousel();
      } else if (diff < 0 && currentIndex > 0) {
        currentIndex--;
        updateCarousel();
      }
    }
  }

  nextButton.addEventListener('click', () => {
    if (currentIndex < totalSlides) {
      currentIndex++;
      updateCarousel();
    }
  });

  prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateCarousel();
    }
  });

  document.querySelectorAll('.favorite').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      this.classList.toggle('active');

      const icon = this.querySelector('i');
      if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');

        const heart = document.createElement('div');
        heart.classList.add('heart-animation');
        this.appendChild(heart);
        setTimeout(() => heart.remove(), 1000);

        showNotification('¡Añadido a favoritos!');
      } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        showNotification('Eliminado de favoritos');
      }
    });
  });

  document.querySelectorAll('.quick-view').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const card = this.closest('.product-card');
      const productData = {
        image: card.querySelector('img').src,
        title: card.querySelector('.product-title a').textContent,
        price: card.querySelector('.product-price').textContent,
        rating: card.querySelector('.rating-count').textContent
      };

      showQuickViewModal(productData);
    });
  });

  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  });

  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });

  updateCarousel();

  window.addEventListener('resize', () => {
    currentIndex = 0;
    updateCarousel();
  });
}

function community_section() {

  const video = document.querySelector('.featured-video video');
  const videoContainer = document.querySelector('.featured-video');

  const videoOverlay = document.querySelector('.video-overlay');
  const playButton = document.querySelector('.play-button');
  if (videoOverlay) videoOverlay.remove();
  if (playButton) playButton.remove();

  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    );
  }
  function handleVideoPlayback() {
    if (isElementInViewport(videoContainer)) {
      if (video.paused) {
        video.play()
          .catch(error => {
            console.log("Reproducción automática bloqueada por el navegador:", error);
          });
      }
    } else {
      if (!video.paused) {
        video.pause();
      }
    }
  }

  window.addEventListener('scroll', handleVideoPlayback);
  handleVideoPlayback();

}

function weekle_categories() {
  const slider = document.querySelector('.categories-slider');
  const items = slider.querySelectorAll('.category-item');
  const prevButton = document.querySelector('.nav-buttons .prev');
  const nextButton = document.querySelector('.nav-buttons .next');

  let currentIndex = 0;
  const totalItems = items.length;
  let autoplayInterval;
  const autoplayDelay = 3000;

  const firstItemsClone = [...items].slice(0, 4).map(item => item.cloneNode(true));
  firstItemsClone.forEach(clone => slider.appendChild(clone));

  function updateSlider(direction = null) {
    const itemWidth = items[0].offsetWidth + 16;

    if (direction === 'next') {
      currentIndex++;
      if (currentIndex >= totalItems) {
        setTimeout(() => {
          slider.style.transition = 'none';
          currentIndex = 0;
          slider.style.transform = `translateX(0)`;
          setTimeout(() => {
            slider.style.transition = 'transform 0.5s ease';
          }, 50);
        }, 500);
      }
    } else if (direction === 'prev') {
      if (currentIndex <= 0) {
        slider.style.transition = 'none';
        currentIndex = totalItems - 1;
        slider.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        setTimeout(() => {
          slider.style.transition = 'transform 0.5s ease';
          currentIndex--;
        }, 50);
      } else {
        currentIndex--;
      }
    }

    slider.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

    items.forEach((item, index) => {
      if (index === currentIndex % totalItems) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  function startAutoplay() {
    stopAutoplay();
    autoplayInterval = setInterval(() => {
      updateSlider('next');
    }, autoplayDelay);
  }

  function stopAutoplay() {
    clearInterval(autoplayInterval);
  }

  nextButton.addEventListener('click', () => {
    stopAutoplay();
    updateSlider('next');
    startAutoplay();
  });

  prevButton.addEventListener('click', () => {
    stopAutoplay();
    updateSlider('prev');
    startAutoplay();
  });

  const sliderContainer = document.querySelector('.categories-container');
  sliderContainer.addEventListener('mouseenter', stopAutoplay);
  sliderContainer.addEventListener('mouseleave', startAutoplay);

  let touchStartX = 0;
  let touchEndX = 0;

  slider.addEventListener('touchstart', (e) => {
    stopAutoplay();
    touchStartX = e.changedTouches[0].screenX;
  });

  slider.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    startAutoplay();
  });

  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        updateSlider('next');
      } else {
        updateSlider('prev');
      }
    }
  }

  updateSlider();
  startAutoplay();
}


function slider() {
  const textos = document.querySelectorAll('.texto');
  let indiceActual = 0;

  textos[0].classList.add('activo');

  function cambiarTexto() {
    textos[indiceActual].classList.remove('activo');

    indiceActual = (indiceActual + 1) % textos.length;

    textos[indiceActual].classList.add('activo');
  }

  setInterval(cambiarTexto, 3000);
}

function carro() {
  const precioSlider = document.querySelector('.precio-slider input');
  const precioRango = document.querySelector('.precio-rango span');

  if (precioSlider) {
    precioSlider.addEventListener('input', function () {
      precioRango.textContent = `$${this.value} - $565.99`;
    });
  }
  const coloresOpciones = document.querySelectorAll('.color-opcion');

  coloresOpciones.forEach(color => {
    color.addEventListener('click', function () {
      coloresOpciones.forEach(c => c.classList.remove('activo'));
      this.classList.add('activo');
    });
  });
}

function login() {
  const passInputs = document.querySelectorAll('[data-pwd-input]');
  const toggleBtns = document.querySelectorAll('.toggle-password');
  const toggleIcons = document.querySelectorAll('[data-pwd-toggle]');

  passInputs.forEach((input, index) => {
    let showPassword = false;
    const toggleBtn = toggleBtns[index];
    const toggleIcon = toggleIcons[index];

    input.addEventListener('input', () => showToggleButton(input, toggleBtn));

    input.addEventListener('focus', () => {
      showToggleButton(input, toggleBtn);
    });

    toggleBtn.addEventListener('click', () => {
      togglePasswordVisible(input, toggleIcon);
      input.focus();
    });
  });

  function showToggleButton(input, toggleBtn) {
    toggleBtn.style.display = input.value.length > 0 ? 'block' : 'none';
  }

  function togglePasswordVisible(input, toggleIcon) {
    if (input.type === 'password') {
      toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
      input.setAttribute('type', 'text');
    } else {
      toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
      input.setAttribute('type', 'password');
    }
  }
}
