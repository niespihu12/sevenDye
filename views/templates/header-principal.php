<?php

use Model\Usuario;

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;
if ($auth) {
    $foto = Usuario::find($_SESSION['id'])->imagen;
}

?>

<header class="header contenedor">
    <div class="logo">
        <a href="/">
            <picture>
                <source srcset="/build/img/logo_de_seven.avif" type="image/avif">
                <source srcset="/build/img/logo_de_seven.webp" type="image/webp">
                <img width="100" height="100" loading="lazy" src="/build/img/logo_de_seven.jpg" alt="Logo de SevenDye">
            </picture>

        </a>
    </div>
    <div class="barra-mobile">
        <?php if ($auth) { ?>
            <a href="/profile" class="perfil-mobile">
                <img loading="lazy" src="/imagenes/<?php echo $foto ?>" alt="profile" width="100" height="100">
            </a>
        <?php } else { ?>
            <a class="profile" href="/login"><i class="bi bi-person-fill"></i></i></a>
        <?php } ?>
        <?php if ($auth) { ?>
            <a class="like" href="/wishlist"><i class="bi bi-heart-fill"></i></a>
        <?php } ?>
        <a class="carrito" href="/cart"><i class="bi bi-bag-fill"></i></a>
        <button id="abrir" class="abrir-menu"><i class="bi bi-list"></i></button>

    </div>

    <nav class="navegacion-principal">
        <a href="/">HOME</a>
        <a href="/store">SHOP</a>
        <a href="/about">ABOUT US</a>
        <a href="/blog">BLOG</a>
        <a href="/contact">CONTACT</a>
    </nav>
    <nav class="navegacion-secundaria">
        <div class="search-container">
            <div class="container">
                <input type="text" id="search-input-desktop" name="search" class="input" required placeholder="Type to search...">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <title>Search</title>
                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                    </svg>
                </div>
            </div>
            <div id="search-results-desktop" class="search-results">
            </div>
        </div>
        <?php if ($auth) { ?>
            <?php if ($foto) { ?>
                <a href="/profile" class="perfil">
                    <img loading="lazy" src="/imagenes/<?php echo $foto ?>" alt="profile" width="100" height="100">
                </a>
            <?php } else { ?>
                <a href="/profile" class="perfil">
                    <picture>
                        <source srcset="/build/img/default_pfp.avif" type="image/avif">
                        <source srcset="/build/img/default_pfp.webp" type="image/webp">
                        <img src="/build/img/default_pfp.png" alt="profile" width="100" height="100">
                    </picture>
                </a>
            <?php } ?>
        <?php } else { ?>
            <a class="sign-in-button" href="/login">Sign In</a>
        <?php } ?>
        <?php if ($auth) { ?>
            <a class="favoritos" href="/wishlist">
                <picture>
                    <source srcset="/build/img/favorite.avif" type="image/avif">
                    <source srcset="/build/img/favorite.webp" type="image/webp">
                    <img src="/build/img/favorite.jpg" alt="favorito" width="100" height="100">
                </picture>
            </a>
        <?php } ?>
        <a class="carrito" href="/cart"><i class="bi bi-bag-fill"></i></a>
    </nav>

    <nav class="navegacion-mobile" id="nav-mob">
        <button id="cerrar" class="cerrar-menu"><i class="bi bi-x"></i></button>
        <div class="search-container">
            <div class="container">
                <input type="text" id="search-input-mobile" name="search" class="input" required placeholder="Type to search...">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <title>Search</title>
                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                    </svg>
                </div>
            </div>
            <div id="search-results-mobile" class="search-results">
            </div>
        </div>
        <a href="/">HOME</a>
        <a href="/store">SHOP</a>
        <a href="/about">ABOUT US</a>
        <a href="/blog">BLOG</a>
        <a href="/contact">CONTACT</a>
    </nav>

</header>