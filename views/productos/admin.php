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
            <div>
                <a class="c-button c-button--gooey" href="/productos/crear">Admin
                    <div class="c-button__blobs">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </a>

                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
                    <defs>
                        <filter id="goo">
                            <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                            <feColorMatrix in="blur" mode="matrix"
                                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                            <feBlend in="SourceGraphic" in2="goo"></feBlend>
                        </filter>
                    </defs>
                </svg>
            </div>

        </div>



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
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables específicas para la página de administración
        const tableContainer = document.querySelector('.influencers__tabla');

        // Crear contenedor de paginación si no existe
        let paginationContainer = document.querySelector('.pagination');
        if (!paginationContainer) {
            paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination';
            // Insertar después de la tabla
            if (tableContainer) {
                tableContainer.parentNode.insertBefore(paginationContainer, tableContainer.nextSibling);
            } else {
                // Si no hay tabla, no continuamos
                console.warn('La tabla de productos no se encontró en el DOM');
                return;
            }
        }

        // Configuración de la paginación
        const rowsPerPage = 10; // Número de filas de productos por página
        let currentPage = 1;

        // Contador de resultados
        let resultsCount = document.querySelector('.results-count span');
        if (!resultsCount) {
            const resultsCountContainer = document.createElement('div');
            resultsCountContainer.className = 'results-count';
            resultsCountContainer.innerHTML = '<span></span>';
            resultsCount = resultsCountContainer.querySelector('span');

            // Insertar antes de la paginación
            paginationContainer.parentNode.insertBefore(resultsCountContainer, paginationContainer);
        }

        // Obtener todas las filas de productos (excepto la cabecera)
        const allRows = Array.from(tableContainer.querySelectorAll('tbody tr'));
        const totalRows = allRows.length;

        // Inicializar paginación
        initPagination();

        // Función para inicializar la paginación
        function initPagination() {
            // Calcular total de páginas
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            if (totalPages <= 1) {
                // Si solo hay una página, ocultar la paginación
                paginationContainer.style.display = 'none';
                return;
            }

            // Limpiar y crear nueva paginación
            paginationContainer.innerHTML = '';

            // Añadir botón anterior
            const prevButton = document.createElement('span');
            prevButton.className = 'pagination__arrow';
            prevButton.innerHTML = '&laquo;';
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });
            paginationContainer.appendChild(prevButton);

            // Determinar rango visible de páginas
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            // Ajustar startPage si estamos cerca del final
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // Añadir primera página si no está en el rango visible
            if (startPage > 1) {
                const firstPageBtn = document.createElement('span');
                firstPageBtn.className = 'pagination__number';
                firstPageBtn.textContent = '1';
                firstPageBtn.addEventListener('click', () => goToPage(1));
                paginationContainer.appendChild(firstPageBtn);

                // Añadir elipsis si hay un salto
                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'pagination__ellipsis';
                    ellipsis.textContent = '...';
                    paginationContainer.appendChild(ellipsis);
                }
            }

            // Añadir páginas del rango visible
            for (let i = startPage; i <= endPage; i++) {
                const pageNumber = document.createElement('span');
                pageNumber.className = 'pagination__number ' + (i === currentPage ? 'active' : '');
                pageNumber.textContent = i;
                pageNumber.addEventListener('click', () => goToPage(i));
                paginationContainer.appendChild(pageNumber);
            }

            // Añadir elipsis y última página si no está en el rango visible
            if (endPage < totalPages) {
                // Añadir elipsis si hay un salto
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'pagination__ellipsis';
                    ellipsis.textContent = '...';
                    paginationContainer.appendChild(ellipsis);
                }

                // Añadir última página
                const lastPageBtn = document.createElement('span');
                lastPageBtn.className = 'pagination__number';
                lastPageBtn.textContent = totalPages;
                lastPageBtn.addEventListener('click', () => goToPage(totalPages));
                paginationContainer.appendChild(lastPageBtn);
            }

            // Añadir botón siguiente
            const nextButton = document.createElement('span');
            nextButton.className = 'pagination__arrow';
            nextButton.innerHTML = '&raquo;';
            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    goToPage(currentPage + 1);
                }
            });
            paginationContainer.appendChild(nextButton);

            // Actualizar información de resultados
            if (resultsCount) {
                const startIndex = (currentPage - 1) * rowsPerPage;
                resultsCount.textContent = `Mostrando ${startIndex + 1} a ${Math.min(startIndex + rowsPerPage, totalRows)} de ${totalRows} productos`;
            }

            // Mostrar productos de la primera página
            goToPage(currentPage);
        }

        // Función para ir a una página específica
        function goToPage(pageNumber) {
            currentPage = pageNumber;

            // Calcular índices de inicio y fin para las filas a mostrar
            const startIndex = (pageNumber - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

            // Ocultar todas las filas
            allRows.forEach(row => {
                row.style.display = 'none';
            });

            // Mostrar solo las filas de la página actual
            for (let i = startIndex; i < endIndex; i++) {
                if (allRows[i]) {
                    allRows[i].style.display = 'table-row';
                }
            }

            // Actualizar estado activo en la paginación
            const pageNumbers = paginationContainer.querySelectorAll('.pagination__number');
            pageNumbers.forEach(pageNum => {
                const pageNumText = parseInt(pageNum.textContent);
                if (!isNaN(pageNumText)) {
                    pageNum.classList.toggle('active', pageNumText === pageNumber);
                }
            });

            // Actualizar el contador de resultados
            if (resultsCount) {
                resultsCount.textContent = `Mostrando ${Math.min(rowsPerPage, endIndex - startIndex)} de ${totalRows} productos`;
            }
        }

        // Verificar si hay un parámetro de página en la URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('pagina')) {
            const pageFromUrl = parseInt(urlParams.get('pagina'));
            if (!isNaN(pageFromUrl) && pageFromUrl > 0) {
                // Ir a la página especificada en la URL
                setTimeout(() => goToPage(pageFromUrl), 100);
            }
        }
    });

    // Añadir estilos CSS para la paginación
    (function() {
        const style = document.createElement('style');
        style.textContent = `
        .results-count {
            text-align: center;
            margin: 1rem 0;
            color: #666;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2rem 0;
            gap: 0.5rem;
        }
        
        .pagination__number, .pagination__arrow, .pagination__ellipsis {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            user-select: none;
        }
        
        .pagination__number:hover, .pagination__arrow:hover {
            background-color: var(--primary-light, #f3f4f6);
            color: var(--dark, #333);
        }
        
        .pagination__number.active {
            background-color: var(--primary, #4f46e5);
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .pagination__arrow {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .pagination__ellipsis {
            cursor: default;
            color: #777;
        }
        
        .pagination__ellipsis:hover {
            background-color: transparent;
        }
        
        @media (max-width: 768px) {
            .pagination {
                gap: 0.3rem;
            }
            
            .pagination__number, .pagination__arrow, .pagination__ellipsis {
                width: 2rem;
                height: 2rem;
                font-size: 0.9rem;
            }
        }
    `;
        document.head.appendChild(style);
    })();
</script>

<?php include __DIR__ . "/../templates/admin-footer.php"; ?>