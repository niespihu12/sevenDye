document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.collection-slider');
    const slides = document.querySelectorAll('.collection-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentSlide = 0;
    const slideCount = slides.length;

    // Show initial slide
    updateSlider();

    // Handle dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
        });
    });

    // Handle prev/next buttons
    prevBtn.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slideCount) % slideCount;
        updateSlider();
    });

    nextBtn.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlider();
    });

    // Update slider position and active state
    function updateSlider() {
        // Update slider position
        const translateValue = -currentSlide * 100;
        slider.style.transform = `translateX(${translateValue}%)`;

        // Update active dot
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Auto-advance slides every 5 seconds
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlider();
    }, 5000);
});