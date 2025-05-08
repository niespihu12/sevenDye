// Variables globales
let currentCategorySlug = '';
let currentMinPrice = 0;
let currentMaxPrice = 0;
let currentColorId = 0;
let isPriceFilterActive = false;
let minDbPrice = 0;
let maxDbPrice = 0;

// Inicializar variables con datos del servidor
function initializeVariables(config) {
    currentCategorySlug = config.categoria_slug || '';
    currentMinPrice = config.precio_min || 0;
    currentMaxPrice = config.precio_max || 100;
    currentColorId = config.color_id || 0;
    isPriceFilterActive = config.filtro_precio_activo || false;
    minDbPrice = config.min_db || 0;
    maxDbPrice = config.max_db || 100;
}

// Aplicar filtros y redireccionar
function applyFilters() {
    let url = currentCategorySlug ? `/tienda/${currentCategorySlug}` : '/tienda';
    let params = [];
    
    // Añadir subcategoría si está seleccionada
    const subcategoria = document.querySelector('.subcategories__item.active')?.dataset.subcategoriaId;
    if(subcategoria) {
        params.push(`subcategoria=${subcategoria}`);
    }

    // Añadir orden si está seleccionado
    const sortOrder = document.getElementById('sortOrder');
    if (sortOrder && sortOrder.value) {
        params.push(`orden=${sortOrder.value}`);
    }

    // Añadir filtro de precio si está activado
    if (isPriceFilterActive) {
        params.push('filtro_precio=1');
        params.push(`precio_min=${currentMinPrice}`);
        params.push(`precio_max=${currentMaxPrice}`);
    }

    // Añadir filtro de color si está seleccionado
    if (currentColorId > 0) {
        params.push(`color=${currentColorId}`);
    }

    // Si estamos en una página diferente a la primera, añadirla como parámetro
    const currentPage = window.paginationState?.currentPage || 1;
    if (currentPage > 1) {
        params.push(`pagina=${currentPage}`);
    }

    // Construir URL con parámetros
    if (params.length > 0) {
        url += '?' + params.join('&');
    }

    // Redireccionar
    window.location.href = url;
}

// Limpiar todos los filtros
function clearFilters() {
    window.location.href = '/tienda';
}

// Actualizar el fondo del slider según el valor
function updateSliderBackground(slider) {
    if (!slider) return;
    const percentage = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.background = `linear-gradient(to right, var(--primary) ${percentage}%, #ddd ${percentage}%)`;
}

// Configuración del Drawer de filtros móvil
function setupFilterDrawer() {
    const filterBtn = document.getElementById('filterToggleBtn');
    const drawer = document.getElementById('mobileFilterDrawer');
    const overlay = document.getElementById('filterOverlay');
    const closeBtn = document.getElementById('closeDrawer');

    function toggleFilter() {
        drawer.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
    }

    if (filterBtn) filterBtn.addEventListener('click', toggleFilter);
    if (closeBtn) closeBtn.addEventListener('click', toggleFilter);
    if (overlay) overlay.addEventListener('click', toggleFilter);
}

// Configuración de los controles de filtros
function setupFilterControls() {
    // Control de rango de precio
    const rangeInput = document.getElementById('priceRange');
    const priceRangeDisplay = document.getElementById('priceRangeDisplay');
    const enablePriceFilter = document.getElementById('enablePriceFilter');

    if (rangeInput) {
        rangeInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (priceRangeDisplay) {
                // Actualizar el texto de visualización
                const moneda = priceRangeDisplay.textContent.trim().charAt(0) || '$';
                priceRangeDisplay.textContent = `${moneda}${currentMinPrice.toFixed(2)} - ${moneda}${value.toFixed(2)}`;
            }
            currentMaxPrice = value;
            updateSliderBackground(this);
        });

        rangeInput.addEventListener('change', function() {
            if (isPriceFilterActive) {
                applyFilters();
            }
        });
        
        // Inicializar el fondo del slider
        updateSliderBackground(rangeInput);
    }

    // Activar/desactivar filtro de precio
    if (enablePriceFilter) {
        enablePriceFilter.addEventListener('change', function() {
            isPriceFilterActive = this.checked;
            if (rangeInput) {
                rangeInput.disabled = !isPriceFilterActive;
                rangeInput.parentElement.style.opacity = isPriceFilterActive ? '1' : '0.5';
            }

            if (!isPriceFilterActive) {
                currentMinPrice = minDbPrice;
                currentMaxPrice = maxDbPrice;
            }

            applyFilters();
        });
    }

    // Selección de color
    const colorDots = document.querySelectorAll('.colors__dot');
    colorDots.forEach(dot => {
        dot.addEventListener('click', function() {
            colorDots.forEach(d => d.classList.remove('active'));
            this.classList.add('active');
            currentColorId = parseInt(this.dataset.colorId) || 0;
            applyFilters();
        });
    });

    // Botones de aplicar y limpiar filtros
    const applyFiltersBtn = document.getElementById('applyFiltersBtn');
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyFilters);
    }

    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearFilters);
    }

    // Ordenamiento
    const sortOrderSelect = document.getElementById('sortOrder');
    if (sortOrderSelect) {
        sortOrderSelect.addEventListener('change', function() {
            applyFilters();
        });
    }
}

