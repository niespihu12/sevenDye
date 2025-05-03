<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<section class="deseo-main">
    <h2 class="deseo-main__title centrar-texto">YOUR WISHLIST</h2>

    <div class="deseo-main__grid">
        <div class="deseo-products">
            <?php if (empty($productos)): ?>
                <p>Your wishlist is empty</p>
            <?php endif; ?>
            <?php foreach ($productos as $producto): ?>

                <div class="deseo-item">
                    <div class="deseo-item__image">
                        <?php
                        $imagenPrincipal = '';
                        foreach ($imagenes as $imagen) {
                            if ($imagen->productos_id === $producto->id) {
                                $imagenPrincipal = $imagen->imagen;
                                break;
                            }
                        }
                        ?>
                        <img loading="lazy" src="/imagenes/<?php echo $imagenPrincipal ?>" alt="<?php echo $producto->nombre ?>">
                    </div>
                    <a class="deseo-item__info" href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
                        <h3><?php echo $producto->nombre; ?></h3>
                        <div class="deseo-item__details">
                            <p class="price"><?php echo MONEDA . number_format($producto->precio, 2); ?></p>
                        </div>
                    </a>
                    <button class="deseo-item__remove wishlist-remove" data-producto="<?php echo $producto->id; ?>">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

                </a>

            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php 
    $script = "
        <script src='build/js/deseos.js'></script>
    ";

?>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>