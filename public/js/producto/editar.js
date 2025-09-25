document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-producto");
  const btnCancelar = document.getElementById("btn-cancel-edit-producto");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-productos-form");
      const productoId = form.dataset.id;

      try {
        const res = await fetch(`/api/productos/${productoId}`, {
          method: "PUT",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("edit-producto-nombre").value,
            descripcion: document.getElementById("edit-producto-descripcion").value,
            precio: parseFloat(document.getElementById("edit-producto-precio").value),
            categoria_id: parseInt(document.getElementById("edit-producto-categoria").value) || null,
            stock: parseInt(document.getElementById("edit-producto-stock").value)
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al actualizar: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Producto actualizado correctamente");

        document.getElementById("productos-edit-section").classList.add("hidden");
        document.getElementById("productos-container").classList.remove("hidden");
        document.getElementById("btn-create-producto").classList.remove("hidden");

        if (typeof cargarProductos === "function") {
          cargarProductos();
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("productos-edit-section").classList.add("hidden");
      document.getElementById("productos-container").classList.remove("hidden");
      document.getElementById("btn-create-producto").classList.remove("hidden");
    });
  }
});
