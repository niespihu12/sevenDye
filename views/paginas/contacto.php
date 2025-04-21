<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<section class="contact-section">
    <h2 class="section-title">Contact Us</h2>

    <div class="contact-container">
        <!-- Información de contacto -->
        <div class="contact-info">
            <div class="info-card">
                <div class="icon-container">
                    <i class="fas fa-phone-alt"></i>
                    <picture>
                        <source srcset="./build/img/telefono.avif" type="image/avif">
                        <source srcset="./build/img/telefono.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/telefono.png" alt="">
                    </picture>
                </div>
                <h3>Call to Us</h3>
                <p class="availability">We are available 24/7, 7 days a week.</p>
                <p class="phone">Phone: +880161111222</p>
            </div>

            <div class="info-card">
                <div class="icon-container">
                    <i class="fas fa-envelope"></i>
                    <picture>
                        <source srcset="./build/img/correo-electronico.avif" type="image/avif">
                        <source srcset="./build/img/correo-electronico.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/correo-electronico.png" alt="">
                    </picture>
                </div>
                <h3>Write to Us</h3>
                <p class="message">Fill out our form and we will contact you within 24 hours.</p>
                <div class="email-list">
                    <p>customer@exclusive.com</p>
                    <p>support@exclusive.com</p>
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i>
                    <picture>
                        <source srcset="./build/img/tik-tok.avif" type="image/avif">
                        <source srcset="./build/img/tik-tok.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/tik-tok.jpg" alt="">
                    </picture>
                </a>
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i>
                    <picture>
                        <source srcset="./build/img/instagram.avif" type="image/avif">
                        <source srcset="./build/img/instagram.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/instagram.jpg" alt="">
                    </picture>
                </a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i>
                    <picture>
                        <source srcset="./build/img/facebook.avif" type="image/avif">
                        <source srcset="./build/img/facebook.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/facebook.jpg" alt="">
                    </picture>
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <div class="contact-form">
            <?php if ($mensaje) { ?>
                <p class="alerta texto"><?php echo $mensaje; ?></p>
            <?php } ?>
            <form id="contactForm" action="/contacto" method="post">
                <div class="form-row">
                    <input type="text" name="contacto[nombre]" placeholder="Your Name" required>
                    <input type="email" name="contacto[email]" placeholder="Your Email" required>
                    <input type="tel" name="contacto[telefono]" placeholder="Your Phone" required>
                </div>
                <textarea name="contacto[mensaje]" placeholder="Your Message" rows="6" required></textarea>
                <button type="submit" class="submit-btn">
                    Send Message
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>
