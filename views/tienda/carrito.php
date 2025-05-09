<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<section class="cart-main">
  <h2 class="cart-main__title">YOUR CART</h2>

  <div class="cart-main__grid">

    <div class="cart-products">
      <?php if ($carItems === []): ?>
        <p>Your cart is empty</p>
      <?php endif; ?>
      <?php foreach ($carItems as $item): ?>
        <div class="cart-item">
          <div class="cart-item__image">
            <img loading="lazy" src="/imagenes/<?php echo $imagenes[$item['id']] ?>" alt="<?php echo $item['producto']->nombre ?>">
          </div>
          <div class="cart-item__info">
            <h3><?php echo $item['producto']->nombre; ?></h3>
            <div class="cart-item__details">
              <?php if ($item['talla']): ?>
                <p>Size: <span><?php echo $item['talla']; ?></span></p>
              <?php endif; ?>
              <p class="price"><?php echo $moneda . number_format($item['precio'], 2); ?></p>
            </div>
          </div>
          <div class="cart-item__quantity">
            <button class="quantity-btn decrease" data-clave="<?php echo $item['clave']; ?>">−</button>
            <input type="number" value="<?php echo $item['cantidad']; ?>" min="1" readonly>
            <button class="quantity-btn increase" data-clave="<?php echo $item['clave']; ?>">+</button>
          </div>
          <button class="cart-item__remove" data-clave="<?php echo $item['clave']; ?>">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if ($carItems === []): ?>

    <?php else: ?>
      <div class="cart-summary">
        <h3>ORDER SUMMARY</h3>

        <div class="summary-details">
          <div class="summary-row">
            <span>Subtotal</span>
            <span><?php echo $moneda . number_format($total, 2); ?></span>
          </div>

          <?php if ($cupon): ?>
            <div class="summary-row discount">
              <?php if ($cupon['tipo_descuento'] === 'porcentaje'): ?>
                <span>Discount (<?php echo $cupon['descuento']; ?>%)</span>
                <span class="discount-amount">-<?php echo $moneda . number_format(($total * $cupon['descuento']) / 100, 2); ?></span>
              <?php else: ?>
                <span>Discount (Fixed)</span>
                <span class="discount-amount">-<?php echo $moneda . number_format($cupon['descuento'], 2); ?></span>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="summary-row">
            <?php if ($totalConDescuento > 200): ?>
              <span>Shipping</span>
              <span>Free</span>
            <?php else: ?>
              <span>Shipping</span>
              <span><?php echo $moneda; ?>7.00</span>
            <?php endif; ?>
          </div>

          <div class="summary-row total">
            <span>Total</span>
            <?php if ($totalConDescuento > 200): ?>
              <span><?php echo $moneda . number_format($totalConDescuento, 2); ?></span>
            <?php else: ?>
              <span><?php echo $moneda . number_format($totalConDescuento + 7, 2); ?></span>
            <?php endif; ?>
          </div>
        </div>

        <div class="promo-code">
          <input type="text" id="cupon-input" placeholder="Add promo code" value="<?php echo $cupon ? $cupon['codigo'] : ''; ?>" <?php echo $cupon ? 'disabled' : ''; ?>>
          <?php if ($cupon): ?>
            <button class="promo-code__btn" id="remove-cupon-btn">Remove</button>
          <?php else: ?>
            <button class="promo-code__btn" id="apply-cupon-btn">Apply</button>
          <?php endif; ?>
        </div>

        <div id="cupon-message" class="cupon-message <?php echo isset($_SESSION['cupon_error']) ? 'error' : ''; ?>">
          <?php 
            if (isset($_SESSION['cupon_error'])) {
              echo $_SESSION['cupon_error'];
              unset($_SESSION['cupon_error']);
            } elseif (isset($_SESSION['cupon_success'])) {
              echo $_SESSION['cupon_success'];
              unset($_SESSION['cupon_success']);
            }
          ?>
        </div>

        <a class="checkout-btn" href="/payment">
          Go to Checkout
          <span class="arrow">→</span>
        </a>
      </div>
  </div>

<?php endif; ?>

</section>
<?php $script = "<script src='/build/js/carrito.js'></script>"; ?>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>