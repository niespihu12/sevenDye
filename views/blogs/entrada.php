<?php include_once __DIR__ . "/../templates/header-blog.php"; ?>

<main class="blog-indi">
    <div class="blog-indi-individual">
        <!-- Blog Post Content -->
        <div class="blog-indi-individual-entrada">
            <img class="blog-post-header-image" src="/imagenes/<?php echo $blog->imagen ?>" alt="Featured post image">

            <div class="blog-post-meta">
                <div class="post-author">
                    <picture>
                        <source srcset="/build/img/logo_seven_sin_fondo.avif" type="image/avif">
                        <source srcset="/build/img/logo_seven_sin_fondo.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="./build/img/logo_seven_sin_fondo.png" alt="Author">
                    </picture>
                    <div class="author-info">
                        <span class="author-name">SevenDye Team</span>
                        <span class="post-date"><?php echo $blog->creado ?></span>
                    </div>
                </div>

                <div class="post-share">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <?php echo $blog->contenido; ?>
        </div>


    </div>

    <div class="blog-categoria-categorias">
        <div>
            <h3>Blog</h3>
            <?php foreach ($publicaciones as $publicacion): ?>
                <a href=""><?php echo $publicacion->titulo ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</main>


<?php include_once __DIR__ . "/../templates/footer-blog.php"; ?>