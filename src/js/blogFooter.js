document.addEventListener('DOMContentLoaded', function() {
    initializeSearch('blog-search-input', 'blog-search-results');

    function initializeSearch(inputId, resultsId) {
      const searchInput = document.getElementById(inputId);
      const searchResults = document.getElementById(resultsId);

      if (searchInput && searchResults) {
        searchInput.addEventListener('input', debounce(function(e) {
          const searchTerm = e.target.value.trim();

          if (searchTerm.length >= 2) {
            fetchSearchResults(searchTerm, searchResults);
          } else {
            searchResults.innerHTML = '';
            searchResults.classList.remove('show');
          }
        }, 300));

        document.addEventListener('click', function(event) {
          if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.remove('show');
          }
        });

        searchInput.addEventListener('focus', function() {
          if (this.value.trim().length >= 2) {
            fetchSearchResults(this.value.trim(), searchResults);
          }
        });
      }
    }

    function fetchSearchResults(query, resultsContainer) {
      resultsContainer.innerHTML = '<div class="loading">Buscando...</div>';
      resultsContainer.classList.add('show');

      fetch(`/blog/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            renderSearchResults(data, resultsContainer);
          } else {
            resultsContainer.innerHTML = '<div class="no-results">No se encontraron artículos</div>';
          }
        })
        .catch(error => {
          console.error('Error en la búsqueda:', error);
          resultsContainer.innerHTML = '<div class="error">Error al buscar artículos</div>';
        });
    }

    function renderSearchResults(results, resultsContainer) {
      resultsContainer.innerHTML = '';
      const resultsFragment = document.createDocumentFragment();

      results.forEach(blog => {
        const item = document.createElement('a');
        item.href = `/blog/${blog.slug}`; 
        item.className = 'search-item';

        const imageHtml = blog.imagen ?
          `<div class="search-item-image">
                    <img src="/imagenes/${blog.imagen}" alt="${blog.titulo}">
                </div>` : '';

        item.innerHTML = `
                ${imageHtml}
                <div class="search-item-info">
                    <div class="search-item-title">${blog.titulo}</div>
                    <div class="search-item-date">${blog.creado}</div>
                </div>
            `;

        resultsFragment.appendChild(item);
      });

      resultsContainer.appendChild(resultsFragment);
    }

    function debounce(func, wait) {
      let timeout;
      return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
      };
    }
  });