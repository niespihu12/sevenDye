<?php include __DIR__ . "/../templates/admin-header.php"; ?>

<main class="dashboard__content">
    <div class="influencers">
        <div class="dashboard__breadcrumb">
            <p>
                <a href="/admin">Admin</a>
                <span>></span>
                <?php echo $pageTitle; ?>
            </p>
        </div>
        <div class="influencers__header">
            <h2>Productos</h2>
            <a href="/productos/crear" class="influencers__nuevo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Nuevo Producto
            </a>
        </div>

        <!-- Formulario de Búsqueda -->
        <div class="dashboard__search">
            <form method="GET" action="/productos/admin" class="search-form">
                <div class="search-input-container">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar productos..."
                        value="<?php echo $search ?? ''; ?>"
                        class="search-input">
                    <button type="submit" class="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                    </button>
                </div>
                <?php if (!empty($search)): ?>
                    <a href="/productos/admin" class="clear-search">Limpiar búsqueda</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (count($productos) === 0): ?>
            <div class="no-results">
                <p>No se encontraron productos<?php echo !empty($search) ? ' con el término de búsqueda: "' . $search . '"' : ''; ?></p>
                <?php if (!empty($search)): ?>
                    <a href="/productos/admin" class="btn-reset">Ver todos los productos</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <table class="influencers__tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Recuento ventas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto->id; ?></td>
                            <td>
                                <img src="/imagenes/<?php echo $imagenes[$producto->id] ?>" class="imagen-tabla" alt="<?php echo $producto->nombre; ?>">
                            </td>
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->precio; ?></td>
                            <td><?php echo $producto->recuento_ventas; ?></td>
                            <td>
                                <div class="influencers__acciones">
                                    <form method="POST" action="/productos/eliminar">
                                        <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                                        <button type="submit" class="boton-eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                    <a href="/productos/actualizar?id=<?php echo $producto->id; ?>" class="boton-actualizar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                        Actualizar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="pagination">
                <?php if ($totalPages > 1): ?>
                    <ul class="pagination__list">
                        <?php if ($currentPage > 1): ?>
                            <li>
                                <a href="?page=<?php echo $currentPage - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="pagination__link pagination__link--prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                                    </svg>
                                    Anterior
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php
                        // Calcular rango de páginas a mostrar
                        $range = 2;
                        $showFrom = max(1, $currentPage - $range);
                        $showTo = min($totalPages, $currentPage + $range);

                        // Siempre mostrar la primera página
                        if ($showFrom > 1) {
                            echo '<li><a href="?page=1' . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="pagination__link">1</a></li>';
                            if ($showFrom > 2) {
                                echo '<li><span class="pagination__ellipsis">...</span></li>';
                            }
                        }

                        // Mostrar enlaces de página
                        for ($i = $showFrom; $i <= $showTo; $i++) {
                            echo '<li>';
                            if ($i === $currentPage) {
                                echo '<span class="pagination__link pagination__link--current">' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="pagination__link">' . $i . '</a>';
                            }
                            echo '</li>';
                        }

                        // Siempre mostrar la última página
                        if ($showTo < $totalPages) {
                            if ($showTo < $totalPages - 1) {
                                echo '<li><span class="pagination__ellipsis">...</span></li>';
                            }
                            echo '<li><a href="?page=' . $totalPages . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="pagination__link">' . $totalPages . '</a></li>';
                        }
                        ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li>
                                <a href="?page=<?php echo $currentPage + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="pagination__link pagination__link--next">
                                    Siguiente
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>

                <div class="pagination__info">
                    Mostrando <?php echo $firstItemIndex; ?>-<?php echo $lastItemIndex; ?> de <?php echo $totalItems; ?> productos
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . "/../templates/admin-footer.php"; ?>