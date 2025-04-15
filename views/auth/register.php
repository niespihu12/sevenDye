<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<main class="register">
    <div class="register__fondo">
        <div class="register__contenido">
            <div class="register__contenido--interno">
                <a href="/" class="register__logo">
                    <picture>
                        <source srcset="build/img/seven_Logo_blanco.avif" type="image/avif">
                        <source srcset="build/img/seven_Logo_blanco.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="build/img/seven_Logo_blanco.png" alt="">
                    </picture>
                </a>
                <h3>Register</h3>
                <form class="formulario" method="post" action="/register">
                    <div class="campo">
                        <label class="campo__label" for="email">E-mail</label>
                        <input class="campo__field" type="email" placeholder="username@gmail.com" id="email" name="email" value="<?php echo s($usuario->email)?>">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="password">Password (6 characters minimum)</label>
                        <div class="form-control">
                            <input class="campo__field" type="password" placeholder="Password" id="password" data-pwd-input="password" name="contraseña">
                            <span class="toggle-password"> <i class="bi bi-eye-fill" data-pwd-toggle="password"></i></span>
                        </div>
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="password">Password confirmation</label>
                        <div class="form-control">
                            <input class="campo__field" type="password" placeholder="Password" id="password-repeat" data-pwd-input="confirmation" name="contraseña_repetida">
                            <span class="toggle-password"> <i class="bi bi-eye-fill" data-pwd-toggle="confirmation"></i></span>
                        </div>
                    </div>
                    <div class="campo">
                        <input type="submit" value="REGISTER" class="boton-enviar">
                    </div>

                </form>
                <div class="login__footer">
                    <p class="">or contine with</p>
                    <div class="login__redes">
                        <button>
                            <picture>
                                <source srcset="build/img/logo_google.avif" type="image/avif">
                                <source srcset="build/img/logo_google.webp" type="image/webp">
                                <img loading="lazy" width="100" height="100" src="build/img/logo_google.png" alt="">
                            </picture>
                        </button>
                        <button>
                            <picture>
                                <source srcset="build/img/logo_facebook.avif" type="image/avif">
                                <source srcset="build/img/logo_facebook.webp" type="image/webp">
                                <img loading="lazy" width="100" height="100" src="build/img/logo_facebook.png" alt="">
                            </picture>

                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</main>