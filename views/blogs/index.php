<?php include_once __DIR__ . "/../templates/header-blog.php"; ?>
<?php if (!empty($blogLatest)): ?>

  <div class="blog-container">
    <article class="featured-post">
      <div class="post-image">
        <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $blogUnico->imagen ?>" alt="Post 1">
        <div class="category-tag">Blog</div>
      </div>
      <div class="post-content">
        <h1><a href="/blog/<?php echo urlencode($blogUnico->slug); ?>"><?php echo $blogUnico->titulo ?></a></h1>
        <div class="post-meta">
          <div class="author">
            <picture>
              <source srcset="./build/img/logo_seven_sin_fondo.avif" type="image/avif">
              <source srcset="./build/img/logo_seven_sin_fondo.webp" type="image/webp">
              <img loading="lazy" width="100" height="100" src="./build/img/logo_seven_sin_fondo.png" alt="Author">
            </picture>

            <span><a href="https://sevendye.com/">Seven Dye</a></span>
          </div>
          <div class="post-info">
            <span><i class="far fa-calendar"></i> <?php echo $blogUnico->creado ?></span>
          </div>
        </div>
      </div>
    </article>

    <div class="posts-grid">
      <?php foreach ($blogLatest as $blog): ?>
        <article class="post-card">
          <div class="post-image">
            <img loading="lazy" width="100" height="100" src="/imagenes/<?php echo $blog->imagen ?>" alt="Post 1">

            <div class="category-tag">Blog</div>
          </div>
          <div class="post-content">
            <a href="/blog/<?php echo urlencode($blog->slug); ?>">
              <h2><?php echo $blog->titulo ?></h2>
            </a>
            <div class="post-meta">
              <div class="author">
                <picture>
                  <source srcset="./build/img/logo_seven_sin_fondo.avif" type="image/avif">
                  <source srcset="./build/img/logo_seven_sin_fondo.webp" type="image/webp">
                  <img loading="lazy" width="100" height="100" src="./build/img/logo_seven_sin_fondo.png" alt="Author">
                </picture>

                <span><a href="https://sevendye.com/">Seven Dye</a></span>
              </div>
              <span class="read-time"><?php echo $blog->creado ?></span>
            </div>
          </div>
        </article>


      <?php endforeach; ?>
    </div>

  </div>
<?php endif; ?>
<?php include_once __DIR__ . "/../templates/footer-blog.php"; ?>
