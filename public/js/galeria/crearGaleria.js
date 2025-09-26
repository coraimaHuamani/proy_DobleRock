document.addEventListener('DOMContentLoaded', () => {
  const btnCreateGaleria = document.getElementById('btn-create-galeria');
  const sectionCreate = document.getElementById('galeria-create-section');
  const sectionList = document.getElementById('galeria-container');

  if (btnCreateGaleria && sectionCreate && sectionList) {
    btnCreateGaleria.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateGaleria.classList.add('hidden');
    });
  } else {
    console.warn("Elementos para crear galería no encontrados.");
  }

  // AGREGADO: Preview de archivo al seleccionar
  const archivoInput = document.getElementById("create-galeria-archivo");
  const imgPreview = document.getElementById("create-galeria-preview");
  const videoPreview = document.getElementById("create-galeria-video-preview");
  const placeholder = document.getElementById("create-galeria-placeholder");

  if (archivoInput) {
    archivoInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          if (placeholder) placeholder.classList.add('hidden');
          
          if (file.type.startsWith('image/')) {
            if (imgPreview) {
              imgPreview.src = e.target.result;
              imgPreview.classList.remove('hidden');
            }
            if (videoPreview) {
              videoPreview.classList.add('hidden');
            }
          } else if (file.type.startsWith('video/')) {
            if (videoPreview) {
              videoPreview.src = e.target.result;
              videoPreview.classList.remove('hidden');
            }
            if (imgPreview) {
              imgPreview.classList.add('hidden');
            }
          }
        };
        reader.readAsDataURL(file);
      } else {
        // Resetear preview si no hay archivo
        if (placeholder) placeholder.classList.remove('hidden');
        if (imgPreview) {
          imgPreview.classList.add('hidden');
          imgPreview.src = '';
        }
        if (videoPreview) {
          videoPreview.classList.add('hidden');
          videoPreview.src = '';
        }
      }
    });
  }

  const btnGuardar = document.getElementById("btn-save-create-galeria");
  const btnCancelar = document.getElementById("btn-cancel-create-galeria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-galeria-form");
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      const formData = new FormData();

      formData.append("titulo", document.getElementById("create-galeria-titulo").value);
      formData.append("descripcion", document.getElementById("create-galeria-descripcion").value);
      formData.append("tipo", document.getElementById("create-galeria-tipo").value);
      formData.append("estado", parseInt(document.getElementById("create-galeria-estado").value));

      const archivoInput = document.getElementById("create-galeria-archivo");
      if (archivoInput.files[0]) {
        formData.append("archivo", archivoInput.files[0]);
      }

      try {
        const res = await fetch("/api/galeria", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json'
            // No agregar Content-Type para FormData
          },
          body: formData,
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Archivo agregado correctamente");

        document.getElementById("galeria-create-section").classList.add("hidden");
        document.getElementById("galeria-container").classList.remove("hidden");
        document.getElementById("btn-create-galeria").classList.remove("hidden");

        if (typeof cargarGaleria === "function") {
          cargarGaleria();
        }

        form.reset();
        
        // MEJORADO: Limpiar previews
        if (imgPreview) {
          imgPreview.src = "";
          imgPreview.classList.add("hidden");
        }
        if (videoPreview) {
          videoPreview.src = "";
          videoPreview.classList.add("hidden");
        }
        if (placeholder) {
          placeholder.classList.remove("hidden");
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  } 

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("galeria-create-section").classList.add("hidden");
      document.getElementById("galeria-container").classList.remove("hidden");
      document.getElementById("btn-create-galeria").classList.remove("hidden");
      
      // AGREGADO: Limpiar formulario y previews
      const form = document.getElementById("create-galeria-form");
      if (form) form.reset();
      
      if (imgPreview) {
        imgPreview.src = "";
        imgPreview.classList.add("hidden");
      }
      if (videoPreview) {
        videoPreview.src = "";
        videoPreview.classList.add("hidden");
      }
      if (placeholder) {
        placeholder.classList.remove("hidden");
      }
    });
  }
});
