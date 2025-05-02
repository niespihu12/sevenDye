<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<section class="ultimate-sale">
    <div class="sale__image--left">

    </div>

    <div class="sale-content">
        <div class="top-images">
            <picture>
                <source srcset="/build/img/chino_mier.avif" type="image/avif">
                <source srcset="/build/img/chino_mier.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="/build/img/chino_mier.png" alt="Seven Street">
            </picture>
        </div>

        <div class="sale-text">
            <h2 class="sale-title">
                <span class="ultimate">ULTIMATE</span>
                <span class="sale">SALE</span>
            </h2>
            <p class="collection-text centrar-texto">NEW COLLECTION</p>
            <a class="shop-button" href="tienda">SHOP NOW</a>
        </div>

        <div class="bottom-image">
            <picture>
                <source srcset="./build/img/save_tray.avif" type="image/avif">
                <source srcset="./build/img/save_tray.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="./build/img/save_tray.png" alt="Seven Logo">
            </picture>
        </div>
    </div>

    <div class="sale__image--right">
    </div>

</section>
<div class="carrusel-container">
    <marquee scrollamount="29" behavior="scroll">
        <span class="texto">URBAN</span>
        <span class="texto">JOUNG</span>
        <span class="texto">MODERN</span>
        <span class="texto">IRREVERENT</span>
        <span class="texto">GENDERLESS</span>
        <span class="texto">VERSATILE</span>
    </marquee>
</div>

<section class="weekly-categories">
    <h2 class="title">Weekly Categories</h2>

    <div class="categories-container">
        <div class="categories-slider">
            <!-- Categoría 1: Pullovers -->
            <?php foreach ($categoriasCompletas as $categoria): ?>
                <a class="category-item" href="/tienda/<?php echo urlencode($categoria->slug); ?>">

                    <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $categoria->imagen ?>" alt="Pullovers"
                        class="category-image">

                    <div class="category-title">
                        <h3><?php echo $categoria->nombre ?> <span class="arrow">→</span></h3>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>

        <div class="nav-buttons">
            <button class="prev" aria-label="Previous">←</button>
            <button class="next" aria-label="Next">→</button>
        </div>
    </div>
</section>

<div class="footer__servicios contenedor">
    <div class="servicio">
        <div class="servicio__imagen">
            <picture>
                <source srcset="build/img/calidad-del-producto.avif" type="image/avif">
                <source srcset="build/img/calidad-del-producto.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="build/img/calidad-del-producto.png" alt="">
            </picture>
        </div>
        <p>Free Delivery<span>From $199.00</span></p>
    </div>
    <div class="servicio">
        <div class="servicio__imagen">
            <picture>
                <source srcset="build/img/servicio-al-cliente.avif" type="image/avif">
                <source srcset="build/img/servicio-al-cliente.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="build/img/servicio-al-cliente.png" alt="">
            </picture>
        </div>
        <p>Support 24/7<span>Online 24 Hours</span></p>
    </div>
    <div class="servicio">
        <div class="servicio__imagen">
            <picture>
                <source srcset="build/img/calidad-del-producto.avif" type="image/avif">
                <source srcset="build/img/calidad-del-producto.webp" type="image/webp">
                <img src="build/img/calidad-del-producto.png" alt="">
            </picture>
        </div>
        <p>Top Quality<span>manufacturing</span></p>
    </div>
    <div class="servicio">
        <div class="servicio__imagen">
            <picture>
                <source srcset="build/img/metodo-de-pago.avif" type="image/avif">
                <source srcset="build/img/metodo-de-pago.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="build/img/metodo-de-pago.png" alt="">
            </picture>
        </div>
        <p>Payment Method<span>Secure Payment</span></p>
    </div>
    <div class="servicio">
        <div class="servicio__imagen">
            <picture>
                <source srcset="build/img/abrazo-con-cliente.avif" type="image/avif">
                <source srcset="build/img/abrazo-con-cliente.webp" type="image/webp">
                <img loading="lazy" width="100" height="100" src="build/img/abrazo-con-cliente.png" alt="">
            </picture>
        </div>
        <p>Inclusivity<span>All sizes XXS to 5XL</span></p>
    </div>
</div>

