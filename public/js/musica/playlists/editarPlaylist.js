import { cargarPlaylists } from "./cargarPlaylists.js";
import { renderizarCancionesTabla } from "./renderizarCancionesTabla.js";

document.addEventListener('DOMContentLoaded', async () => {

  const btnCancelar = document.getElementById('btn-cancel-edit-playlist');
  const btnGuardar = document.getElementById('btn-save-edit-playlist');
  const sectionEditar = document.getElementById('playlist-edit-section');
  const sectionListadoPlaylist = document.getElementById('playlists-container');
  const btnAgregarPlaylist = document.getElementById('btn-create-playlist');
  const btnAgregarCancion = document.getElementById('btn-add-song-to-playlist');
  const tablaCanciones = document.getElementById('playlist-songs-table');
  

  if (!btnCancelar || !btnGuardar || !sectionEditar || !sectionListadoPlaylist || !btnAgregarPlaylist || !btnAgregarCancion || !tablaCanciones ) {
    console.warn('No se encontraron algunos elementos del DOM necesarios para la edición.');
    return;
  }

  const imageInput = document.getElementById("edit-playlist-file");
  const imagePreview = document.getElementById("edit-playlist-image-preview");

  if (imageInput && imagePreview) {
    imageInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = () => {
            imagePreview.src = reader.result;
            imagePreview.classList.remove('hidden');
          };
          reader.readAsDataURL(file);
        } else {
          alert('Por favor, selecciona un archivo de imagen.');
        }
      }
    });
  }

  const token = localStorage.getItem('auth_token');
  if (!token) {
    alert('No estás autenticado. Por favor, inicia sesión.');
    window.location.href = '/login';
    return;
  }

  
  
  btnAgregarCancion.addEventListener('click', async () => {
    const songSelect = document.getElementById('edit-add-song-select');
    const songId = songSelect.value;
    const songText = songSelect.options[songSelect.selectedIndex]?.text;
    const songArtist = songSelect.options[songSelect.selectedIndex]?.dataset.artist || "Desconocido";
    const editForm = document.getElementById('edit-playlist-form');

    if ( !songId || !songText) {
      alert('Debes seleccionar una canción');
      return;
    }

    const playlistId = editForm?.dataset.id;

     try {
      const playlistResponse = await fetch(`/api/playlists/${playlistId}`, {
      headers: {
        "Authorization": `Bearer ${token}`,
        "Accept": "application/json"
      }
    });
    const playlist = await playlistResponse.json();

    const currentPlaylistSongs = playlist.songs || [];

    if (currentPlaylistSongs.some(s => s.id == songId)) {
      alert('La canción ya está en la lista');
      return;
    }


    
    const res = await fetch(`/api/playlists/${playlistId}/songs`, {
      method: "POST",
      headers: {
        "Authorization": `Bearer ${token}`,
        "Accept": "application/json",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ song_ids: [songId] })

      });
    
    if (!res.ok) {
      const error = await res.json();
      alert("Error al agregar la cancion: " + JSON.stringify(error.errors || error.message));
      return;
    }
       
    const updatedPlaylistResponse = await fetch(`/api/playlists/${playlistId}`, {
      headers: {
        "Authorization": `Bearer ${token}`,
        "Accept": "application/json"
      }
    });
    const updatedPlaylist = await updatedPlaylistResponse.json();

    renderizarCancionesTabla(updatedPlaylist.songs || []);
 } catch (error) {
    console.error("Error al conectar con el servidor:", error);
    alert("Falló la conexión con el servidor.");
  }
});
 
  




  btnGuardar.addEventListener('click', async (e) => {
    e.preventDefault();
    const editForm = document.getElementById('edit-playlist-form');
    const playlistId = editForm?.dataset.id;
    if (!playlistId) return alert("No se encontró el ID de la playlist");
    const title = document.getElementById("edit-playlist-title").value;
    const description = document.getElementById("edit-playlist-description").value;
    const playlistFileInput = document.getElementById("edit-playlist-file");

    const formData = new FormData();
    formData.append("title", title);
    formData.append("description", description);
    if (playlistFileInput.files.length > 0) {
      formData.append("cover_image", playlistFileInput.files[0]);
    } else {
      const filePath = editForm.dataset.filePath;
      if (filePath) {
        formData.append("cover_image", filePath);
      }
    }
    console.log(title);
    console.log(description);

    
    
    try {
      const res = await fetch(`/api/playlists/${playlistId}`, {
        method: "POST", 
        headers: { 
          "X-HTTP-Method-Override": "PUT",
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json"
        },
        body: formData,
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        return alert("Error al editar: " + JSON.stringify(error.errors || error.message));
      }

      alert("Musica actualizada correctamente");
      if (typeof cargarPlaylists === "function") {
        await cargarPlaylists(); 
      }
      sectionEditar.classList.add("hidden");
      sectionListadoPlaylist.classList.remove("hidden");
      btnAgregarPlaylist.classList.remove("hidden");

    } catch (error) {
      alert("Error al conectar con el servidor");
    }
  });

  btnCancelar.addEventListener('click', () => {
    sectionEditar.classList.add('hidden');
    sectionListadoPlaylist.classList.remove('hidden');
    btnAgregarPlaylist.classList.remove('hidden');
  });

  
});

