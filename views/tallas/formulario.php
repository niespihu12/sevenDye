<div class="admin-form-container">
  <div class="form-header">
    <h1>
      <i class="fas fa-ruler-combined"></i> Administrar Talla
    </h1>
    <p>Complete los detalles de la talla para gestionar su catálogo de productos</p>
  </div>

  <div class="form-grid">
    <div class="form-column">
      <div class="form-card">
        <h3 class="form-card__title">
          <i class="fas fa-info-circle"></i> Información de la Talla
        </h3>
        
        <div class="form-field">
          <label class="form-field__label" for="nombre">
            <i class="fas fa-tag"></i> Nombre de la Talla
          </label>
          <div class="input-with-icon">
            <input 
              class="form-field__input" 
              type="text" 
              id="nombre" 
              name="nombre" 
              placeholder="Ej: S, M, L, XL o 28, 30, 32..."
              value="<?php echo s($talla->nombre); ?>"
            >
            <i class="fas fa-ruler input-icon"></i>
          </div>
          <div class="input-hint">Usa un formato consistente para mejor organización</div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="submit-button">
      <i class="fas fa-save"></i> Guardar Talla
    </button>
  </div>
</div>