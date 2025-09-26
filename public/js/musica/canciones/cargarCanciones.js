const secondsToMMSS = (seconds) => {
  if (!seconds && seconds !== 0) return "0:00";
  const mins = Math.floor(seconds / 60);
  const secs = Math.floor(seconds % 60);
  return `${mins}:${secs.toString().padStart(2, "0")}`;
}


const cargarCanciones = async () => {
  const tbody = document.querySelector('#songs-table-container tbody');
  if (!tbody) return console.error('No se encontró la tabla de canciones');

  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando canciones...</p>
      </td>
    </tr>
  `;
  const token = localStorage.getItem('auth_token');
  if (!token) {
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-8 text-red-400">
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

  try { 
    const response = await fetch('/api/songs', {
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

    const songs = await response.json();

    tbody.innerHTML = '';

    if (songs.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-music text-4xl mb-4"></i>
            <p>No hay canciones disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    songs.forEach((song, index) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';
      const albumTitle = song.album ? song.album.title : 'desconocido';

      // convierte la duración de segundos a mm:ss 
      const minutes = Math.floor(song.duration / 60);
      const seconds = String(song.duration % 60).padStart(2, '0');
      const durationFormatted = `${minutes}:${seconds}`;

      tr.innerHTML += `
       <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${song.title}</td>
        <td class="px-4 py-2 text-gray-300">${song.artist}</td>
        <td class="px-4 py-2 text-gray-300">${song.genre}</td>
        <td class="px-4 py-2 text-gray-300">${durationFormatted}</td>
        <td class="px-4 py-2 text-gray-300">${albumTitle}</td>
        <td class="px-5 py-2 text-gray-300 text-center">
          <button data-src="/storage/${song.file_path}" class="btn-song-preview w-10 h-10 flex items-center justify-center bg-[#e7452e] text-white rounded-full hover:bg-orange-600 transition">
            <i class="fa-solid fa-play"></i>
          </button>
        </td>
        <td class="px-4 py-2 text-gray-300">
          <div class="flex gap-2">
            <button data-id="${song.id}" class="btn-edit-song px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button data-id="${song.id}" class="btn-delete-song px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });
    
    // Reproducir canciones
    const player = document.getElementById('song-preview-player');
    const btnPlay = document.querySelectorAll('.btn-song-preview');
    let currentBtn = null;

    btnPlay.forEach((btn) => {
      btn.addEventListener('click', () => { 
        const src = btn.getAttribute('data-src');
        const icon = btn.querySelector('i');

        if (player.src !== location.origin + src && player.src !== src) {
          player.src = src;
          player.play();

          if (currentBtn) {
            const prevIcon = currentBtn.querySelector('i');
            prevIcon.classList.remove('fa-pause');
            prevIcon.classList.add('fa-play');
          }

          icon.classList.remove("fa-play");
          icon.classList.add("fa-pause");

          currentBtn = btn;
        } else {
          if (player.paused) {
            player.play();
            icon.classList.remove("fa-play");
            icon.classList.add("fa-pause");
          } else {
            player.pause();
            icon.classList.remove("fa-pause");
            icon.classList.add("fa-play");
          }
        }
      })
    })

    player.addEventListener("ended", () => {
      if (currentBtn) {
        const icon = currentBtn.querySelector("i");
        icon.classList.remove("fa-pause");
        icon.classList.add("fa-play");
        currentBtn = null;
      }
    });

    document.querySelectorAll('.btn-edit-song').forEach(button => {
          button.addEventListener('click', async () => {
            const editSection = document.getElementById('song-edit-section');
            const btnAddsong = document.getElementById('btn-create-song');
            const songsTableContainer = document.getElementById('songs-table-container');
    
            if (editSection) editSection.classList.remove('hidden');
            if (btnAddsong) btnAddsong.classList.add('hidden');
            if (songsTableContainer) songsTableContainer.classList.add('hidden');
    
            const id = button.getAttribute('data-id');
            const response = await fetch(`/api/songs/${id}`, {
              headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
              }
            });
            const albumsJson = await fetch('/api/albums', {
              headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
              }
            });
    
            if (!response.ok || !albumsJson.ok) {
              const error = await response.json().catch(()=>{});
              throw {
                message: error.message || 'Error al carga cancion',
              };
            }
            
            const songResponse = await response.json();
            const albumsResponse = await albumsJson.json();
            const menuAlbums = document.getElementById('edit-album-select');
            
            menuAlbums.innerHTML = `
              <option value="">Seleccionar álbum</option>
              <option value="unknown">Álbum desconocido</option>
            `;

            albumsResponse.forEach(album => {
            const option = document.createElement("option");
            option.value = album.id;
            option.textContent = `${album.title} (${album.year})`;
            
            if (songResponse.album && songResponse.album.id === album.id) {
              option.selected = true;
            }

            menuAlbums.appendChild(option);
            
            })
            if (songResponse.album === null) {
              menuAlbums.value = "unknown";
            }


            const titleInput = document.getElementById('edit-song-title');
            const artistInput = document.getElementById('edit-song-artist');
            const genreInput = document.getElementById('edit-song-genre');
            const durationInput = document.getElementById('edit-song-duration');
            const editForm = document.getElementById('edit-song-form');
            const previewContainer = document.querySelector('#edit-song-preview');
            const audio = previewContainer.querySelector('audio');
            const audioSource = audio.querySelector('source');
            
    
            if (titleInput) titleInput.value = songResponse.title;
            if (artistInput) artistInput.value = songResponse.artist;
            if (genreInput) genreInput.value = songResponse.genre;
            if (durationInput) {
              durationInput.value = secondsToMMSS(songResponse.duration);
            }
            if (editForm) editForm.dataset.id = songResponse.id;
            if (audioSource) {
              audioSource.setAttribute('src', `/storage/${songResponse.file_path}`);
              audio.load(); 
            }
    
            
        });
    
        document.querySelectorAll('.btn-delete-song').forEach(button => {
          const newBtn = button.cloneNode(true);
          button.replaceWith(newBtn);

          newBtn.addEventListener('click', async () => {
            const id = newBtn.dataset.id;
            if (!confirm("¿Seguro que deseas eliminar esta canción?")) return;

            try {
              const response = await fetch(`/api/songs/${id}`, { method: 'DELETE', headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
              if (!response.ok) throw new Error("Error al eliminar canción");

              alert("Canción eliminada correctamente");
              await cargarCanciones();
            } catch (err) {
              console.error(err);
              alert("No se pudo eliminar la canción");
            }
          });
        });
      
    })

  }
  catch (error) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar las canciones</p>
          <button onclick="cargarCanciones()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }

}