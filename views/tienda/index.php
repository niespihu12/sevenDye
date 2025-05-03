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
                            <span class="colors__dot color-all <?php echo $color_id == 0 ? 'active' : ''; ?>" data-color-id="0" style="background-color: #ffffff; border: 1px solid #000;"></span>
                            <?php foreach ($colores as $color): ?>
                                <span class="colors__dot <?php echo $color_id == $color->id ? 'active' : ''; ?>"
                                    data-color-id="<?php echo $color->id; ?>"
                                    style="background-color: <?php echo $color->hexadecimal ?>;"></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
            </aside>
        </div>

        <div class="producto-car">
            <div class="sort-filter">
                <select id="sortOrder" class="sort-select">
                    <option value="">Default Order</option>
                    <option value="precio_asc" <?php echo ($orden === 'precio_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="precio_desc" <?php echo ($orden === 'precio_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                </select>
            </div>
            <div class="products">

                <?php foreach ($productos as  $producto): ?>
                    <a class="products__card" href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
                        <span class="products__hot">HOT</span>
                        <div class="products__image">
                            <?php if (isset($imagenes[$producto->id])): ?>
                                <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $imagenes[$producto->id] ?>" alt="<?php echo $producto->nombre ?>">
                            <?php else: ?>
                                <img loading="lazy" width="100" height="100" src="/imagenes/no-image.jpg" alt="No disponible">
                            <?php endif; ?>
                        </div>
                        <div class="products__info">
                            <h3 class="products__title">
                                <?php echo $producto->nombre ?>
                            </h3>
                            <div class="products__rating">★★★★★</div>
                            <div class="products__prices">
                                <span class="products__current-price"><?php echo MONEDA . $producto->precio ?></span>
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

<?php
    $percentage = 0;
    if ($max_db > $min_db) {
        $percentage = (($precio_max - $min_db) / ($max_db - $min_db)) * 100;
    }
    $min_db = floatval($min_db ?? 0);
    $max_db = floatval($max_db ?? 100);

    if ($min_db >= $max_db) {
        $max_db = $min_db + 1;
    }

    $precio_min = floatval($precio_min ?? $min_db);
    $precio_max = floatval($precio_max ?? $max_db);
    $precio_min = max($min_db, $precio_min);
    $precio_max = min($max_db, max($precio_min + 0.01, $precio_max));
?>
<script>
const shopConfig = {
    categorySlug: <?php echo json_encode(isset($categoria_slug) ? $categoria_slug : ''); ?>,
    minPrice: <?php echo floatval($precio_min); ?>,
    maxPrice: <?php echo floatval($precio_max); ?>,
    colorId: <?php echo intval($color_id); ?>,
    isPriceFilterActive: <?php echo $filtro_precio_activo ? 'true' : 'false'; ?>,
    minDbPrice: <?php echo floatval($min_db); ?>,
    maxDbPrice: <?php echo floatval($max_db); ?>,
    currencySymbol: <?php echo json_encode(MONEDA); ?>,
    sliderPercentage: <?php echo floatval($percentage); ?>
};
</script>
<?php 
    $script = "
        <script src='/build/js/tienda.js'></script>
    ";

?>


<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>