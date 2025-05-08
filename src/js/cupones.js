document.addEventListener('DOMContentLoaded', function() {
    const tipoDescuentoSelect = document.getElementById('tipo_descuento');
    const tipoPedidoMinimoSelect = document.getElementById('tipo_pedido_minimo');
    const campoMinimoPedido = document.getElementById('campo_minimo_pedido');
    const descuentoInput = document.getElementById('descuento');
    
    // Cambiar placeholder según el tipo de descuento
    tipoDescuentoSelect.addEventListener('change', function() {
        if (this.value === 'porcentaje') {
            descuentoInput.placeholder = 'ej: 15 (para 15%)';
        } else if (this.value === 'fijo') {
            descuentoInput.placeholder = 'ej: 50.00 (para $50)';
        }
    });
    
    // Mostrar/ocultar campo de monto mínimo
    tipoPedidoMinimoSelect.addEventListener('change', function() {
        if (this.value === 'monto') {
            campoMinimoPedido.style.display = 'block';
        } else {
            campoMinimoPedido.style.display = 'none';
            document.getElementById('minimo_pedido').value = '';
        }
    });
});