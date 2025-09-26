document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-categoria");
  const btnCancelar = document.getElementById("btn-cancel-edit-categoria");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-categorias-form");
      const categoriaId = form.dataset.id;
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      try {
        const res = await fetch(`/api/categorias/${categoriaId}`, {
          method: "PUT",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("edit-categoria-nombre").value,
            descripcion: document.getElementById("edit-categoria-descripcion").value
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al actualizar: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Categoría actualizada correctamente");

        document.getElementById("categorias-edit-section").classList.add("hidden");
        document.getElementById("categorias-container").classList.remove("hidden");
        document.getElementById("btn-create-categoria").classList.remove("hidden");

        if (typeof cargarCategorias === "function") {
          cargarCategorias();
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("categorias-edit-section").classList.add("hidden");
      document.getElementById("categorias-container").classList.remove("hidden");
      document.getElementById("btn-create-categoria").classList.remove("hidden");
    });
  }
});
