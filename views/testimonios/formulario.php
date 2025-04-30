<div class="testimonial-card-wide__avatar-section">
    <label class="testimonial-card-wide_avatar-section_label">Profile Image</label>
    <div class="testimonial-avatar-upload-wide" id="testimonialAvatarDrop">
        <?php if ($testimonio->imagen) { ?>
            <img src="/imagenes/<?php echo $testimonio->imagen; ?>" alt="Testimonial image" class="testimonial-avatar-upload-wide__img" id="testimonialAvatarPreview">
        <?php } else { ?>
            <div class="testimonial-avatar-upload-wide__placeholder" id="testimonialAvatarPreview">
                <svg class="testimonial-avatar-upload-wide__icon" viewBox="0 0 24 24">
                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                </svg>
            </div>
        <?php } ?>
        <input class="testimonial-avatar-upload-wide__input" type="file" id="imagen" accept="image/jpeg, image/png, image/webp" name="imagen">
        <div class="testimonial-avatar-upload-wide__overlay">
            <svg class="testimonial-avatar-upload-wide__cloud" viewBox="0 0 24 24">
                <path d="M19.35,10.04C18.67,6.59 15.64,4 12,4C9.11,4 6.6,5.64 5.35,8.04C2.34,8.36 0,10.91 0,14A6,6 0 0,0 6,20H19A5,5 0 0,0 24,15C24,12.36 21.95,10.22 19.35,10.04M14,13V17H10V13H7L12,8L17,13H14Z" />
            </svg>
            <span>Click o arrastra una imagen</span>
        </div>
    </div>
    <div class="testimonial-avatar-upload-wide__meta">
        <span id="testimonialAvatarDragText">JPG, PNG o WEBP. Máx 5MB</span>
        <span class="testimonial-avatar-upload-wide__size" id="testimonialAvatarSize"></span>
    </div>
    <div class="testimonial-avatar-upload-wide__error" id="testimonialAvatarError"></div>
</div>

<!-- Form Fields -->
<div class="testimonial-card-wide__form-section">
    <div class="testimonial-form-field-wide">
        <label class="testimonial-form-field-wide__label" for="nombre">Name</label>
        <input class="testimonial-form-field-wide__input" type="text" id="nombre" name="nombre" placeholder="Name" value="<?php echo s($testimonio->nombre); ?>">
    </div>

    <div class="testimonial-form-field-wide">
        <label class="testimonial-form-field-wide__label" for="rol">Role</label>
        <input class="testimonial-form-field-wide__input" type="text" id="rol" name="rol" placeholder="Role" value="<?php echo s($testimonio->rol); ?>">
    </div>

    <div class="testimonial-form-field-wide">
        <label class="testimonial-form-field-wide__label" for="mensaje">Testimonial</label>
        <textarea id="mensaje" class="testimonial-form-field-wide__textarea" name="mensaje" placeholder="Share your experience..."><?php echo s($testimonio->mensaje); ?></textarea>
        <span class="testimonial-form-field-wide__counter" id="testimonialCounter"><?php echo strlen($testimonio->mensaje); ?> characters</span>
    </div>

    <div class="testimonial-form-actions-wide">
        <button type="submit" class="testimonial-form-btn-wide">Save Testimonial</button>
    </div>
</div>