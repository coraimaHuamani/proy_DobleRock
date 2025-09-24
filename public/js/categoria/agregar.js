document.addEventListener('DOMContentLoaded', () => {
  console.log('Script categoria/agregar.js cargado'); // Debug
  
  const btnCreateCategoria = document.getElementById('btn-create-categoria');
  const sectionCreate = document.getElementById('categorias-create-section');
  const sectionList = document.getElementById('categorias-container');

  console.log('btnCreateCategoria:', btnCreateCategoria); // Debug
  console.log('sectionCreate:', sectionCreate); // Debug
  console.log('sectionList:', sectionList); // Debug

  if (btnCreateCategoria && sectionCreate && sectionList) {
    btnCreateCategoria.addEventListener('click', (e) => {
      e.preventDefault();
      console.log('Botón agregar categoría clickeado'); // Debug
      
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateCategoria.classList.add('hidden');
    });
  } else {
    console.warn("Elementos para crear categoría no encontrados:");
    console.warn("btnCreateCategoria:", btnCreateCategoria);
    console.warn("sectionCreate:", sectionCreate);
    console.warn("sectionList:", sectionList);
  }

  const btnGuardar = document.getElementById("btn-save-create-categoria");
  const btnCancelar = document.getElementById("btn-cancel-create-categoria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-categorias-form");

      try {
        const res = await fetch("/api/categorias", {
          method: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("create-categoria-nombre").value,
            descripcion: document.getElementById("create-categoria-descripcion").value
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Categoría creada correctamente");

        document.getElementById("categorias-create-section").classList.add("hidden");
        document.getElementById("categorias-container").classList.remove("hidden");
        document.getElementById("btn-create-categoria").classList.remove("hidden");

        if (typeof cargarCategorias === "function") {
          cargarCategorias();
        }

        form.reset();

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("categorias-create-section").classList.add("hidden");
      document.getElementById("categorias-container").classList.remove("hidden");
      document.getElementById("btn-create-categoria").classList.remove("hidden");
    });
  }
});
