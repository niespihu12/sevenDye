<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<!-- Load Square.js before your script -->
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<div class="container">
    <h1 class="centrar-texto titulo-checkout">Checkout</h1>

    <div class="checkout-container">
        <div class="checkout-details">
            <div class="billing-section">
                <h2>Billing Details</h2>
                <form id="billing-form" class="billing-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">First Name</label>
                            <input type="text" id="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Last Name</label>
                            <input type="text" id="apellido" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company">Company Name (optional)</label>
                        <input type="text" id="company">
                    </div>

                    <div class="form-group">
                        <label for="adress">Street Address</label>
                        <input type="text" id="adress" required>
                    </div>

                    <div class="form-group">
                        <label for="apartment">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="apartment">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="town">Town/City</label>
                            <input type="text" id="town" required>
                        </div>
                        <div class="form-group">
                            <label for="postal">Postal Code</label>
                            <input type="text" id="postal" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" required>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="saveInfo">
                        <label for="saveInfo">Save this information for faster check-out next time</label>
                    </div>
                </form>
            </div>
        </div>

        <div class="order-summary">
            <h2>Order Summary</h2>

            <div class="order-items">
                <?php foreach ($carItems as $item): ?>
                    <div class="order-item">
                        <div class="item-image">
                            <img src="/imagenes/<?php echo $item['producto']->imagen_principal; ?>" alt="<?php echo $item['producto']->nombre; ?>">
                            <span class="item-quantity"><?php echo $item['cantidad']; ?></span>
                        </div>
                        <div class="item-details">
                            <h3><?php echo $item['producto']->nombre; ?></h3>
                            <?php if ($item['talla']): ?>
                                <p class="item-variant">Size: <?php echo $item['talla']; ?></p>
                            <?php endif; ?>
                        </div>
                        <p class="item-price"><?php echo $moneda . number_format($item['precio'] * $item['cantidad'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="coupon-section">
                <div class="coupon-input">
                    <input type="text" id="cupon-code" placeholder="Coupon Code" value="<?php echo $cupon ? $cupon['codigo'] : ''; ?>" <?php echo $cupon ? 'disabled' : ''; ?>>
                    <?php if ($cupon): ?>
                        <button id="remove-coupon" class="coupon-btn">Remove</button>
                    <?php else: ?>
                        <button id="apply-coupon" class="coupon-btn">Apply</button>
                    <?php endif; ?>
                </div>
                <div id="coupon-message" class="coupon-message"></div>
            </div>

            <div class="order-totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span><?php echo $moneda . number_format($total, 2); ?></span>
                </div>

                <?php if ($cupon): ?>
                    <div class="total-row discount">
                        <?php if ($cupon['tipo_descuento'] === 'porcentaje'): ?>
                            <span>Discount (<?php echo $cupon['descuento']; ?>%)</span>
                            <span class="discount-amount">-<?php echo $moneda . number_format(($total * $cupon['descuento']) / 100, 2); ?></span>
                        <?php else: ?>
                            <span>Discount (Fixed)</span>
                            <span class="discount-amount">-<?php echo $moneda . number_format($cupon['descuento'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="total-row">
                    <?php if ($total > 200): ?>
                        <span>Shipping</span>
                        <span>Free</span>
                    <?php else: ?>
                        <span>Shipping</span>
                        <span><?php echo $moneda; ?>7.00</span>
                    <?php endif; ?>
                </div>

                <div class="total-row total">
                    <span>Total</span>
                    <?php if ($total > 200): ?>
                        <span id="total-amount"><?php echo $moneda . number_format($totalConDescuento, 2); ?></span>
                    <?php else: ?>
                        <span id="total-amount"><?php echo $moneda . number_format($totalConDescuento + 7, 2); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="payment-section">
                <h3>Payment Method</h3>

                <div class="payment-method credit-card active">
                    <div class="method-header">
                        <input type="radio" name="payment-method" id="credit-card" checked>
                        <label for="credit-card">Credit / Debit Card</label>
                        <div class="card-icons">
                            <img src="/img/visa.png" alt="Visa">
                            <img src="/img/mastercard.png" alt="Mastercard">
                            <img src="/img/amex.png" alt="American Express">
                        </div>
                    </div>

                    <div class="method-content">
                        <!-- Square Payment Form -->
                        <div id="card-container"></div>
                        <div id="payment-status-container"></div>
                    </div>
                </div>
            </div>

            <button id="place-order-btn" class="place-order-btn">Complete Order</button>
        </div>
    </div>
</div>



<script type="text/javascript">
    // Initialize variables
    const appId = '<?php echo $square_application_id; ?>';
    const locationId = '<?php echo $square_location_id; ?>';
    let card;

    // Event listener for when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', async function() {
        // Make sure Square is loaded
        if (!window.Square) {
            console.error('Square.js failed to load properly');
            showMessage('Payment system is currently unavailable. Please try again later.', 'error');
            return;
        }

        try {
            // Initialize Square payment form
            const payments = window.Square.payments(appId, locationId);
            card = await payments.card();
            await card.attach('#card-container');
        } catch (e) {
            console.error('Initializing Card failed', e);
            showMessage('Payment system initialization failed. Please try again later.', 'error');
            return;
        }

        // Handle coupon application
        const applyCouponBtn = document.getElementById('apply-coupon');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', async () => {
                const cuponInput = document.getElementById('cupon-code');
                const codigo = cuponInput.value.trim();
                const cuponMessage = document.getElementById('coupon-message');

                cuponMessage.textContent = '';
                cuponMessage.classList.remove('error', 'success');

                if (!codigo) {
                    cuponMessage.textContent = 'Please enter a coupon code';
                    cuponMessage.classList.add('error');
                    return;
                }

                try {
                    const response = await fetch('carrito/aplicar-cupon', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            codigo
                        })
                    });

                    const data = await response.json();

                    if (data.ok) {
                        cuponMessage.textContent = data.mensaje;
                        cuponMessage.classList.add('success');
                        window.location.reload();
                    } else {
                        cuponMessage.textContent = data.mensaje;
                        cuponMessage.classList.add('error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    cuponMessage.textContent = 'Error applying coupon';
                    cuponMessage.classList.add('error');
                }
            });
        }

        // Handle coupon removal
        const removeCouponBtn = document.getElementById('remove-coupon');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', async () => {
                try {
                    const response = await fetch('carrito/quitar-cupon', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (data.ok) {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        }

        // Handle order placement
        const payButton = document.getElementById('place-order-btn');
        payButton.addEventListener('click', async function(event) {
            event.preventDefault();

            // Validate billing form
            const billingForm = document.getElementById('billing-form');
            if (!validateForm(billingForm)) {
                showMessage('Please fill all required fields', 'error');
                return;
            }

            try {
                // Disable the payment button
                payButton.disabled = true;
                payButton.textContent = 'Processing...';

                // Get a payment token from the card element
                const result = await card.tokenize();
                if (result.status === 'OK') {
                    // Payment token generation successful
                    console.log('Payment token generated:', result.token);

                    // Get current coupon code if any
                    const cuponInput = document.getElementById('cupon-code');
                    const cuponCodigo = cuponInput ? cuponInput.value.trim() : '';

                    // Process the payment with the token
                    const paymentResponse = await fetch('/procesar-pago', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            sourceId: result.token,
                            idempotencyKey: window.crypto.randomUUID(),
                            cuponCodigo: cuponCodigo
                        })
                    });

                    const paymentData = await paymentResponse.json();

                    if (paymentData.success) {
                        // Payment successful - redirect to confirmation page
                        window.location.href = `/confirmacion-pago?orden=${paymentData.orden_id}`;
                    } else {
                        // Payment failed
                        let errorMessage = 'Payment failed. Please try again.';
                        if (paymentData.message) {
                            errorMessage = paymentData.message;
                        }

                        showMessage(errorMessage, 'error');
                        payButton.disabled = false;
                        payButton.textContent = 'Complete Order';
                    }
                } else {
                    // Token generation failed
                    let errorMessage = '';
                    if (result.errors) {
                        errorMessage = result.errors[0].message;
                    }

                    showMessage(errorMessage || 'Card validation failed', 'error');
                    payButton.disabled = false;
                    payButton.textContent = 'Complete Order';
                }
            } catch (e) {
                console.error(e);
                showMessage('Payment processing error. Please try again.', 'error');
                payButton.disabled = false;
                payButton.textContent = 'Complete Order';
            }
        });
    });

    // Form validation helper
    function validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });

        return isValid;
    }

    // Show message helper
    function showMessage(message, type = 'info') {
        const statusContainer = document.getElementById('payment-status-container');
        statusContainer.innerHTML = `<div class="payment-status ${type}">${message}</div>`;
        statusContainer.scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>

<style>
    .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin: 30px 0;
    }

    .checkout-details {
        flex: 1;
        min-width: 300px;
    }

    .order-summary {
        flex: 1;
        min-width: 300px;
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-group {
        margin-bottom: 15px;
        width: 100%;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-group input.error {
        border-color: #ff3860;
    }

    .checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox input {
        width: auto;
    }

    .order-items {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .item-image {
        position: relative;
        margin-right: 15px;
    }

    .item-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .item-quantity {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #000;
        color: #fff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .item-details {
        flex: 1;
    }

    .item-details h3 {
        margin: 0 0 5px;
        font-size: 16px;
    }

    .item-variant {
        font-size: 14px;
        color: #666;
        margin: 0;
    }

    .item-price {
        font-weight: 600;
    }

    .coupon-section {
        margin: 20px 0;
    }

    .coupon-input {
        display: flex;
        gap: 10px;
    }

    .coupon-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .coupon-btn {
        padding: 10px 15px;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .coupon-message {
        margin-top: 10px;
        padding: 8px;
        border-radius: 4px;
        font-size: 14px;
        display: none;
    }

    .coupon-message:not(:empty) {
        display: block;
    }

    .coupon-message.error {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .coupon-message.success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .total-row.total {
        border-bottom: none;
        font-weight: 600;
        font-size: 18px;
        padding-top: 15px;
    }

    .discount-amount {
        color: #c62828;
    }

    .payment-section {
        margin: 25px 0;
    }

    .payment-method {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .method-header {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .method-header input {
        margin-right: 10px;
    }

    .card-icons {
        margin-left: auto;
        display: flex;
        gap: 10px;
    }

    .card-icons img {
        height: 24px;
    }

    .method-content {
        padding: 15px;
    }

    #card-container {
        min-height: 140px;
    }

    .place-order-btn {
        width: 100%;
        padding: 15px;
        background: #2e7d32;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .place-order-btn:hover {
        background: #1b5e20;
    }

    .place-order-btn:disabled {
        background: #9e9e9e;
        cursor: not-allowed;
    }

    .payment-status {
        margin-top: 15px;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
    }

    .payment-status.error {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .payment-status.success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .payment-status.info {
        background-color: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
    }

    /* Additional responsive styles */
    @media screen and (max-width: 768px) {
        .checkout-container {
            flex-direction: column;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .method-header {
            flex-wrap: wrap;
        }

        .card-icons {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
    }

    /* Improve focus states for accessibility */
    input:focus,
    button:focus {
        outline: 2px solid #1976d2;
        outline-offset: 2px;
    }

    /* Animated button state */
    .place-order-btn:active {
        transform: scale(0.98);
    }
</style>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>