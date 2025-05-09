<?php include __DIR__ . "/../templates/admin-header.php"; ?>
<main class="formularios-admin">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <div class="dashboard__breadcrumb">

        <p>
            <a href="/testimonials/admin">Admin</a>
            <span>></span>
            <?php echo $pageTitle; ?>
        </p>
    </div>
    <div  class="testimonial-form-wide">
        <form method="POST" class="testimonial-card-wide" action="/testimonials/create" enctype="multipart/form-data" id="testimonialForm">
            <?php include __DIR__ . "/formulario.php"; ?>
        </form>
    </div>

</main>
<?php 
    $script = "
        <script src='/build/js/testimonios.js'></script>
    ";

?>
<?php include __DIR__ . "/../templates/admin-footer.php"; ?>