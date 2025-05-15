document.addEventListener('DOMContentLoaded', function () {
    updateCartCounter();
    updateWishlistCounter();
    document.addEventListener('click', function (e) {
        const wishlistBtn = e.target.closest('.wishlist-btn');
        if (wishlistBtn) {
            const productId = wishlistBtn.dataset.id;
            if (productId) {
                toggleWishlist(productId);
            }
        }
    });
    document.addEventListener('cartUpdated', function () {
        updateCartCounter();
    });

    document.addEventListener('wishlistUpdated', function () {
        updateWishlistCounter();
    });
    const KEY_TOKEN = "APR.wqc-354*";
    initializeSearch('search-input-desktop', 'search-results-desktop');
    initializeSearch('search-input-mobile', 'search-results-mobile');

    function initializeSearch(inputId, resultsId) {
        const searchInput = document.getElementById(inputId);
        const searchResults = document.getElementById(resultsId);

        if (searchInput && searchResults) {
            searchInput.addEventListener('input', debounce(function (e) {
                const searchTerm = e.target.value.trim();

                if (searchTerm.length >= 2) {
                    fetchSearchResults(searchTerm, searchResults);
                } else {
                    searchResults.innerHTML = '';
                    searchResults.classList.remove('show');
                }
            }, 300));

            document.addEventListener('click', function (event) {
                if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                    searchResults.classList.remove('show');
                }
            });

            searchInput.addEventListener('focus', function () {
                if (this.value.trim().length >= 2) {
                    fetchSearchResults(this.value.trim(), searchResults);
                }
            });
        }
    }

    function fetchSearchResults(query, resultsContainer) {
        resultsContainer.innerHTML = '<div class="loading">Buscando...</div>';
        resultsContainer.classList.add('show');

        fetch(`/products/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    renderSearchResults(data, resultsContainer);
                } else {
                    resultsContainer.innerHTML = '<div class="no-results">No se encontraron productos</div>';
                }
            })
            .catch(error => {
                console.error('Error en la búsqueda:', error);
                resultsContainer.innerHTML = '<div class="error">Error al buscar productos</div>';
            });
    }

    async function renderSearchResults(results, resultsContainer) {
        resultsContainer.innerHTML = '';
        const resultsFragment = document.createDocumentFragment();

        const productsWithLinks = await Promise.all(results.map(async product => {
            return {
                ...product,
                link: await generateSecureLink(product.slug)
            };
        }));

        productsWithLinks.forEach(product => {
            const item = document.createElement('a');
            item.href = product.link;
            item.className = 'search-item';

            const imageHtml = product.imagen ?
                `<div class="search-item-image">
    <img src="/imagenes/${product.imagen}" alt="${product.nombre}">
</div>` : '';

            item.innerHTML = `
${imageHtml}
<div class="search-item-info">
    <div class="search-item-name">${product.nombre}</div>
    <div class="search-item-price">$${product.precio}</div>
</div>
`;

            resultsFragment.appendChild(item);
        });

        resultsContainer.appendChild(resultsFragment);
    }

    async function generateSecureLink(slug) {
        try {
            const encoder = new TextEncoder();
            const key = await crypto.subtle.importKey(
                "raw",
                encoder.encode(KEY_TOKEN), {
                name: "HMAC",
                hash: "SHA-1"
            },
                false,
                ["sign"]
            );
            const signature = await crypto.subtle.sign(
                "HMAC",
                key,
                encoder.encode(slug)
            );
            const hexSignature = Array.from(new Uint8Array(signature))
                .map(b => b.toString(16).padStart(2, '0'))
                .join('');

            return `/details/${encodeURIComponent(slug)}?token=${hexSignature}`;

        } catch (error) {
            console.error('Error generando enlace:', error);
            return '#';
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
});

function updateCartCounter() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.count) {
                const desktopCartIcon = document.querySelector('.navegacion-secundaria .carrito');
                updateCounter(desktopCartIcon, data.count);

                const mobileCartIcon = document.querySelector('.barra-mobile .carrito');
                updateCounter(mobileCartIcon, data.count);
            }
        })
        .catch(error => console.error('Error fetching cart count:', error));
}

function updateWishlistCounter() {
    fetch('/wishlist/count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.count) {
                // Update desktop counter
                const desktopWishlistIcon = document.querySelector('.navegacion-secundaria .favoritos');
                updateCounter(desktopWishlistIcon, data.count);

                // Update mobile counter
                const mobileWishlistIcon = document.querySelector('.barra-mobile .like');
                updateCounter(mobileWishlistIcon, data.count);
            }
        })
        .catch(error => console.error('Error fetching wishlist count:', error));
}

function updateCounter(element, count) {
    if (!element) return;

    let counter = element.querySelector('.counter-badge');

    if (count > 0) {
        if (!counter) {
            counter = document.createElement('span');
            counter.className = 'counter-badge';
            element.appendChild(counter);
        }
        counter.textContent = count;
        counter.style.display = 'flex';
    } else if (counter) {
        counter.style.display = 'none';
    }
}

function toggleWishlist(productId) {
    fetch(`/wishlist/verify?producto=${productId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            const isInWishlist = data.enLista;
            const url = '/wishlist/' + (isInWishlist ? 'delete' : 'save');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    producto: productId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.resultado) {
                        document.dispatchEvent(new CustomEvent('wishlistUpdated'));
                        toggleWishlistButtonState(productId, !isInWishlist);
                        showNotification(data.mensaje);
                    }
                })
                .catch(error => console.error('Error toggling wishlist:', error));
        })
        .catch(error => console.error('Error checking wishlist status:', error));
}

function toggleWishlistButtonState(productId, isInWishlist) {
    const wishlistButtons = document.querySelectorAll(`.wishlist-btn[data-id="${productId}"]`);

    wishlistButtons.forEach(btn => {
        if (isInWishlist) {
            btn.classList.add('active');
            if (btn.querySelector('i')) {
                btn.querySelector('i').classList.remove('bi-heart');
                btn.querySelector('i').classList.add('bi-heart-fill');
            }
        } else {
            btn.classList.remove('active');
            if (btn.querySelector('i')) {
                btn.querySelector('i').classList.remove('bi-heart-fill');
                btn.querySelector('i').classList.add('bi-heart');
            }
        }
    });
}

function showNotification(message) {
    let notificationContainer = document.getElementById('notification-container');
    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.id = 'notification-container';
        document.body.appendChild(notificationContainer);
    }

    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;

    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}

function addToCart(productId, cantidad = 1, talla = null) {
    const formData = new FormData();
    formData.append('id', productId);
    formData.append('cantidad', cantidad);

    const token = generateToken(productId);
    formData.append('token', token);

    if (talla) {
        formData.append('talla', talla);
    }

    fetch('/cart/add', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                document.dispatchEvent(new CustomEvent('cartUpdated'));
                showNotification('Product added to cart');
            } else {
                showNotification('Error adding product to cart');
            }
        })
        .catch(error => console.error('Error adding to cart:', error));
}


function generateToken(id) {
    return 'token_' + id;
}