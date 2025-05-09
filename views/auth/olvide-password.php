<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<main class="login">
    <div class="login__fondo">
        <div class="login__contenido">
            <div class="login__contenido--general">
                <h1 class="nombre-pagina">Olvide Password</h1>
                <p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

                <form class="formulario" action="/olvide" method="POST">
                    <div class="campo">
                        <label class="campo__label" for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Tu Email"
                            class="campo__field" 
                        />
                    </div>

                    <input class="boton-general" type="submit" value="Enviar Instrucciones">
                </form>

                <div class="acciones">
                    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
                    <a href="/register">¿Aún no tienes una cuenta? Crear Una</a>
                </div>
            </div>
        </div>
    </div>
</main>