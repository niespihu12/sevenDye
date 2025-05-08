document.addEventListener('DOMContentLoaded', function () {
    header()
})
function header() {
    const nav = document.querySelector('#nav-mob');
    const abrir = document.querySelector('#abrir');
    const cerrar = document.querySelector('#cerrar');

    abrir.addEventListener('click', () => {
        nav.classList.add('mostrar');
    });

    cerrar.addEventListener('click', () => {
        nav.classList.remove('mostrar');
    });
}
