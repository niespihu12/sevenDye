<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<section class="cart-main">
  <h2 class="cart-main__title">YOUR CART</h2>

  <div class="cart-main__grid">

    <div class="cart-products">
      <?php if ($carItems === []): ?>
        <p>Your cart is empty</p>
      <?php endif; ?>
      <?php foreach ($carItems as $item):
        $token = hash_hmac('sha1', $item->id, KEY_TOKEN);
      ?>
        <div class="cart-item">
          <div class="cart-item__image">
            <picture>
              <source srcset="<?php echo $item->imagen_avif; ?>" type="image/avif">
              <source srcset="<?php echo $item->imagen_webp; ?>" type="image/webp">
              <img loading="lazy" width="100" height="100" src="<?php echo $item->imagen_png; ?>" alt="<?php echo $item->nombre; ?>">
            </picture>
          </div>
          <div class="cart-item__info">
            <h3><?php echo $item->nombre; ?></h3>
            <div class="cart-item__details">
              <p>Size: <span><?php echo $item->talla; ?></span></p>
              <p>Color: <span><?php echo $item->color; ?></span></p>
              <p class="price"><?php echo $moneda . number_format($item->precio, 2); ?></p>
            </div>
          </div>
          <div class="cart-item__quantity">
            <button class="quantity-btn decrease" data-id="<?php echo $item->id; ?>">−</button>
            <input type="number" value="<?php echo $item->cantidad; ?>" min="1" readonly>
            <button class="quantity-btn increase" data-id="<?php echo $item->id; ?>">+</button>
          </div>
          <button class="cart-item__remove" data-id="<?php echo $item->id; ?>" data-token="<?php echo $token; ?>">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="cart-summary">
      <h3>ORDER SUMMARY</h3>

      <div class="summary-details">
        <div class="summary-row">
          <span>Subtotal</span>
          <span><?php echo $moneda . number_format($total, 2); ?></span>
        </div>
        <div class="summary-row discount">
          <span>Discount (-20%)</span>
          <span class="discount-amount">-<?php echo $moneda . number_format($total * 0.2, 2); ?></span>
        </div>
        <div class="summary-row">
          <span>Delivery Fee</span>
          <span>$15</span>
        </div>
        <div class="summary-row total">
          <span>Total</span>
          <span><?php echo $moneda . number_format($total * 0.8 + 15, 2); ?></span>
        </div>
      </div>

      <div class="promo-code">
        <input type="text" placeholder="Add promo code">
        <button class="promo-code__btn">Apply</button>
      </div>

      <button class="checkout-btn">
        Go to Checkout
        <span class="arrow">→</span>
      </button>
    </div>
  </div>
</section>

<script>
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const isIncrease = e.target.classList.contains('increase');
      const input = e.target.parentElement.querySelector('input');
      let cantidad = parseInt(input.value);

      cantidad = isIncrease ? cantidad + 1 : cantidad - 1;
      if (cantidad < 1) return;

      const id = e.target.dataset.id;

      try {
        const response = await fetch('/carrito/actualizar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            id,
            cantidad
          })
        });

        const data = await response.json();
        if (data.ok) {
          input.value = cantidad;
          // Actualizar totales
          window.location.reload();
        }
      } catch (error) {
        console.error('Error:', error);
      }
    });
  });
  document.querySelectorAll('.cart-item__remove').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const id = e.target.closest('button').dataset.id;
      const token = e.target.closest('button').dataset.token;

      try {
        const response = await fetch('/carrito/eliminar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            id,
            token
          })
        });

        const data = await response.json();
        if (data.ok) {
          e.target.closest('.cart-item').remove();
          window.location.reload();
        }
      } catch (error) {
        console.error('Error:', error);
      }
    });
  });
</script>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>