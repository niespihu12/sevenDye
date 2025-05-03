document.addEventListener('DOMContentLoaded', function() {
    // Verificar que shopConfig existe para prevenir errores
    if (typeof shopConfig === 'undefined') {
        console.error('Error: shopConfig no está definido');
        return;
    }
    
    // Get elements - con verificación para cada elemento
    const rangeInput = document.getElementById('priceRange');
    const priceRangeDisplay = document.querySelector('.prices__range span:last-child');
    const sliderTrack = document.querySelector('.prices__slider');
    const enablePriceFilter = document.getElementById('enablePriceFilter');
    const sortOrderSelect = document.getElementById('sortOrder');
    const colorDots = document.querySelectorAll('.colors__dot');

    // Initialize variables from PHP
    let currentCategorySlug = shopConfig.categorySlug;
    let currentMinPrice = shopConfig.minPrice;
    let currentMaxPrice = shopConfig.maxPrice;
    let currentColorId = shopConfig.colorId;
    let isPriceFilterActive = shopConfig.isPriceFilterActive;
    const minDbPrice = shopConfig.minDbPrice;
    const maxDbPrice = shopConfig.maxDbPrice;
    const currencySymbol = shopConfig.currencySymbol;

    // Apply filters function con validación de parámetros
    function applyFilters() {
        let url = currentCategorySlug ? `/tienda/${encodeURIComponent(currentCategorySlug)}` : '/tienda';
        let params = [];
        const sortOrder = sortOrderSelect?.value || '';
        
        // Validar la entrada de ordenamiento (solo permitir valores conocidos)
        if (sortOrder && ['precio_asc', 'precio_desc'].includes(sortOrder)) {
            params.push(`orden=${encodeURIComponent(sortOrder)}`);
        }
        
        if (isPriceFilterActive) {
            params.push(`filtro_precio=1`);
            // Validar que sean números antes de añadirlos
            if (!isNaN(currentMinPrice) && !isNaN(currentMaxPrice)) {
                params.push(`precio_min=${parseFloat(currentMinPrice)}`);
                params.push(`precio_max=${parseFloat(currentMaxPrice)}`);
            }
        }
        
        // Validar que colorId sea un número entero positivo
        if (!isNaN(currentColorId) && currentColorId > 0) {
            params.push(`color=${parseInt(currentColorId)}`);
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        window.location.href = url;
    }

    // Event listeners
    if (sortOrderSelect) {
        sortOrderSelect.addEventListener('change', applyFilters);
    }

    if (rangeInput) {
        rangeInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            let percentage = 0;
            
            if (this.max > this.min) {
                percentage = ((value - this.min) / (this.max - this.min)) * 100;
            }
            
            sliderTrack.style.setProperty('--slider-percentage', `${percentage}%`);
            priceRangeDisplay.textContent = `${currencySymbol}${currentMinPrice.toFixed(2)} - ${currencySymbol}${value.toFixed(2)}`;
            currentMaxPrice = value;
        });

        rangeInput.addEventListener('change', function() {
            applyFilters();
        });
    }

    if (enablePriceFilter) {
        enablePriceFilter.addEventListener('change', function() {
            isPriceFilterActive = this.checked;
            
            if (isPriceFilterActive) {
                sliderTrack.style.opacity = '1';
                rangeInput.disabled = false;
            } else {
                sliderTrack.style.opacity = '0.5';
                rangeInput.disabled = true;
                currentMinPrice = minDbPrice;
                currentMaxPrice = maxDbPrice;
            }
            
            applyFilters();
        });
    }

    if (colorDots.length > 0) {
        colorDots.forEach(dot => {
            dot.addEventListener('click', function() {
                colorDots.forEach(d => d.classList.remove('active'));
                this.classList.add('active');
                currentColorId = parseInt(this.dataset.colorId) || 0;
                applyFilters();
            });
        });
    }

    // Add CSS styles
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        .prices__slider {
            position: relative;
            width: 100%;
            height: 2px;
            background-color: #ccc;
            margin: 1.5rem 0;
            --slider-percentage: ${shopConfig.sliderPercentage}%;
            transition: opacity 0.3s;
        }
        
        .prices__slider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: var(--slider-percentage);
            height: 100%;
            background-color: #0077cc;
        }
        
        .prices__slider::after {
            content: '';
            position: absolute;
            left: var(--slider-percentage);
            top: 50%;
            transform: translate(-50%, -50%);
            width: 15px;
            height: 15px;
            background-color: #0077cc;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .prices__input {
            position: absolute;
            top: -8px;
            left: 0;
            width: 100%;
            height: 20px;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }
        
        .prices__filter-toggle {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .prices__filter-toggle input {
            margin-right: 0.5rem;
        }
        
        .colors__dot {
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .colors__dot:hover {
            transform: scale(1.2);
        }
        
        .colors__dot.active {
            border: 2px solid #000;
            transform: scale(1.2);
        }
        
        .color-all {
            position: relative;
        }
        
        .color-all::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, red, orange, yellow, green, blue, indigo, violet);
            border-radius: 50%;
            opacity: 0.5;
        }
    `;
    document.head.appendChild(styleElement);
});