document.addEventListener('DOMContentLoaded', () => {
  const btnCreateAlbum = document.getElementById('btn-create-album');
  const sectionCreate = document.getElementById('album-create-section');
  const sectionList = document.getElementById('albums-table-container');
  const createForm = document.getElementById('create-album-form');


  if (btnCreateAlbum && sectionCreate && sectionList && createForm) {
    btnCreateAlbum.addEventListener('click', async () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateAlbum.classList.add('hidden');
    
    });
  } else {
    console.warn("Elementos para crear canción no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-album");
  const btnCancelar = document.getElementById("btn-cancel-create-album");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();
      
      const formData = new FormData();
      formData.append("title", document.getElementById("create-album-title").value);
      formData.append("year", document.getElementById("create-album-year").value);
      
      const albumFileInput = document.getElementById("create-album-file");
      if (albumFileInput.files[0]) {
        formData.append("cover_image_path", albumFileInput.files[0]);
      } else {
        return alert("Debes seleccionar un archivo de audio.");
      }

      if (!formData.get("title") || !formData.get("year") || !formData.get("cover_image_path") ) {
        return alert("Todos los campos deben estar llenos");
      }

      try {
        const res = await fetch("/api/albums", {
          method: "POST",
          body: formData,
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Album creado correctamente");

        sectionCreate.classList.add("hidden");
        sectionList.classList.remove("hidden");
        btnCreateAlbum.classList.remove("hidden");
        

        if (typeof cargarAlbumes === "function") {
          cargarAlbumes();
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
      document.getElementById("album-create-section").classList.add("hidden");
      document.getElementById("albums-table-container").classList.remove("hidden");
      document.getElementById("btn-create-album").classList.remove("hidden");
    });
  }
  

  
});