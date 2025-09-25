document.addEventListener('DOMContentLoaded', () => {
  const btnCreateUser = document.getElementById('btn-create-user');
  const sectionCreate = document.getElementById('users-create-section');
  const sectionList = document.getElementById('users-container');

  if (btnCreateUser && sectionCreate && sectionList) {
    btnCreateUser.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateUser.classList.add('hidden');
    });
  } else {
    console.warn("Elementos para crear usuario no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-user");
  const btnCancelar = document.getElementById("btn-cancel-create-user");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-users-form");
      const rolValue = document.getElementById("create-user-rol").value;

      // Mapear strings a números para los roles - solo Admin y Cliente
      const rolMapping = {
        'admin': 1,
        'cliente': 2
      };

      try {
        const res = await fetch("/api/usuarios", {
          method: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("create-user-nombre").value,
            email: document.getElementById("create-user-email").value,
            password: document.getElementById("create-user-password").value,
            rol: rolValue ? rolMapping[rolValue] || null : null,
            estado: parseInt(document.getElementById("create-user-estado").value)
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Usuario creado correctamente");

        document.getElementById("users-create-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");

        if (typeof cargarUsuarios === "function") {
          cargarUsuarios();
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
      document.getElementById("users-create-section").classList.add("hidden");
      document.getElementById("users-container").classList.remove("hidden");
      document.getElementById("btn-create-user").classList.remove("hidden");
    });
  }
});
