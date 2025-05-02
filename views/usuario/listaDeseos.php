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

<script>
    document.querySelectorAll('.wishlist-remove').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const producto = e.target.closest('button').dataset.producto;

            try {
                const response = await fetch('/deseos/eliminar', {
                    method: 'POST',
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
                    e.target.closest('.deseo-item').remove();
                    if (document.querySelectorAll('.deseo-item').length === 0) {
                        document.querySelector('.deseo-products').innerHTML = '<p>Your wishlist is empty</p>';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>