let currentCategorySlug = '';
let currentMinPrice = 0;
let currentMaxPrice = 0;
let currentColorId = 0;
let isPriceFilterActive = false;
let minDbPrice = 0;
let maxDbPrice = 0;


function initializeVariables(config) {
    currentCategorySlug = config.categoria_slug || '';
    currentMinPrice = config.precio_min || 0;
    currentMaxPrice = config.precio_max || 100;
    currentColorId = config.color_id || 0;
    isPriceFilterActive = config.filtro_precio_activo || false;
    minDbPrice = config.min_db || 0;
    maxDbPrice = config.max_db || 100;
}

function applyFilters() {
    let url = currentCategorySlug ? `/store/${currentCategorySlug}` : '/store';
    let params = [];


    const subcategoria = document.querySelector('.subcategories__item.active')?.dataset.subcategoriaId;
    if (subcategoria) {
        params.push(`subcategoria=${subcategoria}`);
    }

    const sortOrder = document.getElementById('sortOrder');
    if (sortOrder && sortOrder.value) {
        params.push(`orden=${sortOrder.value}`);
    }

    if (isPriceFilterActive) {
        params.push('filtro_precio=1');
        params.push(`precio_min=${currentMinPrice}`);
        params.push(`precio_max=${currentMaxPrice}`);
    }

    if (currentColorId > 0) {
        params.push(`color=${currentColorId}`);
    }

    const currentPage = window.paginationState?.currentPage || 1;
    if (currentPage > 1) {
        params.push(`pagina=${currentPage}`);
    }

    if (params.length > 0) {
        url += '?' + params.join('&');
    }

    window.location.href = url;
}

function clearFilters() {
    window.location.href = '/store';
}

function updateSliderBackground(slider) {
    if (!slider) return;
    const percentage = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.background = `linear-gradient(to right, var(--primary) ${percentage}%, #ddd ${percentage}%)`;
}

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

function setupFilterControls() {
    const rangeInput = document.getElementById('priceRange');
    const priceRangeDisplay = document.getElementById('priceRangeDisplay');
    const enablePriceFilter = document.getElementById('enablePriceFilter');

    if (rangeInput) {
        rangeInput.addEventListener('input', function () {
            const value = parseFloat(this.value);
            if (priceRangeDisplay) {
                const moneda = priceRangeDisplay.textContent.trim().charAt(0) || '$';
                priceRangeDisplay.textContent = `${moneda}${currentMinPrice.toFixed(2)} - ${moneda}${value.toFixed(2)}`;
            }
            currentMaxPrice = value;
            updateSliderBackground(this);
        });

        rangeInput.addEventListener('change', function () {
            if (isPriceFilterActive) {
                applyFilters();
            }
        });

        updateSliderBackground(rangeInput);
    }

    if (enablePriceFilter) {
        enablePriceFilter.addEventListener('change', function () {
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

    const colorDots = document.querySelectorAll('.colors__dot');
    colorDots.forEach(dot => {
        dot.addEventListener('click', function () {
            colorDots.forEach(d => d.classList.remove('active'));
            this.classList.add('active');
            currentColorId = parseInt(this.dataset.colorId) || 0;
            applyFilters();
        });
    });

    const applyFiltersBtn = document.getElementById('applyFiltersBtn');
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyFilters);
    }

    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearFilters);
    }

    const sortOrderSelect = document.getElementById('sortOrder');
    if (sortOrderSelect) {
        sortOrderSelect.addEventListener('change', function () {
            applyFilters();
        });
    }
}

