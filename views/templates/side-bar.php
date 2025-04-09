<?php 
// Obtener la página actual para resaltar el enlace activo
$current_page = basename($_SERVER['PHP_SELF']);

// Función para determinar si un enlace está activo
function isActive($page) {
    global $current_page;
    return ($current_page === $page) ? 'is-active' : '';
}
?>

<aside class="admin-sidebar">
    <div class="admin-sidebar__logo">
        <img src="/src/img/logo_de_seven.jpg" alt="Seven Logo">
        <img src="" alt="">
    </div>

    <nav class="admin-sidebar__menu">
        <a href="/dashboard" class="admin-sidebar__nav-link <?php echo isActive('dashboard.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4 13h6V3H4v10zm0 8h6v-6H4v6zm8 0h6V11h-6v10zm0-18v6h6V3h-6z"/>
            </svg>
            Dashboard
        </a>
        <a href="/productos/admin" class="admin-sidebar__nav-link <?php echo isActive('productos.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 7H3V3h8v4zm0 8H3v-4h8v4zm10 0h-8v-4h8v4zm0-8h-8V3h8v4z"/>
            </svg>
            Productos
        </a>
        <a href="/ordenes/admin" class="admin-sidebar__nav-link <?php echo isActive('ordenes.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
            Ordenes
        </a>
        <a href="/clientes/admin" class="admin-sidebar__nav-link <?php echo isActive('clientes.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Clientes
        </a>
        <a href="/resenas/admin" class="admin-sidebar__nav-link <?php echo isActive('resenas.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24zM12 15.4V6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z"/>
            </svg>
            Reseñas
        </a>
        <a href="/categorias/admin" class="admin-sidebar__nav-link <?php echo isActive('categorias.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/>
            </svg>
            Categorías
        </a>
    </nav>

    <div class="admin-sidebar__separator"></div>

    <div class="admin-sidebar__extras">
        <a href="/extras/admin" class="admin-sidebar__nav-link <?php echo isActive('extras.php'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Extras
        </a>
    </div>
</aside>