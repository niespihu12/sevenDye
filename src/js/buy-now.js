// Generate a unique idempotency key using a more robust method
function generateUniqueIdempotencyKey() {
    // Combine timestamp with a random string to ensure uniqueness
    const timestamp = Date.now();
    const randomStr = Math.random().toString(36).substring(2, 15);
    return `${timestamp}_${randomStr}`;
}

// Cuando el documento está listo
document.addEventListener('DOMContentLoaded', async function() {
    if (!window.Square) {
        throw new Error('Square.js no se cargó correctamente');
    }

    const payments = window.Square.payments(appId, locationId);

    try {
        const card = await payments.card();
        await card.attach('#card-container');

        const cardButton = document.getElementById('card-button');
        const paymentStatus = document.getElementById('payment-status-container');

        cardButton.addEventListener('click', async function() {
            // Validar el formulario de envío
            const billingForm = document.getElementById('billing-form');
            if (!billingForm.checkValidity()) {
                billingForm.reportValidity();
                return;
            }

            try {
                cardButton.disabled = true;
                cardButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                const result = await card.tokenize();

                if (result.status === 'OK') {
                    const billingDetails = {
                        nombre: document.getElementById('nombre').value,
                        apellido: document.getElementById('apellido').value,
                        compania: document.getElementById('company').value,
                        direccion: document.getElementById('direccion').value,
                        apartamento: document.getElementById('apartamento').value,
                        ciudad: document.getElementById('ciudad').value,
                        postal: document.getElementById('postal').value,
                        telefono: document.getElementById('telefono').value,
                        email: document.getElementById('email').value,
                        terminos: document.getElementById('termsandcondition').checked
                    };
                    // Generate a fresh idempotency key for this specific request
                    const requestIdempotencyKey = generateUniqueIdempotencyKey();
                    
                    const response = await fetch('/process-payment-product', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            sourceId: result.token,
                            idempotencyKey: requestIdempotencyKey,
                            productoId: productoId,
                            cantidad: cantidad,
                            tallaId: tallaId,
                            billingDetails: billingDetails
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        paymentStatus.innerHTML = '<div class="payment-success"><i class="fas fa-check-circle"></i><p>Payment completed successfully!</p></div>';

                        // Redirigir a la página de confirmación
                        setTimeout(function() {
                            window.location.href = '/confirmar-pago?orden=' + data.orden_id;
                        }, 2000);
                    } else {
                        cardButton.disabled = false;
                        cardButton.textContent = 'Pay ' + paymentAmount;
                        paymentStatus.innerHTML = '<div class="payment-error"><i class="fas fa-times-circle"></i><p>Payment failed: ' + (data.message || 'Unknown error') + '</p></div>';
                    }
                } else {
                    cardButton.disabled = false;
                    cardButton.textContent = 'Pay ' + paymentAmount;
                    paymentStatus.innerHTML = '<div class="payment-error"><i class="fas fa-times-circle"></i><p>Card tokenization failed: ' + result.errors[0].message + '</p></div>';
                }
            } catch (e) {
                cardButton.disabled = false;
                cardButton.textContent = 'Pay ' + paymentAmount;
                paymentStatus.innerHTML = '<div class="payment-error"><i class="fas fa-times-circle"></i><p>Payment error: ' + e.message + '</p></div>';
            }
        });
    } catch (e) {
        const paymentStatus = document.getElementById('payment-status-container');
        paymentStatus.innerHTML = '<div class="payment-error"><i class="fas fa-times-circle"></i><p>Error loading payment form: ' + e.message + '</p></div>';
    }
});