<main>
    <h2 style="margin: 0; padding: 100px 0 0 0;">Testimonios</h2>
    <a href="/testimonios/crear" >Nuevo(a) Testimonio</a>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Image</th>
                <th>Rol</th>
                <th>Message</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($testimonios as $testimonio) { ?>
                <tr>
                    <td><?php echo $testimonio->id; ?></td>
                    <td><?php echo $testimonio->nombre; ?></td>
                    <td> <img src="/imagenes/<?php echo $testimonio->imagen; ?>" class="imagen-tabla"> </td>
                    <td><?php echo $testimonio->rol ?></td>
                    <td><?php echo $testimonio->mensaje ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/testimonios/eliminar">

                            <!-- input hidden -->
                            <input type="hidden" name="id" value="<?php echo $testimonio->id; ?>">
                            <input type="hidden" name="tipo" value="testimonio">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">

                        </form>
                        <a href="/testimonios/actualizar?id=<?php echo $testimonio->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</main>