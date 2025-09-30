document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-producto");
  const btnCancelar = document.getElementById("btn-cancel-edit-producto");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-productos-form");
      const productoId = form.dataset.id;
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      const formData = new FormData();
      formData.append("nombre", document.getElementById("edit-producto-nombre").value);
      formData.append("descripcion", document.getElementById("edit-producto-descripcion").value);
      formData.append("precio", document.getElementById("edit-producto-precio").value);
      formData.append("categoria_id", document.getElementById("edit-producto-categoria").value);
      formData.append("stock", document.getElementById("edit-producto-stock").value);
      const imageInput = document.getElementById("edit-producto-imagen");
      if (imageInput?.files[0]) {
        formData.append("imagen", imageInput.files[0]);
      }
      console.log(formData);
      formData.append("_method", "PUT");

      try {
        const res = await fetch(`/api/productos/${productoId}`, {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json',
          },
          body: formData
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
