document.addEventListener('DOMContentLoaded', function() {
    // Agregar los atributos data-label para la versión responsive
    if (window.innerWidth <= 768) {
        const tablaProductos = document.querySelector('.productos-tabla');
        const encabezados = tablaProductos.querySelectorAll('thead th');
        const celdas = tablaProductos.querySelectorAll('tbody td');
        
        for (let i = 0; i < celdas.length; i++) {
            const indiceEncabezado = i % encabezados.length;
            celdas[i].setAttribute('data-label', encabezados[indiceEncabezado].textContent);
        }
    }
});