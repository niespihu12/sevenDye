<?php include_once __DIR__ . "/../templates/admin-header.php"; ?>

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
            <h2>Subcategorias</h2>
            <a href="/subcategorias/crear" class="influencers__nuevo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Nueva subcategoria
            </a>
        </div>


        <table class="influencers__tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subcategorias as $subcategoria): ?>
                    <tr>
                        <td><?php echo $subcategoria->id; ?></td>
                        <td><?php echo $subcategoria->nombre; ?></td>
                        <td><?php echo $categorias[$subcategoria->id] ?? 'Sin categoría'; ?></td>
                        <td>
                            <div class="influencers__descripcion"><?php echo $subcategoria->descripcion; ?></div>
                        </td>
                        <td>
                            <div class="influencers__acciones">
                                <form method="POST" action="/subcategorias/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $subcategoria->id; ?>">
                                    <button type="submit" class="boton-eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                                <a href="/subcategorias/actualizar?id=<?php echo $subcategoria->id; ?>" class="boton-actualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                    Actualizar
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    </div>


</main>

<?php include_once __DIR__ . "/../templates/admin-footer.php"; ?>