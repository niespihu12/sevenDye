<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

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
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="review-count">(150 Reviews)</span>
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
        
        
        <div class="related-products">
            <h2 class="section-title">You May Also Like</h2>
            
            <div class="products-grid">
                
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="/src/img/chaqueta1.png" alt="Related Product">
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
                            <a href="#">Eternal Cosmos Denim Jacket</a>
                        </h3>
                        <div class="product-card-price">$102.40</div>
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
                
                
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="/src/img/chaqueta1.png" alt="Related Product">
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
                            <a href="#">Premium Cotton T-Shirt</a>
                        </h3>
                        <div class="product-card-price">$49.99</div>
                        <div class="product-card-footer">
                            <div class="card-rating">
                                <div class="card-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="card-review-count">(42)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
               
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="/src/img/chaqueta1.png" alt="Related Product">
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
                            <a href="#">Urban Street Hoodie</a>
                        </h3>
                        <div class="product-card-price">$89.99</div>
                        <div class="product-card-footer">
                            <div class="card-rating">
                                <div class="card-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="card-review-count">(28)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
              
                <div class="product-card">
                    <div class="product-card-image">
                        <img src="/src/img/chaqueta1.png" alt="Related Product">
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
                            <a href="#">Designer Slim Fit Jeans</a>
                        </h3>
                        <div class="product-card-price">$79.95</div>
                        <div class="product-card-footer">
                            <div class="card-rating">
                                <div class="card-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="card-review-count">(37)</span>
                            </div>
                        </div>
                    </div>
                </div>
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
                    if(data.mensaje == 'Usuario no autenticado'){
                        window.location.href = "/login";
                    } else {
                        alert(data.mensaje || 'An error occurred');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        
        if (thumbnails.length > 0) {
            thumbnails[0].classList.add('active');
        }
        
       
        const mainImage = document.querySelector('.product-image');
        const mainImageContainer = document.querySelector('.main-image-container');
        
        mainImageContainer.addEventListener('mousemove', function(e) {
            const { left, top, width, height } = this.getBoundingClientRect();
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
    
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>