import { cargarPlaylists } from "./cargarPlaylists.js";

// crearPlaylist
document.addEventListener('DOMContentLoaded', () => {
  const btnCreatePlaylist = document.getElementById('btn-create-playlist');
  const sectionCreate = document.getElementById('playlist-create-section');
  const sectionList = document.getElementById('playlists-container');
  const createForm = document.getElementById('create-playlist-form');
  const imagePreviewPlaceholder = document.getElementById("create-playlist-placeholder");



  if (btnCreatePlaylist && sectionCreate && sectionList && createForm) {
    btnCreatePlaylist.addEventListener('click', async () => {

      console.log('Botón crear playlist clickeado');
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreatePlaylist.classList.add('hidden');
    
    });
  } else {
    console.warn("Elementos para crear canción no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-playlist");
  const btnCancelar = document.getElementById("btn-cancel-create-playlist");
  const imagePreview = document.getElementById("create-playlist-image-preview");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();
      
      const formData = new FormData();
      formData.append("title", document.getElementById("create-playlist-title").value);
      formData.append("description", document.getElementById("create-playlist-description").value);
      
      const playlistFileInput = document.getElementById("create-playlist-file");
      if (playlistFileInput.files[0]) {
        formData.append("cover_image", playlistFileInput.files[0]);
      }

      if (!formData.get("title") ) {
        return alert("Debe ingresar un titulo");
      }

      try {
        const token = localStorage.getItem('auth_token');
        const res = await fetch("/api/playlists", {
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

        alert("playlist creado correctamente");

        sectionCreate.classList.add("hidden");
        sectionList.classList.remove("hidden");
        btnCreatePlaylist.classList.remove("hidden");
        
        createForm.reset();

        imagePreview.classList.add('hidden');
        imagePreviewPlaceholder.classList.remove('hidden');
        

        if (typeof cargarPlaylists === "function") {
          cargarPlaylists();
        }

        

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert(" Falló la conexión con el servidor.");
      }
    });
  } 


  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      createForm.reset();
      imagePreview.classList.add('hidden');
      imagePreviewPlaceholder.classList.remove('hidden');
      sectionCreate.classList.add('hidden');      
      sectionList.classList.remove('hidden');           
      btnCreatePlaylist.classList.remove('hidden');
    });
  }
  

  
});