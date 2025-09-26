const cargarPlaylists = async () => {
  const tbody = document.querySelector('#playlists-container tbody');
  if (!tbody) return console.error('No se encontró la tabla de playlists');

  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando playlists...</p>
      </td>
    </tr>
  `;

  try { 
    const response = await fetch('/api/playlists');
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar playlists',
      };
    }

    const playlists = await response.json();

    tbody.innerHTML = '';

    if (playlists.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-record-vinyl text-4xl mb-4"></i>
            <p>No hay playlists disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    playlists.forEach((playlist, index) => {
      const tr = document.createElement('tr');
      const cover = playlist.cover_image_path
        ? `<img src="/storage/${playlist.cover_image_path}" class="w-12 h-12 object-cover rounded" />`
        : '<span class="text-gray-500">Sin portada</span>';

      const songsList = playlist.songs && playlist.songs.length > 0
        ? `<ul class="list-disc list-inside text-gray-300">
            ${playlist.songs.map(song => `<li>${song.title} - ${song.artist}</li>`).join("")}
           </ul>`
        : '<span class="text-gray-500">Sin canciones</span>';

      tr.className = 'hover:bg-[#1a1a1a] transition-colors';
      tr.innerHTML += `
       <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${playlist.title}</td>
        <td class="px-4 py-2 text-gray-300">${playlist.description || 'Sin descripción'}</td>
        <td class="px-4 py-2">${cover}</td>
        <td class="px-4 py-2">${songsList}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button data-id="${playlist.id}" class="btn-edit-playlist px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button data-id="${playlist.id}" class="btn-delete-playlist px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });

    document.querySelectorAll('.btn-edit-playlist').forEach(button => {
          button.addEventListener('click', async () => {
            const editSection = document.getElementById('playlist-edit-section');
            const btnAddAlbum = document.getElementById('btn-create-playlist');
            const playlistsTableContainer = document.getElementById('playlists-container');
    
            if (editSection) editSection.classList.remove('hidden');
            if (btnAddAlbum) btnAddAlbum.classList.add('hidden');
            if (playlistsTableContainer) playlistsTableContainer.classList.add('hidden');
    
            const id = button.getAttribute('data-id');
            const response = await fetch(`/api/playlists/${id}`);
    
            if (!response.ok) {
              const error = await response.json().catch(()=>{});
              throw {
                message: error.message || 'Error al carga noticia',
              };
            }
            
            const playlistResponse = await response.json();
            const titleInput = document.getElementById('edit-playlist-title');
            const descriptionInput = document.getElementById('edit-playlist-description');
            const imagePreview = document.getElementById('edit-playlist-image-preview');
            const placeholder = document.getElementById('edit-playlist-placeholder');

            if (playlistResponse.cover_image_path !== null) {
              imagePreview.src = baseUrlImagenes + playlistResponse.cover_image_path;
              imagePreview.classList.remove('hidden');
              placeholder.classList.add('hidden');
            } else {
              imagePreview.removeAttribute('src'); 
              imagePreview.classList.add('hidden');
              placeholder.classList.remove('hidden');
            }
            if (titleInput) titleInput.value = playlistResponse.title;
            if (descriptionInput) descriptionInput.value = playlistResponse.description;
    
            const table = document.getElementById("playlist-songs-table");
            table.innerHTML = "";
            const songs = playlistResponse.songs || [];
            songs.forEach((song, index) => {
              const tr = document.createElement("tr");
              tr.innerHTML = `
                <td class="px-4 py-2">${index + 1}</td>
                <td class="px-4 py-2">${song.title}</td>
                <td class="px-4 py-2">${song.artist}</td>
                <td class="px-4 py-2 text-center">
                  <button class="btn-remove-song px-2 py-1 bg-red-600 text-white rounded" data-id="${song.id}">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              `;
              table.appendChild(tr);
            });

            const allSongs = await fetch('/api/songs');
            if (!allSongs.ok) {
              const error = await allSongs.json().catch(()=>{});
              throw {
                message: error.message || 'Error al carga noticia',
              };
            }
            const allSongsResponse = await allSongs.json();
            const songSelect = document.getElementById('edit-add-song-select');
            songSelect.innerHTML = `<option value="">Seleccionar canción...</option>`;

            allSongsResponse.forEach(song => {
              const option = document.createElement('option');
              option.value = song.id;
              option.textContent = song.title;
              songSelect.appendChild(option);
            })
          })
        });
    
        // Accion del boton eliminar
        document.querySelectorAll('.btn-delete-playlist').forEach(button => {
          button.addEventListener('click', async () => {
            const id = button.getAttribute('data-id');
            const response = await fetch(`/api/playlists/${id}`, {
              method: 'DELETE'
            });
            if (!response.ok) {
              const error = await response.json().catch(()=>{});
              throw {
                message: error.message || 'Error al eliminar playlist',
              };
            }
            await cargarPlaylists();
          })
        })

  }
  catch (error) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los albumes</p>
          <button onclick="cargarPlaylists()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }

}