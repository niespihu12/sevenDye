<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<main class="login">
    <div class="login__fondo">
        <div class="login__contenido">
            <div class="login__contenido--interno">
                <a href="/" class="login__logo">
                    <picture>
                        <source srcset="build/img/seven_Logo_blanco.avif" type="image/avif">
                        <source srcset="build/img/seven_Logo_blanco.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="build/img/seven_Logo_blanco.png" alt="">
                    </picture>
                </a>
                <h3>Login</h3>
                <form class="formulario" method="POST" action="/login">
                    <div class="campo">
                        <label class="campo__label" for="email">E-mail</label>
                        <input class="campo__field" type="email" placeholder="username@gmail.com" id="email" name="email">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="password">Password</label>
                        <div class="form-control">
                            <input class="campo__field" type="password" placeholder="Password" id="password" name="contraseña" data-pwd-input>
                            <span class="toggle-password"> <i class="bi bi-eye-fill" data-pwd-toggle></i></span>
                        </div>
                    </div>
                    <div class="campo">
                        <a href="/forgot" class="campo__clave">Forgot Password?</a>
                        <input type="submit" value="SIGN IN" class="boton-enviar">
                    </div>
                </form>
                <div class="login__footer">
                    <p class="">or contine with</p>
                    <div class="login__redes">
                        <a href="/google/login">
                            <picture>
                                <source srcset="build/img/logo_google.avif" type="image/avif">
                                <source srcset="build/img/logo_google.webp" type="image/webp">
                                <img loading="lazy" width="100" height="100" src="build/img/logo_google.png" alt="">
                            </picture>
                            <span>Sign in with Google</span>
                        </a>
                    </div>
                    <p>Don't have an account yet?<a class="negrilla" href="/register" class=""> Register for
                            free</a></p>
                </div>
            </div>
        </div>
    </div>
</main>