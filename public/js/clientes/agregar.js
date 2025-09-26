document.addEventListener('DOMContentLoaded', () => {
  const btnCreateCliente = document.getElementById('btn-create-cliente');
  const sectionCreate = document.getElementById('clientes-create-section');
  const sectionList = document.getElementById('clientes-container');

  if (btnCreateCliente && sectionCreate && sectionList) {
    btnCreateCliente.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateCliente.classList.add('hidden');
      
      // Limpiar formulario
      const form = document.getElementById("create-clientes-form");
      if (form) {
        form.reset();
        // Establecer estado activo por defecto
        document.getElementById("create-cliente-estado").value = "1";
      }
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
      
      // Obtener datos del formulario
      const nombre = document.getElementById("create-cliente-nombre").value.trim();
      const email = document.getElementById("create-cliente-email").value.trim();
      const password = document.getElementById("create-cliente-password").value;
      const telefono = document.getElementById("create-cliente-telefono").value.trim();
      const direccion = document.getElementById("create-cliente-direccion").value.trim();
      const estado = parseInt(document.getElementById("create-cliente-estado").value);

      // Validaciones básicas
      if (!nombre) {
        alert("El nombre es requerido");
        document.getElementById("create-cliente-nombre").focus();
        return;
      }

      if (!email) {
        alert("El email es requerido");
        document.getElementById("create-cliente-email").focus();
        return;
      }

      if (!password || password.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres");
        document.getElementById("create-cliente-password").focus();
        return;
      }

      // Deshabilitar botón mientras se procesa
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Guardando...';

      try {
        const token = localStorage.getItem('auth_token');
        
        if (!token) {
          alert('No tienes autorización. Inicia sesión nuevamente.');
          return;
        }

        console.log('Enviando datos del cliente:', {
          nombre, email, telefono, direccion, estado
        });

        const res = await fetch("/api/clientes", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre,
            email,
            password,
            telefono: telefono || null,
            direccion: direccion || null,
            estado: Boolean(estado) // Convertir a boolean
          })
        });

        const data = await res.json();

        if (!res.ok) {
          console.error('Error del servidor:', data);
          
          if (data.errors) {
            // Mostrar errores de validación
            let errorMessage = "Errores de validación:\n";
            Object.keys(data.errors).forEach(field => {
              errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
            });
            alert(errorMessage);
          } else {
            alert("Error al crear el cliente: " + (data.message || 'Error desconocido'));
          }
          return;
        }

        console.log('Cliente creado exitosamente:', data);
        alert("Cliente creado correctamente");

        // Ocultar formulario y mostrar lista
        document.getElementById("clientes-create-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");

        // Recargar la tabla de clientes
        if (typeof cargarClientes === "function") {
          cargarClientes();
        }

        // Limpiar formulario
        form.reset();
        document.getElementById("create-cliente-estado").value = "1"; // Volver a activo por defecto

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Error de conexión con el servidor. Intenta nuevamente.");
      } finally {
        // Rehabilitar botón
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i>Guardar';
      }
    });
  } 

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      if (confirm('¿Estás seguro de que deseas cancelar? Los datos no guardados se perderán.')) {
        document.getElementById("clientes-create-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");
        
        // Limpiar formulario
        const form = document.getElementById("create-clientes-form");
        if (form) {
          form.reset();
        }
      }
    });
  }
});
