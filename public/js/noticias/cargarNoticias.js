const baseUrlImagenes = '/storage/'
export const cargarNoticias = async () => {
  const tbody = document.querySelector('#news-table-container tbody');
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
    news.forEach(e => {
      const tr = document.createElement('tr');
      
      // Mostrar categoría con badge de color
      const categoryBadge = e.category === 'noticia' 
        ? '<span class="px-2 py-1 text-xs bg-blue-600 text-white rounded">Noticia</span>'
        : '<span class="px-2 py-1 text-xs bg-purple-600 text-white rounded">Evento</span>';
      
      tr.innerHTML = `
        <td class="px-4 py-2">${e.id}</td>
        <td class="px-4 py-2">${e.title}</td>
        <td class="px-4 py-2">${e.description}</td>
        <td class="px-4 py-2">${categoryBadge}</td>
        <td class="px-4 py-2">${e.image}</td>
        <td class="px-4 py-2">${e.source_url}</td>
        <td class="px-4 py-2">
            <button data-id="${e.id}" class="btn-edit-news bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs mr-2 transition">
                Editar
            </button>
            <button data-id="${e.id}" class="btn-delete-news bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition">
                Eliminar
            </button>
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
    tbody.innerHTML = `<tr><td colspan="6">${error.message || 'Error al cargar noticias'}</td></tr>`
  }

}



// document.getElementById('menu-noticias').onclick = () => { 
//   panels.productos.classList.add('hidden');
//   panels.usuarios.classList.add('hidden');
//   panels.galeria.classList.add('hidden');
//   panels.noticias.classList.remove('hidden');

//   cargarNoticias();
// }


