<div class="profile-card-wide__avatar-section">
    <label class="profile-card-wide_avatar-section_label">Profile Image</label>
    <div class="profile-avatar-upload-wide" id="avatarDrop">
        <?php if ($influencer->imagen) { ?>
            <img src="/imagenes/<?php echo $influencer->imagen; ?>" alt="Profile image" class="profile-avatar-upload-wide__img" id="avatarPreview">
        <?php } else { ?>
            <div class="profile-avatar-upload-wide__placeholder" id="avatarPreview">
                <svg class="profile-avatar-upload-wide__icon" viewBox="0 0 24 24">
                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                </svg>
            </div>
        <?php } ?>
        <input class="profile-avatar-upload-wide__input" type="file" id="imagen" accept="image/jpeg, image/png, image/webp" name="imagen">
        <div class="profile-avatar-upload-wide__overlay">
            <svg class="profile-avatar-upload-wide__cloud" viewBox="0 0 24 24">
                <path d="M19.35,10.04C18.67,6.59 15.64,4 12,4C9.11,4 6.6,5.64 5.35,8.04C2.34,8.36 0,10.91 0,14A6,6 0 0,0 6,20H19A5,5 0 0,0 24,15C24,12.36 21.95,10.22 19.35,10.04M14,13V17H10V13H7L12,8L17,13H14Z" />
            </svg>
            <span>Click o arrastra una imagen</span>
        </div>
    </div>
    <div class="profile-avatar-upload-wide__meta">
        <span id="avatarDragText">JPG, PNG o WEBP. Máx 5MB</span>
        <span class="profile-avatar-upload-wide__size" id="avatarSize"></span>
    </div>
    <div class="profile-avatar-upload-wide__error" id="avatarError"></div>
</div>

<!-- Form Fields -->
<div class="profile-card-wide__form-section">
    <div class="profile-form-field-wide">
        <label class="profile-form-field-wide__label" for="nombre">Name</label>
        <input class="profile-form-field-wide__input" type="text" id="nombre" name="nombre" placeholder="Name" value="<?php echo s($influencer->nombre); ?>">
    </div>
    <div class="profile-form-field-wide">
        <label class="profile-form-field-wide__label" for="youtube">Youtube</label>
        <input class="profile-form-field-wide__input" type="text" id="youtube" name="youtube" placeholder="Youtube" value="<?php echo s($influencer->youtube); ?>">
    </div>
    <div class="profile-form-field-wide">
        <label class="profile-form-field-wide__label" for="instagram">Instagram</label>
        <input class="profile-form-field-wide__input" type="text" id="instagram" name="instagram" placeholder="Instagram" value="<?php echo s($influencer->instagram); ?>">
    </div>
    <div class="profile-form-field-wide">
        <label class="profile-form-field-wide__label" for="tiktok">Tiktok</label>
        <input class="profile-form-field-wide__input" type="text" id="tiktok" name="tiktok" placeholder="Tiktok" value="<?php echo s($influencer->tiktok); ?>">
    </div>
    <div class="profile-form-field-wide" style="margin-bottom: 1.2rem;">
        <label class="profile-form-field-wide__label" for="descripcion">Description</label>
        <textarea id="descripcion" maxlength="300" class="profile-form-field-wide_input profile-form-field-wide_input--textarea" name="descripcion" placeholder="Describe yourself..."><?php echo s($influencer->descripcion); ?></textarea>
        <span class="profile-form-field-wide__desc-counter" id="descCounter">0/300</span>
    </div>
    <div class="profile-form-actions-wide">
        <button type="submit" class="profile-form-btn-wide">Save Profile</button>
    </div>
</div>