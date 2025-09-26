
const mmssToSeconds = (mmss) => {
  if (!mmss) return 0;
  const [m, s] = mmss.split(":").map(Number);
  if (isNaN(m) || isNaN(s)) return 0;
  return m * 60 + s;
}

document.addEventListener('DOMContentLoaded', () => {
  const btnCreateSong = document.getElementById('btn-create-song');
  const sectionCreate = document.getElementById('song-create-section');
  const sectionList = document.getElementById('songs-table-container');
  const createForm = document.getElementById('create-song-form');
  const token = localStorage.getItem('auth_token');
  if (!token) { 
    alert('No estás autenticado. Por favor, inicia sesión.');
    window.location.href = '/login';
    return;
  }

  if (btnCreateSong && sectionCreate && sectionList && createForm) {
    btnCreateSong.addEventListener('click', async () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateSong.classList.add('hidden');
      
      const albumsJson = await fetch('/api/albums', {
        headers: {
          'Authorization': `Bearer ${token}`,
          "Accept": "application/json"
        }
      });
      const albumsResponse = await albumsJson.json();
      const menuAlbums = document.getElementById('create-album-select');     
      menuAlbums.innerHTML = `
        <option value="select" selected>Seleccionar álbum</option>
        <option value="unknown">Álbum desconocido</option>
      `;

      albumsResponse.forEach(album => {
        const option = document.createElement("option");
        option.value = album.id;
        option.textContent = `${album.title} (${album.year})`;
        menuAlbums.appendChild(option);
        
      })  
    
    });

  } else {
    console.warn("Elementos para crear canción no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-song");
  const btnCancelar = document.getElementById("btn-cancel-create-song");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();
      
      const formData = new FormData();
      const durationInput = document.getElementById("create-song-duration");
       const regex = /^[0-5]?[0-9]:[0-5][0-9]$/;
      if (!regex.test(durationInput.value)) {
        e.preventDefault();
        alert("La duración debe estar en formato mm:ss (ejemplo 04:32)");
        return;
      }
      formData.append("title", document.getElementById("create-song-title").value);
      formData.append("artist", document.getElementById("create-song-artist").value);
      formData.append("genre", document.getElementById("create-song-genre").value);
      formData.append("duration", mmssToSeconds(durationInput.value));
      formData.append("genre", document.getElementById("create-song-genre").value);

      const songFileInput = document.getElementById("create-song-file");
      if (songFileInput.files.length > 0) {
        formData.append("file", songFileInput.files[0]);
      } else {
        return alert("Debes seleccionar un archivo de audio.");
      }

      const albumSelect = document.getElementById("create-album-select");
      if (albumSelect.value === "unknown") {
        formData.append("album_id", "");
      } else if (albumSelect.value !== "select") {
        formData.append("album_id", albumSelect.value);
      }

      if (!formData.get("title") || !formData.get("artist") || !formData.get("genre") || !formData.get("duration") || !formData.get("file") ) {
        return alert("Todos los campos deben estar llenos");
      }

      try {
        const res = await fetch("/api/songs", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`,
            "Accept": "application/json",
          },
          body: formData,
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Cancion creada correctamente");

        sectionCreate.classList.add("hidden");
        sectionList.classList.remove("hidden");
        btnCreateSong.classList.remove("hidden");
        

        if (typeof cargarCanciones === "function") {
          cargarCanciones();
        }

        createForm.reset();
        

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert(" Falló la conexión con el servidor.");
      }
    });
  } 


  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("song-create-section").classList.add("hidden");
      document.getElementById("song-container").classList.remove("hidden");
      document.getElementById("btn-create-song").classList.remove("hidden");
    });
  }
  

  
});