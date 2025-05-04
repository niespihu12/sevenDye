<div class="formulario-admin">
    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-ticket-alt"></i> Información del Cupón
            </h3>

            <div class="campo-admin">
                <label class="campo-admin__label" for="codigo">
                    <i class="fas fa-tag"></i> Código
                </label>
                <input class="campo-admin__field" type="text" id="codigo" name="codigo" placeholder="ej: VERANO2025" value="<?php echo s($cupon->codigo); ?>">
            </div>

            <div class="campo-admin">
                <label class="campo-admin__label" for="descripcion">
                    <i class="fas fa-align-left"></i> Descripción
                </label>
                <textarea id="descripcion" class="campo-admin_field campo-admin_field--textarea" name="descripcion" placeholder="Descripción detallada del cupón"><?php echo s($cupon->descripcion); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-percent"></i> Configuración del Descuento
            </h3>
            
            <div class="campo-admin">
                <label class="campo-admin__label" for="tipo_descuento">Tipo de Descuento</label>
                <select name="tipo_descuento" id="tipo_descuento" class="campo-admin__select">
                    <option value="" selected disabled>-- Seleccionar --</option>
                    <option value="porcentaje" <?php echo $cupon->tipo_descuento === 'porcentaje' ? 'selected' : ''; ?>>Porcentaje (%)</option>
                    <option value="fijo" <?php echo $cupon->tipo_descuento === 'fijo' ? 'selected' : ''; ?>>Monto Fijo ($)</option>
                </select>
            </div>

            <div class="campo-admin">
                <label class="campo-admin__label" for="descuento">
                    <i class="fas fa-dollar-sign"></i> Valor del Descuento
                </label>
                <input 
                    class="campo-admin__field" 
                    type="number" 
                    id="descuento" 
                    name="descuento" 
                    step="0.01" 
                    min="0" 
                    placeholder="<?php echo $cupon->tipo_descuento === 'porcentaje' ? 'ej: 15 (para 15%)' : 'ej: 50.00 (para $50)'; ?>" 
                    value="<?php echo s($cupon->descuento); ?>"
                >
            </div>

            <div class="campo-admin">
                <label class="campo-admin__label" for="tipo_pedido_minimo">Tipo de Mínimo para Pedido</label>
                <select name="tipo_pedido_minimo" id="tipo_pedido_minimo" class="campo-admin__select">
                    <option value="" selected disabled>-- Seleccionar --</option>
                    <option value="ninguno" <?php echo $cupon->tipo_pedido_minimo === 'ninguno' ? 'selected' : ''; ?>>Sin mínimo</option>
                    <option value="monto" <?php echo $cupon->tipo_pedido_minimo === 'monto' ? 'selected' : ''; ?>>Monto mínimo</option>
                </select>
            </div>

            <div class="campo-admin" id="campo_minimo_pedido" <?php echo $cupon->tipo_pedido_minimo === 'ninguno' ? 'style="display: none;"' : ''; ?>>
                <label class="campo-admin__label" for="minimo_pedido">
                    <i class="fas fa-dollar-sign"></i> Monto Mínimo del Pedido
                </label>
                <input 
                    class="campo-admin__field" 
                    type="number" 
                    id="minimo_pedido" 
                    name="minimo_pedido" 
                    step="0.01" 
                    min="0" 
                    placeholder="ej: 100.00" 
                    value="<?php echo s($cupon->minimo_pedido); ?>"
                >
            </div>
        </div>
    </div>
    
    <div class="form-column">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-calendar-alt"></i> Vigencia
            </h3>
            
            <div class="campo-admin">
                <label class="campo-admin__label" for="expira">
                    <i class="fas fa-clock"></i> Fecha de Expiración
                </label>
                <input 
                    class="campo-admin__field" 
                    type="datetime-local" 
                    id="expira" 
                    name="expira" 
                    value="<?php echo $cupon->expira ? date('Y-m-d\TH:i', strtotime($cupon->expira)) : ''; ?>"
                >
            </div>
        </div>
    </div>
</div>

<script>
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
</script>