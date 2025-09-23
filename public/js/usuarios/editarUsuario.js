document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-user");
  const btnCancelar = document.getElementById("btn-cancel-edit-user");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-users-form");
      const userId = form.dataset.id;
      const rolValue = document.getElementById("edit-user-rol").value;

      // Mapear valores de rol a enteros
      const rolMapping = {
        '1': 1,
        '2': 2,
        '3': 3
      };

      const userData = {
        nombre: document.getElementById("edit-user-nombre").value,
        email: document.getElementById("edit-user-email").value,
        rol: rolValue ? rolMapping[rolValue] || null : null,
        estado: parseInt(document.getElementById("edit-user-estado").value)
      };

      // Solo agregar contraseña si se especifica
      const password = document.getElementById("edit-user-password").value;
      if (password && password.trim() !== '') {
        userData.password = password;
      }

      try {
        const res = await fetch(`/api/usuarios/${userId}`, {
          method: "PUT",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(userData)
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al actualizar: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Usuario actualizado correctamente");

        document.getElementById("users-edit-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");

        if (typeof cargarUsuarios === "function") {
          cargarUsuarios();
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("users-edit-section").classList.add("hidden");
      document.getElementById("users-container").classList.remove("hidden");
      document.getElementById("btn-create-user").classList.remove("hidden");
    });
  }
});
