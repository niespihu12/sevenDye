document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.querySelector('#drop-zone input[type="file"]');
    const previsualizacionContainer = document.getElementById('previsualizacion-container');
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            mostrarPrevisualizaciones(fileInput.files);
        }
    });
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            mostrarPrevisualizaciones(fileInput.files);
        }
    });
    function mostrarPrevisualizaciones(files) {
        previsualizacionContainer.innerHTML = '';

        if (files.length > 0) {
            const titulo = document.createElement('h4');
            titulo.className = 'previsualizacion-titulo';
            titulo.textContent = `Imágenes seleccionadas: ${files.length}`;
            previsualizacionContainer.appendChild(titulo);

            const contenedor = document.createElement('div');
            contenedor.className = 'previsualizacion-grid';
            previsualizacionContainer.appendChild(contenedor);

            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const prevItem = document.createElement('div');
                        prevItem.className = 'previsualizacion-item';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = `Previsualización ${index + 1}`;

                        const nombre = document.createElement('div');
                        nombre.className = 'previsualizacion-nombre';
                        nombre.textContent = file.name.length > 20 ?
                            file.name.substring(0, 17) + '...' :
                            file.name;

                        const tamano = document.createElement('div');
                        tamano.className = 'previsualizacion-tamano';
                        tamano.textContent = formatFileSize(file.size);

                        prevItem.appendChild(img);
                        prevItem.appendChild(nombre);
                        prevItem.appendChild(tamano);

                        contenedor.appendChild(prevItem);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    const categoriaSelect = document.getElementById('categoria');
    const subcategoriaSelect = document.getElementById('subcategoria');

    if (categoriaSelect && subcategoriaSelect) {
        categoriaSelect.addEventListener('change', function() {
            const categoriaId = this.value;

            subcategoriaSelect.innerHTML = '<option value="">--Seleccione una subcategoría--</option>';

            if (categoriaId === '') {
                subcategoriaSelect.innerHTML = '<option value="">--Seleccione primero una categoría--</option>';
                return;
            }

            subcategoriaSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';

            fetch(`/productos/obtener-subcategorias?categoria_id=${categoriaId}`)
                .then(response => response.json())
                .then(subcategorias => {
                    subcategoriaSelect.innerHTML = '';

                    if (subcategorias.length > 0) {
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--Seleccione una subcategoría--';
                        subcategoriaSelect.appendChild(defaultOption);

                        subcategorias.forEach(subcategoria => {
                            const option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.textContent = subcategoria.nombre;
                            subcategoriaSelect.appendChild(option);
                        });
                    } else {
                        const noOption = document.createElement('option');
                        noOption.value = '';
                        noOption.textContent = 'Esta categoría no tiene subcategorías';
                        subcategoriaSelect.appendChild(noOption);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar subcategorías:', error);
                    subcategoriaSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
                });
        });

        if (categoriaSelect.value !== '') {
            categoriaSelect.dispatchEvent(new Event('change'));
        }
    }
});