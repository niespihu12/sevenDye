<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<?php  $script = "<script  src='/build/js/pago.js'></script>" ?>
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
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Last Name</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="compañia">Company Name (optional)</label>
                        <input type="text" id="compañia" name="compañia">
                    </div>

                    <div class="form-group">
                        <label for="address">Street Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="apartment">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="apartment" name="apartment">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="town">Town/City</label>
                            <input type="text" id="town" name="town" required>
                        </div>
                        <div class="form-group">
                            <label for="postal">Postal Code</label>
                            <input type="text" id="postal" name="postal" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="termsandcondition" required>
                        <label for="termsandcondition"> I have read and agree to the website terms and conditions *</label>
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
                            <img src="/imagenes/<?php echo $imagenes[$item['clave']][0]->imagen; ?>" alt="<?php echo $item['producto']->nombre; ?>">
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
                    <?php if ($totalConDescuento > 200): ?>
                        <span>Shipping</span>
                        <span>Free</span>
                    <?php else: ?>
                        <span>Shipping</span>
                        <span><?php echo $moneda; ?>7.00</span>
                    <?php endif; ?>
                </div>

                <div class="total-row total">
                    <span>Total</span>
                    <?php if ($totalConDescuento > 200): ?>
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
    document.addEventListener('DOMContentLoaded', function() {
        initCheckout(
            '<?php echo $square_application_id; ?>', 
            '<?php echo $square_location_id; ?>'
        );
    });
</script>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>