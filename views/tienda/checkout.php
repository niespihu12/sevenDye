<?php include_once __DIR__ . "/../templates/header-principal.php"; ?>
<main class="">
    <h1 class="centrar-texto titulo-checkout">Billing Details</h1>
    <form class="formCheckout">
        <div class="formLeft">
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="nombre">First Name</label>
                <input class="checkoutCampo__field" type="" id="nombre" required>
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="company">Company Name</label>
                <input class="checkoutCampo__field" type="text" id="company">
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="adress">Street Address</label>
                <input class="checkoutCampo__field" type="text" id="adress" required>
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="apartment">Apartment, floor, etc. (optional)</label>
                <input class="checkoutCampo__field" type="text" id="apartment">
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="town">Town/City</label>
                <input class="checkoutCampo__field" type="text" id="town" required>
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="phone">Phone Number</label>
                <input class="checkoutCampo__field" type="tel" id="phone" required>
            </div>
            <div class="checkoutCampo">
                <label class="checkoutCampo__label" for="email">Email Address</label>
                <input class="checkoutCampo__field" type="email" id="email" required>
            </div>
            <div class="checkoutCampoFinal">
                <input class="checkoutCampoFinal__checkbox" type="checkbox" id="saveInfo" />
                <label class="checkoutCampoFinal__label" for="saveInfo">Save this information for faster check-out
                    next time</label>
            </div>
        </div>

        <div class="formRight">
            <div class="checkoutProductos">
                <div class="checkoutProduct">
                    <div class="checkoutProduct__image">
                        <picture>
                            <source srcset="build/img/checkout-imagen1.avif" type="image/avif">
                            <source srcset="build/img/checkout-imagen1.avif" type="image/webp">
                            <img loading="lazy" width="100" height="100" src="build/img/checkout-imagen1.png"
                                alt="">
                        </picture>
                        <p>LCD Monitor</p>
                    </div>
                    <p class="checkoutProduct__precio">$650</p>

                </div>
                <div class="checkoutProduct">
                    <div class="checkoutProduct__image">
                        <picture>
                            <source srcset="build/img/checkout-imagen2.avif" type="image/avif">
                            <source srcset="build/img/checkout-imagen2.webp" type="image/webp">
                            <img loading="lazy" width="100" height="100" src="build/img/checkout-imagen2.png"
                                alt="">
                        </picture>
                        <p>H1 Gamepad</p>
                    </div>
                    <p class="checkoutProduct__precio">$1100</p>

                </div>
            </div>
            <div class="checkoutSubtotal">
                <p>Subtotal:</p>
                <p>$1750</p>

            </div>
            <div class="checkoutShipping">
                <p>Shipping:</p>
                <p>Free</p>
            </div>
            <div class="checkoutTotal">
                <p>Total</p>
                <p>$1750</p>
            </div>
            <div>
                <div class="checkoutRadio">
                    <div class="checkoutRadio__select">
                        <input type="radio" name="medio_pago" id="medio_pago" required>
                        <label for="medio_pago">Bank</label>
                    </div>
                    <picture>
                        <source srcset="build/img/metodos.avif" type="image/avif">
                        <source srcset="build/img/metodos.webp" type="image/webp">
                        <img loading="lazy" width="100" height="100" src="build/img/metodos.png"
                            alt="">
                    </picture>
                </div>
                <div class="checkoutRadio">
                    <div class="checkoutRadio__select">
                        <input type="radio" name="medio_pago" id="medio_pago" required>
                        <label for="medio_pago">Cash on delivery</label>

                    </div>

                </div>

            </div>
            <div class="checkoutCupon">
                <input class="checkoutCupon__field" type="text" placeholder="Coupon Code" id="coupon">
                <button class="checkoutCupon__boton">Apply Coupon</button>

            </div>
            <div class="checkoutEnviar">
                <input class="checkoutEnviar__boton" type="submit" value="Place Order">
            </div>
        </div>

    </form>

</main>
<?php include_once __DIR__ . "/../templates/footer-principal.php"; ?>