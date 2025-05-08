<?php include __DIR__ . "/../templates/admin-header.php"; ?>

<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/influencers/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>

    <div class="seccion-admin" class="profile-form-wide">
        <h1>Crear Influencer</h1>



        <form method="POST" class="profile-card-wide" action="/influencers/crear" enctype="multipart/form-data" >
            <?php include __DIR__ . "/formulario.php"; ?>
        </form>
    </div>


</main>

<?php $script= "<script src='/build/js/influencer.js'></script>"; ?>
<?php include __DIR__ . "/../templates/admin-footer.php"; ?>