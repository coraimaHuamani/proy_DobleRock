document.addEventListener('DOMContentLoaded', () => {
  console.log('Script categoria/agregar.js cargado');
  
  const btnCreateCategoria = document.getElementById('btn-create-categoria');
  const sectionCreate = document.getElementById('categorias-create-section');
  const sectionList = document.getElementById('categorias-container');

  if (btnCreateCategoria && sectionCreate && sectionList) {
    btnCreateCategoria.addEventListener('click', (e) => {
      e.preventDefault();
      console.log('Botón agregar categoría clickeado');
      
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateCategoria.classList.add('hidden');
    });
  }

  const btnGuardar = document.getElementById("btn-save-create-categoria");
  const btnCancelar = document.getElementById("btn-cancel-create-categoria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-categorias-form");
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      try {
        const res = await fetch("/api/categorias", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
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
