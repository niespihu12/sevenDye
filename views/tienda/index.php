<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<main class="shop-complete">
    <div class="shop-container">

        <button class="filter-toggle-btn" id="filterToggleBtn">
            <div class="filter-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span>Filtros</span>
        </button>


        <div class="mobile-filter-drawer" id="mobileFilterDrawer">
            <div class="drawer-header">
                <h3>Filtros</h3>
                <button class="close-drawer" id="closeDrawer">&times;</button>
            </div>

            <div class="drawer-content">
                <aside class="sidebar-new" id="sidebar">
                    <div class="filter-section">
                        <h2 class="filter-title">Categorías</h2>
                        <div class="categories">
                            <a class="categories__item <?php echo !isset($categoria_slug) ? 'active' : ''; ?>" href="/tienda">
                                <span class="name">Todos</span>
                                <span class="count"><?php echo $productosTotales ?></span>
                            </a>
                            <?php foreach ($categorias as $categoria): ?>
                                <a class="categories__item <?php echo (isset($categoria_slug) && $categoria_slug === $categoria->slug) ? 'active' : ''; ?>"
                                    href="/tienda/<?php echo urlencode($categoria->slug); ?>">
                                    <span class="name"><?php echo $categoria->nombre ?></span>
                                    <span class="count"><?php echo $contadorProductos[$categoria->id] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Precio</h3>
                        <div class="prices">
                            <div class="prices__filter-toggle">
                                <label class="switch">
                                    <input type="checkbox" id="enablePriceFilter" <?php echo $filtro_precio_activo ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span>Filtrar por precio</span>
                            </div>
                            <div class="prices__range">
                                <span class="range-label">Rango:</span>
                                <span class="range-value" id="priceRangeDisplay">
                                    <?php echo MONEDA . number_format($precio_min, 2); ?> - <?php echo MONEDA . number_format($precio_max, 2); ?>
                                </span>
                            </div>
                            <div class="prices__slider">
                                <input type="range" min="<?php echo $min_db; ?>" max="<?php echo $max_db; ?>"
                                    value="<?php echo $precio_max; ?>" class="prices__input" id="priceRange"
                                    <?php echo !$filtro_precio_activo ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Color</h3>
                        <div class="colors">
                            <div class="colors__grid">
                                <span class="colors__dot color-all <?php echo $color_id == 0 ? 'active' : ''; ?>"
                                    data-color-id="0"
                                    style="background-color: #ffffff; border: 1px solid #000;">
                                </span>
                                <?php foreach ($colores as $color): ?>
                                    <span class="colors__dot <?php echo $color_id == $color->id ? 'active' : ''; ?>"
                                        data-color-id="<?php echo $color->id; ?>"
                                        style="background-color: <?php echo $color->hexadecimal ?>;">
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="drawer-footer">
                <button class="btn-apply" id="applyFiltersBtn">Aplicar filtros</button>
                <button class="btn-clear" id="clearFiltersBtn">Limpiar filtros</button>
            </div>
        </div>


        <div class="filter-overlay" id="filterOverlay"></div>

        <section class="products-section">
            <div class="sort-filter-bar">
                <div class="sort-wrapper">
                    <label for="sortOrder">Ordenar:</label>
                    <select id="sortOrder" class="sort-select">
                        <option value="">Por defecto</option>
                        <option value="precio_asc" <?php echo ($orden === 'precio_asc') ? 'selected' : ''; ?>>
                            Precio: Menor a mayor
                        </option>
                        <option value="precio_desc" <?php echo ($orden === 'precio_desc') ? 'selected' : ''; ?>>
                            Precio: Mayor a menor
                        </option>
                    </select>
                </div>
                <div class="results-count">
                    <span><?php echo count($productos); ?> productos encontrados</span>
                </div>
            </div>

            <div class="products">
                <?php foreach ($productos as $producto): ?>
                    <a class="products__card" href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
                        <div class="products__image">
                            <?php if (isset($imagenes[$producto->id])): ?>
                                <img loading="lazy" src="/imagenes/<?php echo $imagenes[$producto->id] ?>" alt="<?php echo $producto->nombre ?>">
                            <?php else: ?>
                                <img loading="lazy" src="/imagenes/no-image.jpg" alt="No disponible">
                            <?php endif; ?>
                        </div>
                        <div class="products__info">
                            <h3 class="products__title"><?php echo $producto->nombre ?></h3>
                            <div class="products__rating">★★★★★</div>
                            <div class="products__prices">
                                <span class="products__current-price"><?php echo MONEDA . $producto->precio ?></span>
                                <?php if (isset($producto->precio_original) && $producto->precio_original > $producto->precio): ?>
                                    <span class="products__original-price"><?php echo MONEDA . $producto->precio_original ?></span>
                                    <span class="products__discount">
                                        <?php echo round(100 - ($producto->precio / $producto->precio_original * 100)) ?>% OFF
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="pagination">
                <span class="pagination__number active">1</span>
                <span class="pagination__number">2</span>
                <span class="pagination__number">3</span>
                <span class="pagination__number">4</span>
                <span class="pagination__number">5</span>
            </div>
        </section>
    </div>
