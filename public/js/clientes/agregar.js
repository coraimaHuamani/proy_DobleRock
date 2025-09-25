document.addEventListener('DOMContentLoaded', () => {
  const btnCreateCliente = document.getElementById('btn-create-cliente');
  const sectionCreate = document.getElementById('clientes-create-section');
  const sectionList = document.getElementById('clientes-container');

  if (btnCreateCliente && sectionCreate && sectionList) {
    btnCreateCliente.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateCliente.classList.add('hidden');
    });
  } else {
    console.warn("Elementos para crear cliente no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-cliente");
  const btnCancelar = document.getElementById("btn-cancel-create-cliente");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-clientes-form");

      try {
        const res = await fetch("/api/clientes", {
          method: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("create-cliente-nombre").value,
            email: document.getElementById("create-cliente-email").value,
            password: document.getElementById("create-cliente-password").value,
            telefono: document.getElementById("create-cliente-telefono").value,
            direccion: document.getElementById("create-cliente-direccion").value,
            estado: parseInt(document.getElementById("create-cliente-estado").value)
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Cliente creado correctamente");

        document.getElementById("clientes-create-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");

        if (typeof cargarClientes === "function") {
          cargarClientes();
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
      document.getElementById("clientes-create-section").classList.add("hidden");
      document.getElementById("clientes-container").classList.remove("hidden");
      document.getElementById("btn-create-cliente").classList.remove("hidden");
    });
  }
});
