<?php include __DIR__ . "/influencer-header.php";?>
<main>
    <h2 style="margin: 0; padding: 100px 0 0 0;">Influencers</h2>
    <a href="/influencers/crear" >Nuevo(a) Influencer</a>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Youtube</th>
                <th>Tiktok</th>
                <th>Instagram</th>
                <th>image</th>
                <th>Description</th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($influencers as $influencer) { ?>
                <tr>
                    <td><?php echo $influencer->id; ?></td>
                    <td><?php echo $influencer->nombre; ?></td>
                    <td><?php echo $influencer->youtube ?></td>
                    <td><?php echo $influencer->tiktok ?></td>
                    <td><?php echo $influencer->instagram ?></td>
                    <td> <img src="/imagenes/<?php echo $influencer->imagen; ?>" class="imagen-tabla"> </td>
                    <td><?php echo $influencer->descripcion ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/influencers/eliminar">

                            <!-- input hidden -->
                            <input type="hidden" name="id" value="<?php echo $influencer->id; ?>">
                            <input type="hidden" name="tipo" value="influencer">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">

                        </form>
                        <a href="/influencers/actualizar?id=<?php echo $influencer->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</main>
<?php include __DIR__ . "/influencer-footer.php";?>