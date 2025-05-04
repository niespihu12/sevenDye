<?php include_once __DIR__ . "/../templates/header-blog.php"; ?>


<main class="blog-categoria">
    <div class="blog-categoria-individual">
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-individual">
                <img class="blog-indi-img" src="/imagenes/<?php echo $blog->imagen ?>" alt="">

                <div class="blog-indi-text">
                    <p class="blog-indi-posted">Posted By <a href="sevendye.com">sevendye.com</a></p>
                    <h3><?php echo $blog->titulo ?></h3>

                    <div class="blog-indi-categories">
                        <a class="blog-indi-link" href="/blog/<?php echo urlencode($blog->slug); ?>?token=<?php echo hash_hmac('sha1', $blog->slug, KEY_TOKEN); ?>">
                            Read More
                        </a>
                        <p class="blog-indi-fecha">
                            <?php echo $blog->creado ?>
                        </p>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>

    </div>
    <div class="blog-categoria-categorias">
        <div>
            <h3>Blog</h3>
            <?php foreach ($publicaciones as $publicacion): ?>
                <a href="/blog/<?php echo urlencode($publicacion->slug); ?>?token=<?php echo hash_hmac('sha1', $publicacion->slug, KEY_TOKEN); ?>"><?php echo $publicacion->titulo ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</main>



<?php include_once __DIR__ . "/../templates/footer-blog.php"; ?>