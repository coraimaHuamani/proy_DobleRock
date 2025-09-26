// crearPlaylist
document.addEventListener('DOMContentLoaded', () => {
  const btnCreatelaylist = document.getElementById('btn-create-playlist');
  const sectionCreate = document.getElementById('playlist-create-section');
  const sectionList = document.getElementById('playlists-table-container');
  const createForm = document.getElementById('create-playlist-form');


  if (btnCreatelaylist && sectionCreate && sectionList && createForm) {
    btnCreatelaylist.addEventListener('click', async () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreatelaylist.classList.add('hidden');
    
    });
  } else {
    console.warn("Elementos para crear canción no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-playlist");
  const btnCancelar = document.getElementById("btn-cancel-create-playlist");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();
      
      const formData = new FormData();
      formData.append("title", document.getElementById("create-playlist-title").value);
      formData.append("description", document.getElementById("create-playlist-description").value);
      
      const playlistFileInput = document.getElementById("create-playlist-file");
      if (playlistFileInput.files[0]) {
        formData.append("cover_image_path", playlistFileInput.files[0]);
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
        btnCreatelaylist.classList.remove("hidden");
        

        if (typeof cargarplaylistes === "function") {
          cargarplaylistes();
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
      document.getElementById("playlist-create-section").classList.add("hidden");
      document.getElementById("playlists-table-container").classList.remove("hidden");
      document.getElementById("btn-create-playlist").classList.remove("hidden");
    });
  }
  

  
});