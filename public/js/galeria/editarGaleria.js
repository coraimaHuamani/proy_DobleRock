document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-galeria");
  const btnCancelar = document.getElementById("btn-cancel-edit-galeria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-galeria-form");
      const galeriaId = form.dataset.id;
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      const formData = new FormData();

      formData.append("_method", "PUT");
      formData.append("titulo", document.getElementById("edit-galeria-titulo").value);
      formData.append("descripcion", document.getElementById("edit-galeria-descripcion").value);
      formData.append("tipo", document.getElementById("edit-galeria-tipo").value);
      formData.append("estado", parseInt(document.getElementById("edit-galeria-estado").value));

      // Solo agregar archivo si se selecciona uno nuevo
      const archivoInput = document.getElementById("edit-galeria-archivo");
      if (archivoInput.files[0]) {
        formData.append("archivo", archivoInput.files[0]);
      }

      try {
        const res = await fetch(`/api/galeria/${galeriaId}`, {
          method: "POST", // Laravel necesita POST para _method PUT
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json'
            // No agregar Content-Type para FormData
          },
          body: formData
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al actualizar: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Archivo actualizado correctamente");

        document.getElementById("galeria-edit-section").classList.add("hidden");
        document.getElementById("galeria-container").classList.remove("hidden");
        document.getElementById("btn-create-galeria").classList.remove("hidden");

        if (typeof cargarGaleria === "function") {
          cargarGaleria();
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("galeria-edit-section").classList.add("hidden");
      document.getElementById("galeria-container").classList.remove("hidden");
      document.getElementById("btn-create-galeria").classList.remove("hidden");
    });
  }

  // MEJORADO: Preview de archivo al cambiar
  const archivoInput = document.getElementById("edit-galeria-archivo");
  const imgPreview = document.getElementById("edit-galeria-preview");
  const videoPreview = document.getElementById("edit-galeria-video-preview");

  if (archivoInput) {
    archivoInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
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
      }
    });
  }
});
