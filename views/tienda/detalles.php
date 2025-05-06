<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<div class="container productos-gendetails">
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
                        <div class="product-card-price"><?php echo MONEDA . $producto->precio ?></div>
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
</div>

<script>
    let currentImageIndex = 0;
    const thumbnails = document.querySelectorAll('.thumbnail');

    function changeMainImage(element) {

        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');

        const mainImage = document.querySelector('.product-image');
        mainImage.src = element.getAttribute('data-src');

        currentImageIndex = Array.from(thumbnails).indexOf(element);
    }

    function navigateImages(direction) {
        let newIndex = currentImageIndex + direction;


        if (newIndex < 0) newIndex = thumbnails.length - 1;
        if (newIndex >= thumbnails.length) newIndex = 0;


        thumbnails[newIndex].click();
    }


    const decrementBtn = document.getElementById('decremento');
    const incrementBtn = document.getElementById('incremento');
    const quantityInput = document.getElementById('quantity');

    decrementBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    incrementBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.getAttribute('max') || 10);
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    });


    const sizeInputs = document.querySelectorAll('input[name="size"]');
    sizeInputs.forEach(input => {
        input.addEventListener('change', function() {
            const precio = this.getAttribute('data-precio');
            if (precio) {
                const precioElement = document.getElementById('precio-producto');
                precioElement.innerHTML = `
                        <?php echo MONEDA ?>${precio}
                        <span class="original-price"><?php echo MONEDA ?>${(precio * 1.2).toFixed(2)}</span>
                        <span class="discount-badge">20% OFF</span>
                    `;
            }
        });
    });


    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    addToCartBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const id = this.getAttribute('data-id');
        const token = this.getAttribute('data-token');
        const cantidad = document.getElementById('quantity').value;
        const tallaInput = document.querySelector('input[name="size"]:checked');

        if (!tallaInput) {
            alert('Please select a size');
            return;
        }

        const talla = tallaInput.getAttribute('data-talla-id');

        this.classList.add('adding');
        setTimeout(() => this.classList.remove('adding'), 1000);

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

                    const successMsg = document.createElement('div');
                    successMsg.className = 'success-toast';
                    successMsg.innerHTML = `
                        <i class="fas fa-check-circle"></i>
                        <span>Product added to cart!</span>
                    `;
                    document.body.appendChild(successMsg);


                    setTimeout(() => {
                        successMsg.classList.add('show');
                        setTimeout(() => {
                            successMsg.classList.remove('show');
                            setTimeout(() => successMsg.remove(), 300);
                        }, 2000);
                    }, 100);
                }
            })
            .catch(error => console.error('Error:', error));
    });


    const btnWishlist = document.getElementById('btn-wishlist');
    btnWishlist.addEventListener('click', async function() {
        const producto = this.dataset.producto;
        const icon = this.querySelector('i');
        const isInWishlist = icon.classList.contains('fas');


        this.classList.add('clicked');
        setTimeout(() => this.classList.remove('clicked'), 300);

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

                if (isInWishlist) {
                    icon.classList.replace('fas', 'far');
                    btnWishlist.classList.remove('active');
                } else {
                    icon.classList.replace('far', 'fas');
                    btnWishlist.classList.add('active');
                }


                const wishlistMsg = document.createElement('div');
                wishlistMsg.className = 'wishlist-toast';
                wishlistMsg.innerHTML = `
                        <i class="${isInWishlist ? 'far fa-heart' : 'fas fa-heart'}"></i>
                        <span>${data.mensaje || (isInWishlist ? 'Removed from wishlist' : 'Added to wishlist')}</span>
                    `;
                document.body.appendChild(wishlistMsg);


                setTimeout(() => {
                    wishlistMsg.classList.add('show');
                    setTimeout(() => {
                        wishlistMsg.classList.remove('show');
                        setTimeout(() => wishlistMsg.remove(), 300);
                    }, 2000);
                }, 100);

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

    // Reviews handling
    document.addEventListener('DOMContentLoaded', function() {
        // Load reviews when page loads
        const productId = document.querySelector('.add-to-cart-btn').getAttribute('data-id');
        if (productId) {
            loadReviews(productId);
        }

        // Submit review
        const submitReviewBtn = document.getElementById('submit-review');
        if (submitReviewBtn) {
            submitReviewBtn.addEventListener('click', submitReview);
        }
    });

    // Function to load reviews for a product
    function loadReviews(productId) {
        const reviewsContainer = document.getElementById('reviews-container');

        fetch(`/resenas/producto?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.resultado) {
                    // Update average rating
                    updateRatingSummary(data.promedio, data.total);

                    // Clear loading indicator
                    reviewsContainer.innerHTML = '';

                    if (data.resenas.length === 0) {
                        reviewsContainer.innerHTML = `
                    <div class="no-reviews">
                        <p>No reviews yet. Be the first to review this product!</p>
                    </div>
                `;
                        return;
                    }

                    // Add each review to the container
                    data.resenas.forEach(review => {
                        const reviewElement = createReviewElement(review);
                        reviewsContainer.appendChild(reviewElement);
                    });
                } else {
                    reviewsContainer.innerHTML = `
                <div class="error-message">
                    <p>Error loading reviews. Please try again later.</p>
                </div>
            `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                reviewsContainer.innerHTML = `
            <div class="error-message">
                <p>Error loading reviews. Please try again later.</p>
            </div>
        `;
            });
    }

    // Function to create review element
    function createReviewElement(review) {
        const date = new Date(review.creado);
        const formattedDate = date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const reviewElement = document.createElement('div');
        reviewElement.className = 'review-item';
        reviewElement.innerHTML = `
        <div class="review-header">
            <div class="reviewer-avatar">
                <span class="avatar-initial">${review.inicial}</span>
            </div>
            <div class="reviewer-info">
                <div class="reviewer-name">${review.usuario}</div>
                <div class="review-date">${formattedDate}</div>
            </div>
        </div>
        <div class="review-rating">
            ${generateStarRating(review.calificacion)}
        </div>
        <div class="review-content">
            <p>${review.observaciones}</p>
        </div>
    `;

        return reviewElement;
    }

    // Function to generate star rating HTML
    function generateStarRating(rating) {
        let starsHTML = '';

        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                starsHTML += '<i class="fas fa-star"></i>';
            } else if (i - 0.5 <= rating) {
                starsHTML += '<i class="fas fa-star-half-alt"></i>';
            } else {
                starsHTML += '<i class="far fa-star"></i>';
            }
        }

        return starsHTML;
    }

    // Function to update rating summary
    function updateRatingSummary(average, total) {
        // Update product info rating
        const productRating = document.getElementById('product-rating-summary');
        if (productRating) {
            const stars = productRating.querySelector('.stars');
            stars.innerHTML = generateStarRating(average);

            const reviewCount = productRating.querySelector('.review-count');
            reviewCount.textContent = `(${total} Reviews)`;
        }

        // Update overall rating in review section
        const overallRating = document.getElementById('overall-rating');
        const overallStars = document.getElementById('overall-stars');
        const overallCount = document.getElementById('overall-count');

        if (overallRating) overallRating.textContent = average.toFixed(1);
        if (overallStars) overallStars.innerHTML = generateStarRating(average);
        if (overallCount) overallCount.textContent = `Based on ${total} reviews`;
    }

    // Function to submit a review
    function submitReview(e) {
        e.preventDefault();

        const productId = this.getAttribute('data-producto');
        const reviewContent = document.getElementById('review-content').value;
        const rating = document.querySelector('input[name="rating"]:checked').value;

        if (!reviewContent.trim()) {
            alert('Please write a review before submitting.');
            return;
        }

        // Disable button to prevent multiple submissions
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

        fetch('/resenas/guardar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    observaciones: reviewContent,
                    calificacion: rating,
                    producto_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;
                this.innerHTML = 'Submit Review';

                if (data.resultado) {
                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'success-toast';
                    successMsg.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>Review submitted successfully!</span>
            `;
                    document.body.appendChild(successMsg);

                    setTimeout(() => {
                        successMsg.classList.add('show');
                        setTimeout(() => {
                            successMsg.classList.remove('show');
                            setTimeout(() => successMsg.remove(), 300);
                        }, 2000);
                    }, 100);

                    // Clear review form
                    document.getElementById('review-content').value = '';
                    document.getElementById('star5').checked = true;

                    // Reload reviews
                    loadReviews(productId);
                } else {
                    // Show error message
                    alert(data.mensaje || 'Error submitting review.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
                this.innerHTML = 'Submit Review';
                alert('Error submitting review. Please try again later.');
            });
    }

    // Complete the missing code in the existing script section
    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('active');
    }

    // Main image zoom effect
    const mainImage = document.querySelector('.product-image');
    const mainImageContainer = document.querySelector('.main-image-container');

    mainImageContainer.addEventListener('mousemove', function(e) {
        const {
            left,
            top,
            width,
            height
        } = this.getBoundingClientRect();
        const x = (e.clientX - left) / width;
        const y = (e.clientY - top) / height;

        mainImage.style.transformOrigin = `${x * 100}% ${y * 100}%`;
    });

    mainImageContainer.addEventListener('mouseenter', function() {
        mainImage.style.transform = 'scale(1.5)';
    });

    mainImageContainer.addEventListener('mouseleave', function() {
        mainImage.style.transform = 'scale(1)';
    });
</script>

<style>
    /* Review Section Styles */
    .product-reviews-section {
        margin-top: 60px;
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #3a3a3a;
    }

    .review-summary {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 30px;
    }

    .review-summary-stats {
        flex: 1;
        min-width: 200px;
    }

    .overall-rating {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .rating-number {
        font-size: 48px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
    }

    .rating-stars {
        font-size: 20px;
        color: #FFD700;
        margin-bottom: 5px;
    }

    .rating-count {
        color: #666;
        font-size: 14px;
    }

    .write-review,
    .login-to-review {
        flex: 2;
        min-width: 300px;
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
    }

    .write-review h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .rating-input {
        margin-bottom: 20px;
    }

    .rating-input p {
        margin-bottom: 10px;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        font-size: 24px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        color: #ddd;
        margin-right: 5px;
    }

    .star-rating :checked~label,
    .star-rating :hover~label {
        color: #FFD700;
    }

    .review-text {
        margin-bottom: 20px;
    }

    .review-text label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .review-text textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: vertical;
        font-family: inherit;
    }

    .submit-review-btn {
        background-color: #3a3a3a;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .submit-review-btn:hover {
        background-color: #222;
    }

    .login-to-review p {
        margin: 0;
        padding: 20px 0;
        text-align: center;
    }

    .login-to-review a {
        color: #3a3a3a;
        font-weight: 600;
        text-decoration: underline;
    }

    .reviews-list {
        margin-top: 30px;
    }

    .loading-reviews {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 0;
        color: #666;
    }

    .loading-reviews i {
        font-size: 30px;
        margin-bottom: 15px;
    }

    .review-item {
        border-bottom: 1px solid #eee;
        padding: 25px 0;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #3a3a3a;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        margin-right: 15px;
    }

    .reviewer-info {
        display: flex;
        flex-direction: column;
    }

    .reviewer-name {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .review-date {
        font-size: 13px;
        color: #777;
    }

    .review-rating {
        margin-bottom: 10px;
        color: #FFD700;
    }

    .review-content p {
        margin: 0;
        line-height: 1.6;
    }

    .no-reviews {
        text-align: center;
        padding: 40px 0;
        color: #666;
    }

    .error-message {
        text-align: center;
        padding: 20px;
        color: #721c24;
        background-color: #f8d7da;
        border-radius: 4px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .review-summary {
            flex-direction: column;
        }

        .write-review,
        .review-summary-stats {
            width: 100%;
        }
    }
</style>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>