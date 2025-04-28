<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<main class="shop">
    <div class="shop-container">
        <div class="sidebar-wrapper">
            <aside class="sidebar">
                <div class="hot-deals">
                    <h2 class="hot-deals__title">Hot Deals</h2>
                    <a class="categories__item" href="/tienda">
                        <span class="name">All</span>
                        <span class="count">2</span>
                    </a>
                    <div class="categories">
                        <?php foreach ($categorias as $categoria): ?>
                            <a class="categories__item" href="/tienda/<?php echo urlencode($categoria->slug); ?>">
                                <span class="name"><?php echo $categoria->nombre ?></span>
                                <span class="count">2</span>
                            </a>

                        <?php endforeach; ?>
                    </div>

                    <div class="prices">
                        <h3 class="prices__title">Prices</h3>
                        <div class="prices__filter-toggle">
                            <input type="checkbox" id="enablePriceFilter" <?php echo $filtro_precio_activo ? 'checked' : ''; ?>>
                            <label for="enablePriceFilter">Enable Price Filter</label>
                        </div>
                        <div class="prices__range">
                            <span>Range:</span>
                            <span><?php echo MONEDA . number_format($precio_min, 2); ?> - <?php echo MONEDA . number_format($precio_max, 2); ?></span>
                        </div>
                        <div class="prices__slider" <?php echo !$filtro_precio_activo ? 'style="opacity: 0.5;"' : ''; ?>>
                            <input type="range" min="<?php echo $min_db; ?>" max="<?php echo $max_db; ?>"
                                value="<?php echo $precio_max; ?>" class="prices__input" id="priceRange"
                                <?php echo !$filtro_precio_activo ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                    <div class="colors">
                        <h3 class="colors__title">Color</h3>
                        <div class="colors__grid">
                            <span class="colors__dot color-all active" data-color-id="0" style="background-color: #ffffff; border: 1px solid #000;"></span>
                            <?php foreach ($colores as $color): ?>
                                <span class="colors__dot <?php echo $color_id == $color->id ? 'active' : ''; ?>"
                                    data-color-id="<?php echo $color->id; ?>"
                                    style="background-color: <?php echo $color->hexadecimal ?>;"></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </aside>

            <div class="more">
                <button class="more-btn">More</button>
            </div>
        </div>

        <div class="producto-car">
            <div class="promo-banner">
                <div class="promo-banner__content">
                    <div class="promo-banner__text">
                        <h2 class="promo-banner__title">Fashion for Everyone,</h2>
                        <h3 class="promo-banner__subtitle">Style Without LIMITS</h3>
                        <p class="promo-banner__description">
                            FOR ALL TASTES, SIZES AND STYLES. OUR COLLECTION OFFERS
                            VIBRANT COLORS, UNIQUE DESIGNS AND OPTIONS FOR EVERY OCCASION,
                            BECAUSE WE BELIEVE THAT FASHION SHOULD BE INCLUSIVE AND FIT
                            YOU.
                        </p>
                        <a href="#" class="promo-banner__button">SHOP NOW</a>
                    </div>
                    <div class="promo-banner__image">
                        <picture>
                            <source srcset="/build/img/chaqueta2.avif" type="image/avif">
                            <source srcset="/build/img/chaqueta2.webp" type="image/webp">
                            <img loading="lazy" width="100" height="100" src="/build/img/chaqueta2.png" alt="Featured jacket" />
                        </picture>

                    </div>
                </div>
            </div>
            <div class="products">

                <?php foreach ($productos as  $producto): ?>
                    <a class="products__card" href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
                        <span class="products__hot">HOT</span>
                        <div class="products__image">
                            <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $imagenes[$producto->id] ?>" alt="<?php $producto->nombre ?>">

                            <div class="products__actions">
                                <button class="action-btn">❤</button>
                            </div>
                        </div>
                        <div class="products__info">
                            <h3 class="products__title">
                                <?php echo $producto->nombre ?>
                            </h3>
                            <div class="products__rating">★★★★★</div>
                            <div class="products__prices">
                                <span class="products__current-price"><?php echo MONEDA . $producto->precio ?></span>
                                <?php if ($producto->precio_descuento > 0): ?>
                                    <span class="products__original-price">$394.33</span>
                                    <span class="products__discount">24% OFF</span>
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
        </div>
    </div>
