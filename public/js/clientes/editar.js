document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-cliente");
  const btnCancelar = document.getElementById("btn-cancel-edit-cliente");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-clientes-form");
      const clienteId = form.dataset.id;

      const data = {
        nombre: document.getElementById("edit-cliente-nombre").value,
        email: document.getElementById("edit-cliente-email").value,
        telefono: document.getElementById("edit-cliente-telefono").value,
        direccion: document.getElementById("edit-cliente-direccion").value,
        estado: parseInt(document.getElementById("edit-cliente-estado").value)
      };

      // Solo incluir password si no está vacío
      const password = document.getElementById("edit-cliente-password").value;
      if (password.trim()) {
        data.password = password;
      }

      try {
        const res = await fetch(`/api/clientes/${clienteId}`, {
          method: "PUT",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al actualizar: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Cliente actualizado correctamente");

        document.getElementById("clientes-edit-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");

        if (typeof cargarClientes === "function") {
          cargarClientes();
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("clientes-edit-section").classList.add("hidden");
      document.getElementById("clientes-container").classList.remove("hidden");
      document.getElementById("btn-create-cliente").classList.remove("hidden");
    });
  }
});
