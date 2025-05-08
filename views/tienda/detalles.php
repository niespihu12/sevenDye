<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<main class=" productos-gendetails">
    <div class="container">
        <div class="product-detail">

            <div class="product-thumbnails">
                <?php foreach ($productoImagenes as $i => $imagen): ?>
                    <div class="thumbnail <?php echo $i === 0 ? 'active' : ''; ?>" data-src="/imagenes/<?php echo $imagen->imagen ?>" onclick="changeMainImage(this)">
                        <img src="/imagenes/<?php echo $imagen->imagen ?>" alt="Product thumbnail">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Main Product Image -->
            <div class="product-main-image">
                <div class="main-image-container">
                    <img class="product-image" src="/imagenes/<?php echo $productoImagenPrincipal->imagen ?>" alt="<?php echo $producto->nombre ?>">

                    <!-- Image Navigation -->
                    <div class="image-nav">
                        <button class="image-nav-btn prev-image" onclick="navigateImages(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="image-nav-btn next-image" onclick="navigateImages(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="product-info">
                <h1 class="product-title"><?php echo $producto->nombre ?></h1>

                <div class="product-meta">
                    <div class="product-rating" id="product-rating-summary">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="review-count">(0 Reviews)</span>
                    </div>

                    <div class="product-availability">
                        <span class="availability-dot"></span>
                        <span>In Stock</span>
                    </div>
                </div>

                <div class="product-price" id="precio-producto">
                    <?php echo MONEDA . $producto->precio ?>
                    <span class="original-price"><?php echo MONEDA . ($producto->precio * 1.2) ?></span>
                    <span class="discount-badge">20% OFF</span>
                </div>

                <p class="product-description">
                    <?php echo $producto->descripcion ?>
                </p>

                <div class="product-options">
                    <p class="option-title">Select Size</p>
                    <div class="size-options">
                        <?php foreach ($productoTallas as $index => $productoTalla): ?>
                            <?php foreach ($tallas as $talla): ?>
                                <?php if ($productoTalla->tallas_id == $talla->id): ?>
                                    <label class="size-option">
                                        <input type="radio" name="size"
                                            value="<?php echo $talla->id; ?>"
                                            data-precio="<?php echo $productoTalla->precio ?? $producto->precio; ?>"
                                            data-talla-id="<?php echo $talla->id; ?>"
                                            <?php echo $index === 0 ? 'checked' : ''; ?>>
                                        <span class="size-label"><?php echo $talla->nombre ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="product-actions">
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <div class="quantity-controls">
                            <button class="quantity-btn minus-btn" id="decremento">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10" readonly>
                            <button class="quantity-btn plus-btn" id="incremento">+</button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="wishlist-btn" id="btn-wishlist" data-producto="<?php echo $producto->id; ?>">
                            <i class="<?php echo $enListaDeseos ? 'fas' : 'far'; ?> fa-heart"></i>
                        </button>
                        <button class="add-to-cart-btn"
                            data-id="<?php echo $producto->id; ?>"
                            data-token="<?php echo hash_hmac('sha1', $producto->id, KEY_TOKEN); ?>">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                        <button class="buy-now-btn">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                        </button>
                    </div>
                </div>

                <div class="product-features">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="feature-text">
                            <span class="feature-title">Free Delivery</span>
                            <span class="feature-desc">Enter your postal code for Delivery Availability</span>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <div class="feature-text">
                            <span class="feature-title">Return Delivery</span>
                            <span class="feature-desc">Free 30 Days Delivery Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Reviews Section -->
        <div class="product-reviews-section">
            <h2 class="section-title">Customer Reviews</h2>

            <div class="review-summary">
                <div class="review-summary-stats">
                    <div class="overall-rating">
                        <div class="rating-number" id="overall-rating">0.0</div>
                        <div class="rating-stars" id="overall-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="rating-count" id="overall-count">Based on 0 reviews</div>
                    </div>
                </div>

                <?php if (isset($_SESSION['login'])): ?>
                    <div class="write-review">
                        <h3>Write a Review</h3>
                        <div class="review-form">
                            <div class="rating-input">
                                <p>Your Rating:</p>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" checked />
                                    <label for="star5"><i class="fas fa-star"></i></label>

                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4"><i class="fas fa-star"></i></label>

                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3"><i class="fas fa-star"></i></label>

                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2"><i class="fas fa-star"></i></label>

                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>

                            <div class="review-text">
                                <label for="review-content">Your Review:</label>
                                <textarea id="review-content" placeholder="Write your experience with this product..." rows="4"></textarea>
                            </div>

                            <button id="submit-review" data-producto="<?php echo $producto->id; ?>" class="submit-review-btn">Submit Review</button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="login-to-review">
                        <p>Please <a href="/login">login</a> to write a review</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="reviews-list" id="reviews-container">
                <!-- Reviews will be loaded dynamically -->
                <div class="loading-reviews">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading reviews...</p>
                </div>
            </div>
        </div>

        <div class="related-products">
            <h2 class="section-title">You May Also Like</h2>

            <div class="products-grid">
                <?php foreach ($productoCategorias as $producto): ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="/imagenes/<?php echo $imagenes[$producto->id] ?>" alt="<?php echo $producto->nombre ?>">
                            <div class="product-card-actions">
                                <button class="card-action-btn">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="card-action-btn">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-card-content">
                            <h3 class="product-card-title">
                                <a href="/detalles/<?php echo urlencode($producto->slug); ?>?token=<?php echo hash_hmac('sha1', $producto->slug, KEY_TOKEN); ?>""><?php echo $producto->nombre ?></a>
                        </h3>
                        <div class=" product-card-price"><?php echo MONEDA . $producto->precio ?>
                        </div>
                        <div class="product-card-footer">
                            <div class="card-rating">
                                <div class="card-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="card-review-count">(65)</span>
                            </div>
                        </div>
                    </div>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</main>

<?php $script = '<script src="/build/js/detalles.js"></script>' ?>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>