</main>
<script>
    // Variables globales para los filtros
    let currentCategorySlug = '<?php echo isset($categoria_slug) ? $categoria_slug : ''; ?>';
    let currentMinPrice = <?php echo $precio_min; ?>;
    let currentMaxPrice = <?php echo $precio_max; ?>;
    let currentColorId = <?php echo $color_id; ?>;
    let isPriceFilterActive = <?php echo $filtro_precio_activo ? 'true' : 'false'; ?>;
    const minDbPrice = <?php echo $min_db; ?>;
    const maxDbPrice = <?php echo $max_db; ?>;

    // Función para aplicar todos los filtros
    function applyFilters() {
        let url = currentCategorySlug ? `/tienda/${currentCategorySlug}` : '/tienda';
        let params = [];

        // Añadir filtro de precio solo si está activo
        if (isPriceFilterActive) {
            params.push(`filtro_precio=1`);
            params.push(`precio_min=${currentMinPrice}`);
            params.push(`precio_max=${currentMaxPrice}`);
        }

        // Añadir filtro de color si está seleccionado
        if (currentColorId > 0) {
            params.push(`color=${currentColorId}`);
        }

        // Añadir parámetros a la URL
        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        window.location.href = url;
    }

    // Event listener para el rango de precio
    const rangeInput = document.getElementById('priceRange');
    const priceRangeDisplay = document.querySelector('.prices__range span:last-child');
    const sliderTrack = document.querySelector('.prices__slider');
    const enablePriceFilter = document.getElementById('enablePriceFilter');

    rangeInput.addEventListener('input', function() {
        const value = parseFloat(this.value).toFixed(2);
        const percentage = ((value - this.min) / (this.max - this.min)) * 100;

        // Update the slider appearance
        sliderTrack.style.setProperty('--slider-percentage', `${percentage}%`);

        // Update the displayed price
        priceRangeDisplay.textContent = `<?php echo MONEDA; ?>${currentMinPrice.toFixed(2)} - <?php echo MONEDA; ?>${value}`;

        // Guardar el valor actual
        currentMaxPrice = value;
    });

    // Aplicar el filtro al soltar el deslizador
    rangeInput.addEventListener('change', function() {
        applyFilters();
    });

    // Manejador para activar/desactivar el filtro de precio
    enablePriceFilter.addEventListener('change', function() {
        isPriceFilterActive = this.checked;

        // Actualizar estilos y estado del deslizador
        if (isPriceFilterActive) {
            sliderTrack.style.opacity = '1';
            rangeInput.disabled = false;
        } else {
            sliderTrack.style.opacity = '0.5';
            rangeInput.disabled = true;

            // Resetear a valores por defecto
            currentMinPrice = minDbPrice;
            currentMaxPrice = maxDbPrice;
        }

        // Aplicar filtros
        applyFilters();
    });

    // Event listener para los colores
    const colorDots = document.querySelectorAll('.colors__dot');
    colorDots.forEach(dot => {
        dot.addEventListener('click', function() {
            // Remover clase activa de todos los puntos
            colorDots.forEach(d => d.classList.remove('active'));

            // Añadir clase activa al punto seleccionado
            this.classList.add('active');

            // Actualizar el color seleccionado
            currentColorId = this.dataset.colorId;

            // Aplicar filtros
            applyFilters();
        });
    });

    // Estilo CSS para el deslizador
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .prices__slider {
                position: relative;
                width: 100%;
                height: 2px;
                background-color: #ccc;
                margin: 1.5rem 0;
                --slider-percentage: <?php echo (($precio_max - $min_db) / ($max_db - $min_db)) * 100; ?>%;
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
                font-family: v.$fuente-secundaria;
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
        </style>
    `);
</script>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>