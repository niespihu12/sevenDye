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
                    <!-- Sección de Categorías -->
                    <div class="filter-section">
                        <h2 class="filter-title">Categorías</h2>
                        <div class="categories">
                            <a class="categories__item <?php echo !isset($categoria_slug) ? 'active' : ''; ?>" href="/store">
                                <span class="name">Todos</span>
                                <span class="count"><?php echo $productosTotales ?></span>
                            </a>
                            <?php foreach ($categorias as $categoria): ?>
                                <a class="categories__item <?php echo (isset($categoria_slug) && $categoria_slug === $categoria->slug) ? 'active' : ''; ?>"
                                    href="/store/<?php echo urlencode($categoria->slug); ?>">
                                    <span class="name"><?php echo $categoria->nombre ?></span>
                                    <span class="count"><?php echo $contadorProductos[$categoria->id] ?></span>
                                </a>

                                <!-- Subcategorías -->
                                <?php if (isset($categoria_slug) && $categoria_slug === $categoria->slug && !empty($subcategorias)): ?>
                                    <div class="subcategories">
                                        <?php foreach ($subcategorias as $subcategoria): ?>
                                            <a class="subcategories__item <?php echo (isset($_GET['subcategoria']) && $_GET['subcategoria'] == $subcategoria->id) ? 'active' : ''; ?>"
                                                href="/store/<?php echo $categoria->slug; ?>?subcategoria=<?php echo $subcategoria->id; ?>"
                                                data-subcategoria-id="<?php echo $subcategoria->id; ?>">
                                                <span class="name"><?php echo $subcategoria->nombre ?></span>
                                                <span class="count"><?php echo $contadorSubcategorias[$subcategoria->id] ?? 0 ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

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
                    <a class="products__card" href="/details/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
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
            </div>
        </section>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.tiendaSystem && window.tiendaSystem.initializeVariables) {
            window.tiendaSystem.initializeVariables({
                categoria_slug: '<?php echo isset($categoria_slug) ? $categoria_slug : ''; ?>',
                precio_min: <?php echo $precio_min; ?>,
                precio_max: <?php echo $precio_max; ?>,
                color_id: <?php echo $color_id; ?>,
                filtro_precio_activo: <?php echo $filtro_precio_activo ? 'true' : 'false'; ?>,
                min_db: <?php echo $min_db; ?>,
                max_db: <?php echo $max_db; ?>
            });
        }
    });
</script>
<?php $script = "<script src='/build/js/tienda.js'></script>"; ?>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>