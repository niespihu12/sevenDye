<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<main class="login">
    <div class="login__fondo">
        <div class="login__contenido">
            <div class="login__contenido--general">
                <h1 class="nombre-pagina">Recuperar Password</h1>
                <p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>
                <?php if($error) return; ?>
                <form class="formulario" method="POST">
                    <div class="campo">
                        <label for="password" class="campo__label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="contraseña"
                            placeholder="Tu Nuevo Password" 
                            class="campo__field"    
                        />
                    </div>
                    <input type="submit" class="boton-general" value="Guardar Nuevo Password">

                </form>

                <div class="acciones">
                    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
                    <a href="/register">¿Aún no tienes cuenta? Obtener una</a>
                </div>
            </div>
        </div>
    </div>
</main>