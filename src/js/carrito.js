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
const applyCuponBtn = document.getElementById('apply-cupon-btn');
if (applyCuponBtn) {
    applyCuponBtn.addEventListener('click', async () => {
        const cuponInput = document.getElementById('cupon-input');
        const codigo = cuponInput.value.trim();
        const cuponMessage = document.getElementById('cupon-message');

        cuponMessage.textContent = '';
        cuponMessage.classList.remove('error', 'success');

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