// Sistema de paginación
function setupPagination() {
    // Configuración de la paginación
    const productsPerPage = 15; // Número de productos por página
    let currentPage = 1;

    // Elementos DOM
    const productsContainer = document.querySelector('.products');
    const paginationContainer = document.querySelector('.pagination');
    const resultsCount = document.querySelector('.results-count span');

    if (!productsContainer || !paginationContainer) return;

    // Productos originales (capturar todos los productos al cargar)
    const allProducts = Array.from(productsContainer.querySelectorAll('.products__card'));
    const totalProducts = allProducts.length;

    // Guardar estado de paginación para uso global
    window.paginationState = {
        currentPage: 1,
        totalPages: Math.ceil(totalProducts / productsPerPage)
    };

    // Función para ir a una página específica
    function goToPage(pageNumber) {
        currentPage = pageNumber;
        window.paginationState.currentPage = pageNumber;

        // Calcular índices de inicio y fin para los productos a mostrar
        const startIndex = (pageNumber - 1) * productsPerPage;
        const endIndex = Math.min(startIndex + productsPerPage, totalProducts);

        // Ocultar todos los productos
        allProducts.forEach(product => {
            product.style.display = 'none';
        });

        // Mostrar solo los productos de la página actual
        for (let i = startIndex; i < endIndex; i++) {
            if (allProducts[i]) {
                allProducts[i].style.display = 'flex';
            }
        }

        // Actualizar estado activo en la paginación
        const pageNumbers = paginationContainer.querySelectorAll('.pagination__number');
        pageNumbers.forEach((pageNum, index) => {
            pageNum.classList.toggle('active', index + 1 === pageNumber);
        });

        // Actualizar el contador de resultados
        if (resultsCount) {
            resultsCount.textContent = `Mostrando ${Math.min(productsPerPage, endIndex - startIndex)} de ${totalProducts} productos`;
        }

        // Scroll suave al inicio de la sección de productos
        document.querySelector('.products-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Inicializar paginación
    function initPagination() {
        // Calcular total de páginas
        const totalPages = Math.ceil(totalProducts / productsPerPage);
        window.paginationState.totalPages = totalPages;

        if (totalPages <= 1) {
            // Si solo hay una página, ocultar la paginación
            paginationContainer.style.display = 'none';
            return;
        }

        // Limpiar y crear nueva paginación
        paginationContainer.innerHTML = '';

        // Añadir botón anterior
        const prevButton = document.createElement('span');
        prevButton.className = 'pagination__arrow';
        prevButton.innerHTML = '&laquo;';
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
        paginationContainer.appendChild(prevButton);

        // Añadir números de página
        for (let i = 1; i <= totalPages; i++) {
            const pageNumber = document.createElement('span');
            pageNumber.className = 'pagination__number ' + (i === currentPage ? 'active' : '');
            pageNumber.textContent = i;
            pageNumber.addEventListener('click', () => goToPage(i));
            paginationContainer.appendChild(pageNumber);
        }

        // Añadir botón siguiente
        const nextButton = document.createElement('span');
        nextButton.className = 'pagination__arrow';
        nextButton.innerHTML = '&raquo;';
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                goToPage(currentPage + 1);
            }
        });
        paginationContainer.appendChild(nextButton);

        // Mostrar productos de la primera página
        goToPage(1);
    }

    // Añadir estilos CSS para la paginación
    function addPaginationStyles() {
        if (document.getElementById('pagination-styles')) return;
        
        const style = document.createElement('style');
        style.id = 'pagination-styles';
        style.textContent = `
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 2rem;
                gap: 0.5rem;
            }
            
            .pagination__number, .pagination__arrow {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                cursor: pointer;
                transition: all 0.3s ease;
                font-weight: 500;
            }
            
            .pagination__number:hover, .pagination__arrow:hover {
                background-color: var(--primary-light);
                color: var(--dark);
            }
            
            .pagination__number.active {
                background-color: var(--primary);
                color: white;
            }
            
            .pagination__arrow {
                font-size: 1.2rem;
                user-select: none;
            }
            
            @media (max-width: 768px) {
                .pagination__number, .pagination__arrow {
                    width: 2rem;
                    height: 2rem;
                    font-size: 0.9rem;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Verificar si hay un parámetro de página en la URL
    function checkUrlPageParam() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('pagina')) {
            const pageFromUrl = parseInt(urlParams.get('pagina'));
            if (!isNaN(pageFromUrl) && pageFromUrl > 0) {
                // Ir a la página especificada en la URL
                setTimeout(() => goToPage(pageFromUrl), 100);
            }
        }
    }

    // Inicializar todo el sistema de paginación
    addPaginationStyles();
    initPagination();
    checkUrlPageParam();

    // Exportar funciones de paginación para uso global
    window.paginationSystem = {
        goToPage,
        getCurrentPage: () => currentPage
    };
}

// Inicializar todo cuando se carga el documento
document.addEventListener('DOMContentLoaded', function() {
    setupFilterDrawer();
    setupFilterControls();
    setupPagination();
});

// Exportar funciones para uso global
window.tiendaSystem = {
    applyFilters,
    clearFilters,
    initializeVariables
};