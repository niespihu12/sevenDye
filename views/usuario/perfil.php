<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>

<
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="/perfil-edit.css">

<section class="profile-principal">
  <div class="decorative-circle circle-1"></div>
  <div class="decorative-circle circle-2"></div>
  <div class="decorative-circle circle-3"></div>
  
  <div class="profile-fuera">
    <div class="profile-logout">
      <div class="user-avatar">
        <?php if ($usuario->imagen) { ?>
          <img src="/imagenes/<?php echo $usuario->imagen; ?>" alt="Foto de perfil">
        <?php } else { ?>
          <div class="avatar-placeholder">
            <i class="fas fa-user"></i>
          </div>
        <?php } ?>
      </div>
      <h3><?php echo s($usuario->nombre); ?></h3>
      <div class="profile-enlaces">
        <a href="/deseos"><i class="fas fa-heart"></i> Favoritos</a>
        <?php if($usuario->rolId == 2): ?>
          <a href="/admin"><i class="fas fa-user-shield"></i> Administrador</a>
        <?php endif; ?>
        <a href="/logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
      </div>
    </div>
    
    <div class="profile-container">
      <h2>Editar tu Perfil</h2>
      
      <?php if(isset($alertas)): ?>
        <div class="alertas">
          <?php foreach($alertas as $tipo => $mensajes): 
            $claseAlerta = ($tipo === 'exito') ? 'alert-success' : 'alert-error';
          ?>
            <?php foreach($mensajes as $mensaje): ?>
              <div class="alerta <?php echo $claseAlerta; ?>">
                <?php echo $mensaje; ?>
              </div>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      
      <form class="profile-form" method="POST" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group">
            <label for="firstName"><i class="fas fa-user"></i> Nombre</label>
            <input type="text" id="firstName" name="nombre" value="<?php echo s($usuario->nombre); ?>" />
          </div>
          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="email" disabled value="<?php echo s($usuario->email); ?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="lastName"><i class="fas fa-phone"></i> Teléfono</label>
            <input type="text" id="lastName" name="telefono" value="<?php echo s($usuario->telefono); ?>" />
          </div>
          <div class="form-group">
            <label for="address"><i class="fas fa-map-marker-alt"></i> Dirección</label>
            <input type="text" id="address" name="direccion" value="<?php echo s($usuario->direccion); ?>" />
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="imagen"><i class="fas fa-image"></i> Imagen de Perfil</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <p class="file-help">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</p>
          </div>
          <div class="form-group__imagen">
            <?php if ($usuario->imagen) { ?>
              <img src="/imagenes/<?php echo $usuario->imagen; ?>" alt="Imagen de perfil actual">
            <?php } else { ?>
              <div class="no-image">
                <i class="fas fa-user-circle"></i>
                <p>Sin imagen</p>
              </div>
            <?php } ?>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-cancel" onclick="window.location.href='/'">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-save">
            <i class="fas fa-save"></i> Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</section>


<?php 
  $script = "
    <script src='build/js/perfil.js'></script>
  ";
?>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>