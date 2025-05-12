<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<main class="container buy-now-page">
    <div class="buy-now-container">
        <h1 class="page-title">Complete Your Purchase</h1>

        <div class="buy-now-content">
            <div class="order-summary">
                <h2>Order Summary</h2>

                <div class="product-summary">
                    <div class="product-summary-image">
                        <img src="/imagenes/<?php echo $imagen ?>" alt="<?php echo $producto->nombre ?>">
                    </div>
                    <div class="product-summary-info">
                        <h3><?php echo $producto->nombre ?></h3>
                        <p class="product-summary-price"><?php echo $moneda . $precio ?></p>
                        <p class="product-summary-quantity">Quantity: <?php echo $cantidad ?></p>
                        <?php if ($talla_id): ?>
                            <p class="product-summary-size">Size ID: <?php echo $talla_id ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="order-details">
                    <div class="order-detail-row">
                        <span>Subtotal:</span>
                        <span><?php echo $moneda . number_format($total, 2) ?></span>
                    </div>

                    <div class="order-detail-row">
                        <span>Shipping:</span>
                        <span><?php echo $costoEnvio > 0 ? $moneda . number_format($costoEnvio, 2) : 'Free' ?></span>
                    </div>

                    <div class="order-detail-row total">
                        <span>Total:</span>
                        <span><?php echo $moneda . number_format($totalConEnvio, 2) ?></span>
                    </div>
                </div>
            </div>
            <div class="shipping-section">
                <h2>Billing Information</h2>

                <form id="billing-form" class="shipping-form">
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
                        <label for="company">Company Name (optional)</label>
                        <input type="text" id="company" name="company">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Street Address</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>

                    <div class="form-group">
                        <label for="apartamento">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="apartamento" name="apartamento">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ciudad">Town/City</label>
                            <input type="text" id="ciudad" name="ciudad" required>
                        </div>
                        <div class="form-group">
                            <label for="postal">Postal Code</label>
                            <input type="text" id="postal" name="postal" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Phone Number</label>
                        <input type="tel" id="telefono" name="telefono" required>
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
            <div class="payment-section">
                <h2>Payment Information</h2>

                <div class="payment-form">
                    <div id="card-container"></div>
                    <button id="card-button" type="button" class="buy-now-pay-button">Pay <?php echo $moneda . number_format($totalConEnvio, 2) ?></button>
                    <div id="payment-status-container"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    const appId = '<?php echo $square_application_id ?>';
    const locationId = '<?php echo $square_location_id ?>';
    const isSandbox = <?php echo $square_sandbox ? 'true' : 'false' ?>;

    const productoId = '<?php echo $producto->id ?>';
    const cantidad = '<?php echo $cantidad ?>';
    const tallaId = '<?php echo $talla_id ?>';
    
    const paymentAmount = '<?php echo $moneda . number_format($totalConEnvio, 2) ?>';
</script>

<?php $script = "<script src='/build/js/buy-now.js'></script>"; ?>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>