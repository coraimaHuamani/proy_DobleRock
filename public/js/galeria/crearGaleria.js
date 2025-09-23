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

  const btnGuardar = document.getElementById("btn-save-create-galeria");
  const btnCancelar = document.getElementById("btn-cancel-create-galeria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-galeria-form");
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
        document.getElementById("create-galeria-preview").src = "";
        document.getElementById("create-galeria-preview").classList.add("hidden");
        document.getElementById("create-galeria-video-preview").classList.add("hidden");
        document.getElementById("create-galeria-placeholder").classList.remove("hidden");

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
    });
  }
});