<section class="promo-container">
    <div class="promo-text">
        <h1>GET A 20% DISCOUNT</h1>
        <p>In denim jackets with code <strong>DENIMWEB20</strong>.<br>
            Explore the Seven Dye collection, where timeless classics and innovative designs combine perfectly. Upgrade your
            style today!</p>
        <div class="cta">
            <button class="boton-primario">Buy Now</button>
        </div>
        <div class="promo-timer">
            Hurry, Before It's Too Late!<br>
            <div class="temporizador">
                <div class="temporizador__valor">
                    <p id="days">00</p> Days
                </div>
                <div class="temporizador__valor">
                    <p id="hours">00</p> Hr

                </div>
                <div class="temporizador__valor">
                    <p id="minutes">00</p> Mins
                </div>
                <div class="temporizador__valor">
                    <p id="seconds">00</p> Sec
                </div>

            </div>

        </div>
    </div>
    <div class="dynamic-gallery-wrapper">
        <div class="dynamic-gallery-slider">
            <div class="dynamic-gallery-slide dynamic-gallery-slide--featured">
                <picture>
                    <source srcset="/build/img/chaquetahombre.avif" type="image/avif">
                    <source srcset="build/img/image1.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="build/img/image1.jpg" alt="Image 1">
                </picture>
            </div>
            <div class="dynamic-gallery-slide">
                <picture>
                    <source srcset="/build/img/chaqueta_roja.avif" type="image/avif">
                    <source srcset="build/img/20231105_170723.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="build/img/20231105_170723.png" alt="Image 2">
                </picture>
            </div>
            <div class="dynamic-gallery-slide">
                <picture>
                    <source srcset="build/img/denim-jackets.avif" type="image/avif">
                    <source srcset="build/img/denim-jackets.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="build/img/denim-jackets.png" alt="Image 3">
                </picture>
            </div>
        </div>
    </div>

</section>

<section class="arrival">
    <div class="arrival__header">
        <h2>NEW ARRIVALS</h2>
    </div>
    <div class="arrival__contenido">
        <div class="arrival__contenido--botones category">
            <?php foreach ($categorias as $categoria) : ?>
                <button class="boton-primario <?php echo $categoria->id == $categoriaId ? 'active' : ''; ?>" data-categoria="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($categorias as $categoria) : ?>
            <div class="arrival__contenido--productos" id="categoria-<?php echo $categoria->id; ?>" <?php echo ($categoria !== $categorias[0]) ? 'style="display: none;"' : ''; ?>>
                <?php foreach ($productosPorCategoria[$categoria->id] as $producto) : 
                    ?>
                    <div class="producto">
                        <div class="producto__imagen">
                            <img loading="lazy" width="100" height="100" class="imgg" src="/imagenes/<?php echo $imagenes[$producto->id]; ?>"
                                alt="<?php echo $producto->nombre; ?>">

                            <p data-descripcion="<?php echo $producto->descripcion ?>"></p>

                            <div class="quick-actions">
                                <button class="quick-views" aria-label="Quick views">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="producto-info">
                            <p class="producto-titulo">
                                <a href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>"><?php echo $producto->nombre; ?></a>
                            </p>
                            <div class="producto-precio">$<?php echo $producto->precio; ?></div>
                            <div class="producto-rating">
                                <div class="star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count">(<?php echo $producto->recuento_ventas; ?>)</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="arrival__contenido--mas">
        <a href="/tienda">SEE MORE</a>
    </div>


</section>

