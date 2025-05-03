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
              <span>Discount (<?php echo $cupon['descuento']; ?>%)</span>
              <span class="discount-amount">-<?php echo $moneda . number_format(($total * $cupon['descuento']) / 100, 2); ?></span>
            </div>
          <?php endif; ?>

          <div class="summary-row">
            <?php if ($total > 200): ?>
              <span>Delivery Free</span>
              <span>$0</span>
            <?php else: ?>
              <span>Delivery Free</span>
              <span>$7</span>
            <?php endif; ?>
          </div>

          <div class="summary-row total">
            <span>Total</span>
            <?php if ($total > 200): ?>
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

        <div id="cupon-message" class="cupon-message"></div>

        <button class="checkout-btn">
          Go to Checkout
          <span class="arrow">→</span>
        </button>
      </div>
  </div>

<?php endif; ?>

</section>
<script>
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const isIncrease = e.target.classList.contains('increase');
      const input = e.target.parentElement.querySelector('input');
      let cantidad = parseInt(input.value);

      cantidad = isIncrease ? cantidad + 1 : cantidad - 1;
      if (cantidad < 1) return;

      const clave = e.target.dataset.clave;

      try {
        const response = await fetch('/carrito/actualizar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            clave,
            cantidad
          })
        });

        const data = await response.json();
        if (data.ok) {
          input.value = cantidad;
          window.location.reload();
        }
      } catch (error) {
        console.error('Error:', error);
      }
    });
  });

  document.querySelectorAll('.cart-item__remove').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      const clave = e.target.closest('button').dataset.clave;

      try {
        const response = await fetch('/carrito/eliminar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            clave
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

  // Aplicar cupón
  const applyCuponBtn = document.getElementById('apply-cupon-btn');
  if (applyCuponBtn) {
    applyCuponBtn.addEventListener('click', async () => {
      const cuponInput = document.getElementById('cupon-input');
      const codigo = cuponInput.value.trim();
      const cuponMessage = document.getElementById('cupon-message');

      if (!codigo) {
        cuponMessage.textContent = 'Please enter a coupon code';
        cuponMessage.classList.add('error');
        return;
      }

      try {
        const response = await fetch('/carrito/aplicar-cupon', {
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
          cuponMessage.classList.remove('error');
          cuponMessage.classList.add('success');
          window.location.reload();
        } else {
          cuponMessage.textContent = data.mensaje;
          cuponMessage.classList.remove('success');
          cuponMessage.classList.add('error');
        }
      } catch (error) {
        console.error('Error:', error);
        cuponMessage.textContent = 'Error applying coupon';
        cuponMessage.classList.add('error');
      }
    });
  }

  // Quitar cupón
  const removeCuponBtn = document.getElementById('remove-cupon-btn');
  if (removeCuponBtn) {
    removeCuponBtn.addEventListener('click', async () => {
      try {
        const response = await fetch('/carrito/quitar-cupon', {
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
</script>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>