function setupPagination() {
    const productsPerPage = 15;
    let currentPage = 1;

    const productsContainer = document.querySelector('.products');
    const paginationContainer = document.querySelector('.pagination');
    const resultsCount = document.querySelector('.results-count span');

    if (!productsContainer || !paginationContainer) return;

    const allProducts = Array.from(productsContainer.querySelectorAll('.products__card'));
    const totalProducts = allProducts.length;

    window.paginationState = {
        currentPage: 1,
        totalPages: Math.ceil(totalProducts / productsPerPage)
    };

    function goToPage(pageNumber) {
        currentPage = pageNumber;
        window.paginationState.currentPage = pageNumber;

        const startIndex = (pageNumber - 1) * productsPerPage;
        const endIndex = Math.min(startIndex + productsPerPage, totalProducts);

        allProducts.forEach(product => {
            product.style.display = 'none';
        });
        for (let i = startIndex; i < endIndex; i++) {
            if (allProducts[i]) {
                allProducts[i].style.display = 'flex';
            }
        }
        const pageNumbers = paginationContainer.querySelectorAll('.pagination__number');
        pageNumbers.forEach((pageNum, index) => {
            pageNum.classList.toggle('active', index + 1 === pageNumber);
        });

        if (resultsCount) {
            resultsCount.textContent = `Mostrando ${Math.min(productsPerPage, endIndex - startIndex)} de ${totalProducts} productos`;
        }

        document.querySelector('.products-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function initPagination() {
        const totalPages = Math.ceil(totalProducts / productsPerPage);
        window.paginationState.totalPages = totalPages;

        if (totalPages <= 1) {
            paginationContainer.style.display = 'none';
            return;
        }

        paginationContainer.innerHTML = '';

        const prevButton = document.createElement('span');
        prevButton.className = 'pagination__arrow';
        prevButton.innerHTML = '&laquo;';
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
        paginationContainer.appendChild(prevButton);

        for (let i = 1; i <= totalPages; i++) {
            const pageNumber = document.createElement('span');
            pageNumber.className = 'pagination__number ' + (i === currentPage ? 'active' : '');
            pageNumber.textContent = i;
            pageNumber.addEventListener('click', () => goToPage(i));
            paginationContainer.appendChild(pageNumber);
        }

        const nextButton = document.createElement('span');
        nextButton.className = 'pagination__arrow';
        nextButton.innerHTML = '&raquo;';
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                goToPage(currentPage + 1);
            }
        });
        paginationContainer.appendChild(nextButton);

        goToPage(1);
    }
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

    function checkUrlPageParam() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('pagina')) {
            const pageFromUrl = parseInt(urlParams.get('pagina'));
            if (!isNaN(pageFromUrl) && pageFromUrl > 0) {
                setTimeout(() => goToPage(pageFromUrl), 100);
            }
        }
    }
    addPaginationStyles();
    initPagination();
    checkUrlPageParam();

    window.paginationSystem = {
        goToPage,
        getCurrentPage: () => currentPage
    };
}

document.addEventListener('DOMContentLoaded', function () {
    setupFilterDrawer();
    setupFilterControls();
    setupPagination();
});

window.tiendaSystem = {
    applyFilters,
    clearFilters,
    initializeVariables
};
document.querySelectorAll('.favorite').forEach(button => {
    button.addEventListener('click', async function (e) {
        e.preventDefault();
        e.stopPropagation();

        const icon = this.querySelector('i');
        const isInWishlist = icon.classList.contains('fas');
        const producto = this.dataset.producto;

        // Add click animation
        this.classList.add('clicked');
        setTimeout(() => this.classList.remove('clicked'), 300);

        try {
            let url, method;

            if (isInWishlist) {
                url = '/wishlist/delete';
                method = 'POST';
            } else {
                url = '/wishlist/save';
                method = 'POST';
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    producto
                })
            });

            const data = await response.json();

            if (data.resultado) {
                if (isInWishlist) {
                    icon.classList.replace('fas', 'far');
                    this.classList.remove('active');
                    showNotification(data.mensaje || 'Eliminado de favoritos');
                } else {
                    icon.classList.replace('far', 'fas');
                    this.classList.add('active');

                    // Add heart animation
                    const heart = document.createElement('div');
                    heart.classList.add('heart-animation');
                    this.appendChild(heart);
                    setTimeout(() => heart.remove(), 1000);

                    showNotification(data.mensaje || '¡Añadido a favoritos!');
                }
            } else {
                if (data.mensaje == 'Usuario no autenticado') {
                    window.location.href = "/login";
                } else {
                    alert(data.mensaje || 'An error occurred');
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});