</main>

<script>
    let currentCategorySlug = '<?php echo isset($categoria_slug) ? $categoria_slug : ''; ?>';
    <?php

    $min_db = isset($min_db) ? floatval($min_db) : 0;
    $max_db = isset($max_db) ? floatval($max_db) : 100;
    if ($min_db >= $max_db) {
        $max_db = $min_db + 1;
    }
    $precio_min = isset($precio_min) ? floatval($precio_min) : $min_db;
    $precio_max = isset($precio_max) ? floatval($precio_max) : $max_db;
    $precio_min = max($min_db, $precio_min);
    $precio_max = min($max_db, max($precio_min + 0.01, $precio_max));
    $color_id = isset($color_id) ? intval($color_id) : 0;
    $filtro_precio_activo = isset($filtro_precio_activo) ? boolval($filtro_precio_activo) : false;
    ?>
    let currentMinPrice = <?php echo $precio_min; ?>;
    let currentMaxPrice = <?php echo $precio_max; ?>;
    let currentColorId = <?php echo $color_id; ?>;
    let isPriceFilterActive = <?php echo $filtro_precio_activo ? 'true' : 'false'; ?>;
    const minDbPrice = <?php echo $min_db; ?>;
    const maxDbPrice = <?php echo $max_db; ?>;


    function applyFilters() {
        let url = currentCategorySlug ? `/tienda/${currentCategorySlug}` : '/tienda';
        let params = [];


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

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        console.log("Redirigiendo a:", url);
        window.location.href = url;
    }

    function clearFilters() {
        window.location.href = '/tienda';
    }

    document.addEventListener('DOMContentLoaded', function() {

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


        const rangeInput = document.getElementById('priceRange');
        const priceRangeDisplay = document.getElementById('priceRangeDisplay');
        const enablePriceFilter = document.getElementById('enablePriceFilter');

        if (rangeInput) {
            rangeInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                if (priceRangeDisplay) {
                    priceRangeDisplay.textContent = `<?php echo MONEDA; ?>${currentMinPrice.toFixed(2)} - <?php echo MONEDA; ?>${value.toFixed(2)}`;
                }
                currentMaxPrice = value;
                updateSliderBackground(this);
            });


            rangeInput.addEventListener('change', function() {
                if (isPriceFilterActive) {
                    applyFilters();
                }
            });
        }

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


        const colorDots = document.querySelectorAll('.colors__dot');
        colorDots.forEach(dot => {
            dot.addEventListener('click', function() {
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
            sortOrderSelect.addEventListener('change', function() {

                applyFilters();
            });
        }


        function updateSliderBackground(slider) {
            if (!slider) return;
            const percentage = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
            slider.style.background = `linear-gradient(to right, var(--primary) ${percentage}%, #ddd ${percentage}%)`;
        }


        if (rangeInput) {
            updateSliderBackground(rangeInput);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Configuración de la paginación
        const productsPerPage = 15; // Número de productos por página
        let currentPage = 1;

        // Elementos DOM
        const productsContainer = document.querySelector('.products');
        const paginationContainer = document.querySelector('.pagination');
        const resultsCount = document.querySelector('.results-count span');

        // Productos originales (capturar todos los productos al cargar)
        const allProducts = Array.from(productsContainer.querySelectorAll('.products__card'));
        const totalProducts = allProducts.length;

        // Inicializar paginación
        initPagination();

        // Función para inicializar la paginación
        function initPagination() {
            // Calcular total de páginas
            const totalPages = Math.ceil(totalProducts / productsPerPage);

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

        // Función para ir a una página específica
        function goToPage(pageNumber) {
            currentPage = pageNumber;

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
            resultsCount.textContent = `Mostrando ${Math.min(productsPerPage, endIndex - startIndex)} de ${totalProducts} productos`;

            // Scroll suave al inicio de la sección de productos
            document.querySelector('.products-section').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Integración con el sistema de filtros existente
        const originalApplyFilters = window.applyFilters || function() {};

        // Sobrescribir la función applyFilters para incluir soporte para la página actual
        window.applyFilters = function() {
            let url = currentCategorySlug ? `/tienda/${currentCategorySlug}` : '/tienda';
            let params = [];

            // Añadir parámetros de filtros existentes
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

            // Si estamos en una página diferente a la primera, añadirla como parámetro
            if (currentPage > 1) {
                params.push(`pagina=${currentPage}`);
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            console.log("Redirigiendo a:", url);
            window.location.href = url;
        };

        // Verificar si hay un parámetro de página en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('pagina')) {
            const pageFromUrl = parseInt(urlParams.get('pagina'));
            if (!isNaN(pageFromUrl) && pageFromUrl > 0) {
                // Ir a la página especificada en la URL
                setTimeout(() => goToPage(pageFromUrl), 100);
            }
        }

        // Función para filtrar productos dinámicamente (sin recargar la página)
        window.filterProductsClient = function() {
            // Si queremos implementar filtrado en cliente sin recargar
            // Por ahora, usamos el filtrado del servidor
            applyFilters();
        };

        // Añadir estilos CSS para la paginación
        const style = document.createElement('style');
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
    });
</script>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>