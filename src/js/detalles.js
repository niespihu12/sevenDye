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
        window.location

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