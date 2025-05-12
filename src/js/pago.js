// Initialize variables
let appId, locationId;
let card;

document.addEventListener('DOMContentLoaded', async function () {
    if (!window.Square) {
        console.error('Square.js failed to load properly');
        showMessage('Payment system is currently unavailable. Please try again later.', 'error');
        return;
    }

    try {
        const payments = window.Square.payments(appId, locationId);
        card = await payments.card();
        await card.attach('#card-container');
    } catch (e) {
        console.error('Initializing Card failed', e);
        showMessage('Payment system initialization failed. Please try again later.', 'error');
        return;
    }

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
                const response = await fetch('/cart/apply-coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ codigo })
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

    const removeCouponBtn = document.getElementById('remove-coupon');
    if (removeCouponBtn) {
        removeCouponBtn.addEventListener('click', async () => {
            try {
                const response = await fetch('/cart/remove-coupon', {
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

    const payButton = document.getElementById('place-order-btn');
    payButton.addEventListener('click', async function (event) {
        event.preventDefault();

        const billingForm = document.getElementById('billing-form');
        if (!validateForm(billingForm)) {
            showMessage('Please fill all required fields', 'error');
            return;
        }

        try {
            payButton.disabled = true;
            payButton.textContent = 'Processing...';

            const result = await card.tokenize();
            if (result.status === 'OK') {
                console.log('Payment token generated:', result.token);

                // Collect billing details
                const billingDetails = {
                    nombre: document.getElementById('nombre').value,
                    apellido: document.getElementById('apellido').value,
                    compania: document.getElementById('compañia').value,
                    direccion: document.getElementById('address').value,
                    apartamento: document.getElementById('apartment').value,
                    ciudad: document.getElementById('town').value,
                    postal: document.getElementById('postal').value,
                    telefono: document.getElementById('phone').value,
                    email: document.getElementById('email').value,
                    terminos: document.getElementById('termsandcondition').checked
                };

                

                const cuponInput = document.getElementById('cupon-code');
                const cuponCodigo = cuponInput ? cuponInput.value.trim() : '';

                const idempotencyKey = crypto.randomUUID ? crypto.randomUUID() : generateUUID();

                const paymentResponse = await fetch('/process-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        sourceId: result.token,
                        idempotencyKey: idempotencyKey,
                        cuponCodigo: cuponCodigo,
                        billingDetails: billingDetails
                    })
                });

                const paymentData = await paymentResponse.json();

                if (paymentData.success) {
                    window.location.href = `/confirmacion-pago?orden=${paymentData.orden_id}`;
                } else {
                    let errorMessage = paymentData.message || 'Payment failed. Please try again.';
                    if (paymentData.errors) {
                        console.error('Square Payment Error:', paymentData.errors);

                        // Display validation errors if present
                        if (typeof paymentData.errors === 'object' && Object.keys(paymentData.errors).length > 0) {
                            const errorMessages = [];
                            for (const field in paymentData.errors) {
                                errorMessages.push(paymentData.errors[field]);
                            }
                            errorMessage = errorMessages.join('<br>');
                        }
                    }
                    showMessage(errorMessage, 'error');
                    payButton.disabled = false;
                    payButton.textContent = 'Complete Order';
                }
            } else {
                const errorMessage = result.errors?.[0]?.message || 'Card validation failed';
                showMessage(errorMessage, 'error');
                payButton.disabled = false;
                payButton.textContent = 'Complete Order';
            }
        } catch (e) {
            console.error('Payment Error:', e);
            showMessage('Payment processing error. Please try again.', 'error');
            payButton.disabled = false;
            payButton.textContent = 'Complete Order';
        }
    });
});

function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        const r = Math.random() * 16 | 0;
        const v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

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

function showMessage(message, type = 'info') {
    const statusContainer = document.getElementById('payment-status-container');
    statusContainer.innerHTML = `<div class="payment-status ${type}">${message}</div>`;
    statusContainer.scrollIntoView({ behavior: 'smooth' });
}

function initCheckout(squareAppId, squareLocationId) {
    appId = squareAppId;
    locationId = squareLocationId;
}