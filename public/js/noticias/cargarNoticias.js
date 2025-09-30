export const cargarNoticias = async () => {
  const tbody = document.querySelector('#news-table-container tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de noticias');
    return;
  }

  const token = localStorage.getItem('auth_token'); // AGREGADO

  if (!token) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>No estás autenticado</p>
          <a href="/login" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Iniciar sesión
          </a>
        </td>
      </tr>
    `;
    return;
  }

  // Mostrar estado de carga
  tbody.innerHTML = `
    <tr>
      <td colspan="7" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando noticias...</p>
      </td>
    </tr>
  `;

  try {
    const response = await fetch('/api/news', {
      headers: {
        'Authorization': `Bearer ${token}`, // AGREGADO
        'Accept': 'application/json'
      }
    });
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar noticias',
      };
    }
    
    const news = await response.json();
    console.log('Noticias cargadas:', news);
    
    tbody.innerHTML = '';
    
    if (news.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="7" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-newspaper text-4xl mb-4"></i>
            <p>No hay noticias disponibles</p>
          </td>
        </tr>
      `;
      return;
    }
    
    news.forEach((e, index) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';
      
      // Mostrar categoría con badge de color
      const categoryBadge = e.category === 'noticia' 
        ? '<span class="px-2 py-1 text-xs bg-blue-600 text-white rounded">Noticia</span>'
        : '<span class="px-2 py-1 text-xs bg-purple-600 text-white rounded">Evento</span>';
      
      // MEJORADO: Manejo de imágenes con mejor error handling
      let imagenHtml;
      if (e.image_url) {
        const imagenUrl = e.image_url;
        console.log('✅ Imagen noticia encontrada:', imagenUrl);
        imagenHtml = `
          <img src="${imagenUrl}" 
               alt="${e.title}" 
               class="w-10 h-10 rounded object-cover cursor-pointer"
               onclick="mostrarImagenCompleta('${imagenUrl}', '${e.title.replace(/'/g, '&apos;')}')"
               onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'w-10 h-10 rounded bg-gray-600 flex items-center justify-center\\'><i class=\\'fa-solid fa-image text-gray-400 text-xs\\'></i></div>'"
               onload="console.log('✅ Imagen noticia cargada:', '${imagenUrl}')">
        `;
      } else {
        imagenHtml = `
          <div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
            <i class="fa-solid fa-image text-gray-400 text-xs"></i>
          </div>
        `;
      }
      
      tr.innerHTML = `
        <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${e.title}</td>
        <td class="px-4 py-2 text-gray-300">${e.description}</td>
        <td class="px-4 py-2">${categoryBadge}</td>
        <td class="px-4 py-2">${imagenHtml}</td>
        <td class="px-4 py-2 text-blue-400 text-xs truncate max-w-xs">${e.source_url || 'Sin fuente'}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button data-id="${e.id}" class="btn-edit-news px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button data-id="${e.id}" class="btn-delete-news px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });
    
    // Botones editar con token
    document.querySelectorAll('.btn-edit-news').forEach(button => {
      button.addEventListener('click', async () => {
        const editSection = document.getElementById('news-edit-section');
        const btnAddNew = document.getElementById('btn-create-news');
        const newsContainer = document.getElementById('news-container');

        if (editSection) editSection.classList.remove('hidden');
        if (btnAddNew) btnAddNew.classList.add('hidden');
        if (newsContainer) newsContainer.classList.add('hidden');

        const id = button.getAttribute('data-id');
        
        try {
          const response = await fetch(`/api/news/${id}`, {
            headers: {
              'Authorization': `Bearer ${token}`, // AGREGADO
              'Accept': 'application/json'
            }
          });

          if (!response.ok) {
            const error = await response.json().catch(() => {});
            throw {
              message: error.message || 'Error al cargar noticia',
            };
          }
          
          const newResponse = await response.json();
          const titleInput = document.getElementById('edit-new-title');
          const urlInput = document.getElementById('edit-new-url');
          const descInput = document.getElementById('edit-new-description');
          const categoryInput = document.getElementById('edit-new-category');
          const imagePreview = document.getElementById('notice-image-preview');
          const editForm = document.getElementById('edit-news-form');

          if (titleInput) titleInput.value = newResponse.title;
          if (urlInput) urlInput.value = newResponse.source_url || '';
          if (descInput) descInput.value = newResponse.description;
          if (categoryInput) categoryInput.value = newResponse.category;
          if (editForm) editForm.dataset.id = newResponse.id;
          
          // MEJORADO: Preview de imagen con manejo de errores
          if (imagePreview && newResponse.image_url) {
            const imagenUrl =newResponse.image_url;
            imagePreview.src = imagenUrl;
            imagePreview.classList.remove('hidden');
            imagePreview.onerror = function() {
              this.style.display = 'none';
              console.warn('Error cargando imagen preview:', imagenUrl);
            };
          }
          
        } catch (error) {
          console.error('Error cargando noticia:', error);
          alert('Error al cargar los datos de la noticia');
        }
      });
    });

    // Botones eliminar con token
    document.querySelectorAll('.btn-delete-news').forEach(button => {
      button.addEventListener('click', async () => {
        if (!confirm('¿Estás seguro de que deseas eliminar esta noticia?')) return;
        
        const id = button.getAttribute('data-id');
        
        try {
          const response = await fetch(`/api/news/${id}`, {
            method: 'DELETE',
            headers: {
              'Authorization': `Bearer ${token}`, // AGREGADO
              'Accept': 'application/json'
            }
          });
          
          if (!response.ok) {
            const error = await response.json().catch(() => {});
            throw {
              message: error.message || 'Error al eliminar noticia',
            };
          }
          
          alert('Noticia eliminada correctamente');
          await cargarNoticias();
          
        } catch (error) {
          console.error('Error eliminando noticia:', error);
          alert('Error al eliminar la noticia');
        }
      });
    });
    
  } catch (error) {
    console.error('Error:', error);
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar las noticias</p>
          <button onclick="window.cargarNoticias()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

// AGREGADO: Función para mostrar imagen completa
window.mostrarImagenCompleta = function(url, titulo) {
  const modal = document.createElement('div');
  modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
  modal.innerHTML = `
    <div class="max-w-4xl max-h-4xl p-4">
      <div class="relative">
        <img src="${url}" alt="${titulo}" class="max-w-full max-h-full rounded">
        <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-700">
          <i class="fa-solid fa-times"></i>
        </button>
        <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white px-3 py-1 rounded">
          ${titulo}
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
};

// Hacer función global para el botón reintentar
window.cargarNoticias = cargarNoticias;