<!-- apartado del video y fotos de influencer -->
<section class="community-section">
    <div class="section-header">
        <h2>Dye to be Seen</h2>
        <p>Get inspired by the best looks from our community and share your authenticity. Upload your photo or video, or
            share it on social media with #DynamicLooks. Wear your life in color and join the Seven Dye movement!</p>
    </div>

    <div class="featured-video">
        <video muted preload="none">
            <source src="../video/video-influ.mp4" type="video/mp4">
        </video>
        <div class="video-overlay">
            <div class="play-button">
                <svg viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="community-grid">
        <?php foreach ($influencers as $influencer): ?>
            <!-- Card 1 -->
            <div class="community-card">
                <div class="card-inner">
                    <div class="card-front">
                        <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $influencer->imagen ?>">
                    </div>
                    <div class="card-back">
                        <h3>@<?php echo $influencer->nombre ?></h3>
                        <p><?php echo $influencer->descripcion; ?></p>
                        <div class="social-share">
                            <p class="share-text">¡Comparte tu estilo en redes!</p>
                            <!-- From Uiverse.io by GigioBagigi0 -->
                            <div class="card">
                                <?php if ($influencer->youtube != ''): ?>
                                    <div class="social-icons">
                                        <p>@<?php echo $influencer->nombre ?></p>
                                        <a href="<?php echo $influencer->youtube ?>">Follow</a>
                                        <svg fill="#000000" xml:space="preserve" viewBox="0 0 461.001 461.001"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1"
                                            version="1.1">
                                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M365.257,67.393H95.744C42.866,67.393,0,110.259,0,163.137v134.728 c0,52.878,42.866,95.744,95.744,95.744h269.513c52.878,0,95.744-42.866,95.744-95.744V163.137 C461.001,110.259,418.135,67.393,365.257,67.393z M300.506,237.056l-126.06,60.123c-3.359,1.602-7.239-0.847-7.239-4.568V168.607 c0-3.774,3.982-6.22,7.348-4.514l126.06,63.881C304.363,229.873,304.298,235.248,300.506,237.056z"
                                                        style="fill:#F61C0D;"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <?php if ($influencer->tiktok != ''): ?>
                                    <div class="social-icons">
                                        <p>@<?php echo $influencer->nombre ?></p>
                                        <a href="<?php echo $influencer->tiktok ?>">Follow</a>
                                        <svg xmlns="http://www.w3.org/2000/svg" id="icons" viewBox="0 0 512 512" fill="#000000">
                                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M412.19,118.66a109.27,109.27,0,0,1-9.45-5.5,132.87,132.87,0,0,1-24.27-20.62c-18.1-20.71-24.86-41.72-27.35-56.43h.1C349.14,23.9,350,16,350.13,16H267.69V334.78c0,4.28,0,8.51-.18,12.69,0,.52-.05,1-.08,1.56,0,.23,0,.47-.05.71,0,.06,0,.12,0,.18a70,70,0,0,1-35.22,55.56,68.8,68.8,0,0,1-34.11,9c-38.41,0-69.54-31.32-69.54-70s31.13-70,69.54-70a68.9,68.9,0,0,1,21.41,3.39l.1-83.94a153.14,153.14,0,0,0-118,34.52,161.79,161.79,0,0,0-35.3,43.53c-3.48,6-16.61,30.11-18.2,69.24-1,22.21,5.67,45.22,8.85,54.73v.2c2,5.6,9.75,24.71,22.38,40.82A167.53,167.53,0,0,0,115,470.66v-.2l.2.2C155.11,497.78,199.36,496,199.36,496c7.66-.31,33.32,0,62.46-13.81,32.32-15.31,50.72-38.12,50.72-38.12a158.46,158.46,0,0,0,27.64-45.93c7.46-19.61,9.95-43.13,9.95-52.53V176.49c1,.6,14.32,9.41,14.32,9.41s19.19,12.3,49.13,20.31c21.48,5.7,50.42,6.9,50.42,6.9V131.27C453.86,132.37,433.27,129.17,412.19,118.66Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>

                                <?php endif; ?>

                                <?php if ($influencer->instagram != ''): ?>
                                    <div class="social-icons">
                                        <p>@<?php echo $influencer->nombre ?></p>
                                        <a href="<?php echo $influencer->instagram ?>">Follow</a>
                                        <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                            <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path fill-rule="nonzero" fill="#FF1493"
                                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- Apartadoo de las ofertas -->

<section class="products-section">
    <h2 class="section-title">OFFERS</h2>

    <div class="products-carousel">
        <div class="carousel-container">
            <div class="carousel-track">
                <?php

                use Model\ProductoImagen; ?>
                <?php foreach ($productos as $producto):
                    $query = "SELECT * FROM producto_imagen WHERE productos_id = {$producto->id} LIMIT 1";
                    $imagenPrincipal = ProductoImagen::consultarSQL($query);
                ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img loading="lazy" width="100" height="100"
                                src="/imagenes/<?php echo $imagenPrincipal[0]->imagen; ?>"
                                alt="<?php echo $producto->nombre; ?>">

                            <div class="quick-actions">
                                <button class="favorite" aria-label="Add to favorites">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="quick-view" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>">
                                    <?php echo $producto->nombre; ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <?php echo MONEDA .  $producto->precio; ?>
                             
                            </div>
                            <div class="product-rating">
                                <div class="stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-count">(<?php echo rand(10, 100); ?>)</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="carousel-nav">
            <button class="prev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="next" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>



<!-- Apartado de las reseñas -->
<section class="testimonial-general">
    <h2>This Is What Our Customers Say</h2>
    <section class="testimonials">
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div id="customers-testimonials" class="owl-carousel">
                        <?php foreach ($testimonios as $testimonio) : ?>

                            <!--TESTIMONIAL 1 -->
                            <div class="item">
                                <div class="shadow-effect">
                                    <img loading="lazy" width="100" height="100" class="img-circle" src="/imagenes/<?php echo $testimonio->imagen ?>" alt="">
                                    <div class="testimonial-texto">
                                        <p>
                                            <?php echo $testimonio->mensaje ?>
                                        </p>
                                        <p class="testimonial-texto__barra"><?php echo $testimonio->rol ?></p>
                                        <h3><?php echo $testimonio->nombre ?></h3>
                                    </div>

                                </div>

                            </div>
                            <!--END OF TESTIMONIAL 1 -->
                        <?php endforeach; ?>



                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
</section>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>