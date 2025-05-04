<?php

use Model\BlogCategoria;

$categorias = BlogCategoria::all();

?>

<header>
    <nav class="blog-nav">
        <div class="logo">
            <a href="/">
                <picture>
                    <source srcset="/build/img/logo_de_seven.avif" type="image/avif">
                    <source srcset="/build/img/logo_de_seven.webp" type="image/webp">
                    <img loading="lazy" width="100" height="100" src="/build/img/logo_de_seven.jpg" alt="Logo de SevenDye">
                </picture>
            </a>
        </div>
        <div class="nav-links">
            <a href="/blog" class="active">Latest</a>
            <?php foreach ($categorias as $categoria): ?>
                <a href="/blog/categoria/<?php echo urlencode($categoria->slug); ?>"><?php echo $categoria->nombre ?></a>
            <?php endforeach; ?>
        </div>
        <div class="nav-search">
            <div class="search-input-container">
                <input type="search" id="blog-search-input" placeholder="Buscar artículos...">
                <button class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div id="blog-search-results" class="search-results-container"></div>
        </div>
    </nav>
</header>