document.querySelectorAll('.wishlist-remove').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const producto = e.target.closest('button').dataset.producto;

        try {
            const response = await fetch('/deseos/eliminar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    producto
                })
            });

            const data = await response.json();
            if (data.resultado) {
                e.target.closest('.deseo-item').remove();
                if (document.querySelectorAll('.deseo-item').length === 0) {
                    document.querySelector('.deseo-products').innerHTML = '<p>Your wishlist is empty</p>';
                }
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});