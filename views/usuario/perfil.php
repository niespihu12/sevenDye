<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<section class="profile-principal">
  <div class="profile-logout">
    <div class="profile-enlaces">

      <a href="/logout">logout</a>

    </div>

  </div>
  <div class="profile-fuera">
    <div class="profile-container">
      <h2>Edit Your Profile</h2>
      <form class="profile-form" method="POST" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group">
            <label for="firstName">Name</label>
            <input type="text" id="firstName" name="usuario[nombre]" value="<?php echo s($usuario->nombre); ?>" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" disabled value="<?php echo s($usuario->email); ?>" />
          </div>

        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="lastName">Phone</label>
            <input type="text" id="lastName" name="usuario[telefono]" value="<?php echo s($usuario->telefono); ?>" />
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="usuario[direccion]" value="<?php echo  s($usuario->direccion)  ?>" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="imagen">Image</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="usuario[imagen]">

          </div>
          <div class="form-group__imagen">
            <?php if ($usuario->imagen) { ?>
              <img class="campo-admin__image" src="/imagenes/<?php echo $usuario->imagen; ?>">
            <?php } ?>
          </div>
        </div>

        <div class="password-section">
          <label>Password Changes</label>
          <input type="password" placeholder="Current Password" />
          <input type="password" placeholder="New Password" />
          <input type="password" placeholder="Confirm New Password" />
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-save">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>