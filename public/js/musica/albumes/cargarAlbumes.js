const baseUrlImagenes = '/storage/';

const cargarAlbumes = async () => {
  const tbody = document.querySelector('#albums-table-container tbody');
  if (!tbody) return console.error('No se encontró la tabla de albumes');

  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando albumes...</p>
      </td>
    </tr>
  `;

  try { 
    const token = localStorage.getItem('auth_token');
    const response = await fetch('/api/albums', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar albumes',
      };
    }

    const albums = await response.json();

    tbody.innerHTML = '';

    if (albums.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-record-vinyl text-4xl mb-4"></i>
            <p>No hay albumes disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    albums.forEach((album, index) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';
      tr.innerHTML += `
       <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${album.title}</td>
        <td class="px-4 py-2 text-gray-300">${album.year}</td>
        <td class="px-4 py-2">
          ${album.cover_image_path ? `<img src="${baseUrlImagenes}${album.cover_image_path}" alt="${album.title}" class="w-10 h-10 rounded object-cover">` : 
            `<div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
               <i class="fa-solid fa-image text-gray-400 text-xs"></i>
             </div>`}
        </td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button data-id="${album.id}" class="btn-edit-album px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button data-id="${album.id}" class="btn-delete-album px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });

    document.querySelectorAll('.btn-edit-album').forEach(button => {
          button.addEventListener('click', async () => {
            const editSection = document.getElementById('album-edit-section');
            const btnAddAlbum = document.getElementById('btn-create-album');
            const albumsTableContainer = document.getElementById('albums-table-container');
    
            if (editSection) editSection.classList.remove('hidden');
            if (btnAddAlbum) btnAddAlbum.classList.add('hidden');
            if (albumsTableContainer) albumsTableContainer.classList.add('hidden');
    
            const id = button.getAttribute('data-id');
            const response = await fetch(`/api/albums/${id}`, { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } } );
    
            if (!response.ok) {
              const error = await response.json().catch(()=>{});
              throw {
                message: error.message || 'Error al carga noticia',
              };
            }
            
            const albumResponse = await response.json();
            const titleInput = document.getElementById('edit-album-title');
            const yearInput = document.getElementById('edit-album-year');
            const imagePreview = document.getElementById('edit-album-image-preview');
            const editForm = document.getElementById('edit-album-form');

            if (albumResponse.cover_image_path) {
              imagePreview.src = baseUrlImagenes + albumResponse.cover_image_path;
              imagePreview.classList.remove('hidden');
            } else {
              imagePreview.removeAttribute('src'); 
              imagePreview.classList.add('hidden');
              const placeholder = document.getElementById('edit-album-placeholder');
              if (placeholder) placeholder.classList.remove('hidden');
            }

    
            if (titleInput) titleInput.value = albumResponse.title;
            if (yearInput) yearInput.value = albumResponse.year;
            if (editForm) editForm.dataset.id = albumResponse.id;
    
            
            
          })
        });
    
        // Accion del boton eliminar
        document.querySelectorAll('.btn-delete-album').forEach(button => {
          button.addEventListener('click', async () => {
            const id = button.getAttribute('data-id');
            const response = await fetch(`/api/albums/${id}`, {
              method: 'DELETE',
              headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            if (!response.ok) {
              const error = await response.json().catch(()=>{});
              throw {
                message: error.message || 'Error al eliminar album',
              };
            }
            await cargarAlbumes();
          })
        })

  }
  catch (error) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los albumes</p>
          <button onclick="cargarAlbumes()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }

}