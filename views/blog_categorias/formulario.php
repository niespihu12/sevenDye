<div class="admin-form-container">
  <div class="form-header">
    <h1>
      <i class="fas fa-folder"></i> Administrar Categoría de Blog
    </h1>
    <p>Complete los detalles de la categoría para gestionar su catálogo de entradas de blog</p>
  </div>

  <div class="form-grid">
    <div class="form-column">
      <div class="form-card">
        <h3 class="form-card__title">
          <i class="fas fa-info-circle"></i> Información de la Categoría
        </h3>
        
        <div class="form-field">
          <label class="form-field__label" for="nombre">
            <i class="fas fa-tag"></i> Nombre de la Categoría
          </label>
          <div class="input-with-icon">
            <input 
              class="form-field__input" 
              type="text" 
              id="nombre" 
              name="nombre" 
              placeholder="Ej: Tutoriales, Noticias, Eventos..."
              value="<?php echo s($categoria->nombre); ?>"
            >
            <i class="fas fa-folder input-icon"></i>
          </div>
          <div class="input-hint">Usa un nombre descriptivo y conciso</div>
        </div>

        <div class="form-field">
          <label class="form-field__label" for="slug">
            <i class="fas fa-link"></i> Slug de la Categoría
          </label>
          <div class="input-with-icon">
            <input 
              class="form-field__input" 
              type="text" 
              id="slug" 
              name="slug" 
              placeholder="Ej: tutoriales, noticias, eventos..."
              value="<?php echo s($categoria->slug); ?>"
            >
            <i class="fas fa-link input-icon"></i>
          </div>
          <div class="input-hint">El slug se usa en las URLs (solo letras minúsculas, números y guiones)</div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="submit-button">
      <i class="fas fa-save"></i> Guardar Categoría
    </button>
  </div>
</div>