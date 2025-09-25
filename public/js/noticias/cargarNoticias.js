const baseUrlImagenes = '/storage/'
export const cargarNoticias = async () => {
  const tbody = document.querySelector('#news-table-container tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de noticias');
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
    const response = await fetch('/api/news');
    if (!response.ok) {
      const error = await response.json().catch(()=>{});
      throw {
        message: error.message || 'Error al cargar noticias',
      };
    }
    const news = await response.json();
    
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
      
      tr.innerHTML = `
        <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${e.title}</td>
        <td class="px-4 py-2 text-gray-300">${e.description}</td>
        <td class="px-4 py-2">${categoryBadge}</td>
        <td class="px-4 py-2">
          ${e.image ? `<img src="${baseUrlImagenes}${e.image}" alt="${e.title}" class="w-10 h-10 rounded object-cover">` : 
            `<div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
               <i class="fa-solid fa-image text-gray-400 text-xs"></i>
             </div>`}
        </td>
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
    
    document.querySelectorAll('.btn-edit-news').forEach(button => {
      button.addEventListener('click', async () => {
        const editSection = document.getElementById('news-edit-section');
        const btnAddNew = document.getElementById('btn-create-news');
        const newsContainer = document.getElementById('news-container');

        if (editSection) editSection.classList.remove('hidden');
        if (btnAddNew) btnAddNew.classList.add('hidden');
        if (newsContainer) newsContainer.classList.add('hidden');

        const id = button.getAttribute('data-id');
        const response = await fetch(`/api/news/${id}`);

        if (!response.ok) {
          const error = await response.json().catch(()=>{});
          throw {
            message: error.message || 'Error al carga noticia',
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
        if (urlInput) urlInput.value = newResponse.source_url;
        if (descInput) descInput.value = newResponse.description;
        if (categoryInput) categoryInput.value = newResponse.category;
        if (imagePreview) imagePreview.src = baseUrlImagenes + newResponse.image;
        if (editForm) editForm.dataset.id = newResponse.id;

        
        
      })
    });

    // Accion del boton eliminar
    document.querySelectorAll('.btn-delete-news').forEach(button => {
      button.addEventListener('click', async () => {
        const id = button.getAttribute('data-id');
        const response = await fetch(`/api/news/${id}`, {
          method: 'DELETE'
        });
        if (!response.ok) {
          const error = await response.json().catch(()=>{});
          throw {
            message: error.message || 'Error al eliminar noticia',
          };
        }
        await cargarNoticias();
      })
    })
  } catch (error) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar las noticias</p>
          <button onclick="cargarNoticias()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }
}



// document.getElementById('menu-noticias').onclick = () => { 
//   panels.productos.classList.add('hidden');
//   panels.usuarios.classList.add('hidden');
//   panels.galeria.classList.add('hidden');
//   panels.noticias.classList.remove('hidden');

//   cargarNoticias();
// }


