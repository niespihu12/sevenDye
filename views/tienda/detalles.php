<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<section class="producto-contenedor">
    <div class="producto-gallery">
        <?php foreach ($productoImagenes as $i => $imagen): ?>
            <div class="image-box<?php echo $i === 0 ? ' active' : ''; ?>" 
                 onclick="img('/imagenes/<?php echo $imagen->imagen ?>', this)">
                <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $imagen->imagen ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <div class="producto-imagen-centro">
        <img loading="lazy" width="400" height="400" src="/imagenes/<?php echo $productoImagenPrincipal->imagen ?>" class="image">
    </div>
    <div class="producto-descripcion">
        <h3><?php echo $producto->nombre ?></h3>
        <div class="producto-extrellas">
            <div class="producto-extrella">
                <ul>
                    <li>⭐</li><li>⭐</li><li>⭐</li><li>⭐</li><li>⭐</li>
                </ul>
                <p>(150 Reviews)</p>
            </div>
            <div class="producto-estado">
                <p>In Stock</p>
            </div>
        </div>
        <!-- Precio que cambiará dinámicamente -->
        <p class="producto-precio" id="precio-producto">
            <?php echo MONEDA . $producto->precio ?>
        </p>
        <p class="producto-descripcion-larga">
            <?php echo $producto->descripcion ?>
        </p>
        <form action="" class="product-single-form">
            <div class="producto-radio-inputs">
                <p class="producto-radio-titulo">Size: </p>
                <?php foreach ($productoTallas as $productoTalla): ?>
                    <label class="producto-radio">
                        <?php foreach ($tallas as $talla): ?>
                            <?php if ($productoTalla->tallas_id == $talla->id): ?>
                                <input type="radio" name="radio" 
                                       value="<?php echo $talla->id; ?>" 
                                       data-precio="<?php echo $productoTalla->precio ?? $producto->precio; ?>"
                                       data-talla-id="<?php echo $talla->id; ?>">
                                <span class="producto-size"><?php echo $talla->nombre ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="producto-footer">
                <div class="producto-contador">
                    <button class="contador-boton-decremento" id="decremento">-</button>
                    <input type="number" class="contador-input" value="1" min="1" max="10" disabled>
                    <button class="contador-boton-incremento" id="incremento">+</button>
                </div>
                <div class="producto-solo-megusta">
                    <button type="button" id="btn-wishlist" data-producto="<?php echo $producto->id; ?>">
                        <i class="<?php echo $enListaDeseos ? 'fas' : 'far'; ?> fa-heart"></i>
                    </button>
                </div>
            </div>
            <div class="producto-solo-metods">
                <div class="producto-solo-car">
                    <input
                        type="submit"
                        value="Add to cart"
                        class="add-to-cart"
                        data-id="<?php echo $producto->id; ?>"
                        data-token="<?php echo hash_hmac('sha1', $producto->id, KEY_TOKEN); ?>">
                </div>
                <div class="producto-solo-checkout">
                    <input type="submit" value="Buy Now">
                </div>
            </div>
        </form>
        <div class="producto-incluidos">
            <div class="producto-incluido">
                <picture>
                    <source srcset="/build/img/icon-delivery.avif" type="image/avif">
                    <source srcset="/build/img/icon-delivery.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="/build/img/icon-delivery.png" alt="Free Delivery">
                </picture>
                <div>
                    <p class="producto-incluido__titulo">Free Delivery</p>
                    <p class="producto-incluido__contenido">Enter your postal code for Delivery Availability</p>
                </div>
            </div>
            <div class="producto-incluido">
                <picture>
                    <source srcset="/build/img/icon-return.avif" type="image/avif">
                    <source srcset="/build/img/icon-return.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="/build/img/icon-return.png" alt="Return Delivery">
                </picture>
                <div>
                    <p class="producto-incluido__titulo">Return Delivery</p>
                    <p class="producto-incluido__contenido">Free 30 Days Delivery Returns. Details</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="productos-interes">
    <h2 class="centrar-texto">Te puede interesar</h2>
    <div class="arrival__contenido--productos">
        <div class="producto">
            <div class="producto__imagen">
                <picture>
                    <source srcset="/build/img/chaqueta4.avif" type="image/avif">
                    <source srcset="/build/img/chaqueta4.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="./build/img/chaqueta4.png"
                        alt="Eternal Cosmos Denim Jacket">
                </picture>
                <div class="quick-actions">
                    <button class="favorite" aria-label="Add to favorites">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="quick-view" aria-label="Quick view">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="producto-info">
                <p class="producto-titulo">
                    <a href="#">Eternal Cosmos Denim Jacket T-Shirt Seven Best Tiedye Colorful</a>
                </p>
                <div class="producto-precio">$102.40</div>
                <div class="producto-rating">
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span>(65)</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Cambiar imagen principal
    function img(src, el) {
        document.querySelector('.image').src = src;
        document.querySelectorAll('.producto-gallery .image-box').forEach(box => box.classList.remove('active'));
        if (el) el.classList.add('active');
    }

    // Actualizar precio cuando se cambia la talla
    const radios = document.querySelectorAll('input[name="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            const precio = this.getAttribute('data-precio');
            if (precio) {
                const precioElement = document.getElementById('precio-producto');
                precioElement.textContent = '<?php echo MONEDA ?>' + precio;
            }
        });
    });

    // Agregar al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const token = this.getAttribute('data-token');
            const cantidad = document.querySelector('.contador-input').value;
            const tallaInput = document.querySelector('input[name="radio"]:checked');
            if (!tallaInput) {
                alert('Selecciona una talla');
                return;
            }
            const talla = tallaInput.value;

            fetch('/carrito/agregar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${encodeURIComponent(id)}&token=${encodeURIComponent(token)}&cantidad=${encodeURIComponent(cantidad)}&talla=${encodeURIComponent(talla)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    alert('Producto añadido al carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Contador de productos
    const decremento = document.getElementById('decremento');
    const incremento = document.getElementById('incremento');
    const input = document.querySelector('.contador-input');

    decremento.addEventListener("click", (event) => {
        event.preventDefault();
        if (parseInt(input.value) > parseInt(input.min)) {
            input.value = parseInt(input.value) - 1;
        }
    });

    incremento.addEventListener("click", (event) => {
        event.preventDefault();
        if (parseInt(input.value) < parseInt(input.max)) {
            input.value = parseInt(input.value) + 1;
        }
    });

    // Agregar o quitar de la lista de deseos
    const btnWishlist = document.getElementById('btn-wishlist');
    btnWishlist.addEventListener('click', async function() {
        const producto = this.dataset.producto;
        const icon = this.querySelector('i');
        const isInWishlist = icon.classList.contains('fas');
        
        try {
            let url, method;
            
            if (isInWishlist) {
                url = '/deseos/eliminar';
                method = 'POST';
            } else {
                url = '/deseos/guardar';
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
                // Cambiar el ícono
                if (isInWishlist) {
                    icon.classList.replace('fas', 'far');
                } else {
                    icon.classList.replace('far', 'fas');
                }

                console.log(data.mensaje);
                
                // Mostrar mensaje
                alert(data.mensaje || (isInWishlist ? 'Removed from wishlist' : 'Added to wishlist'));

                

            } else {
                // Mostrar error
                alert(data.mensaje || 'An error occurred');
                if(data.mensaje == 'Usuario no autenticado'){
                    window.location.href = "/login";
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error processing your request');
        }
    });
</script>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>