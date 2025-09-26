document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-cliente");
  const btnCancelar = document.getElementById("btn-cancel-edit-cliente");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-clientes-form");
      const clienteId = form.dataset.id;

      if (!clienteId) {
        alert("Error: No se encontró el ID del cliente");
        return;
      }

      // Obtener datos del formulario
      const nombre = document.getElementById("edit-cliente-nombre").value.trim();
      const email = document.getElementById("edit-cliente-email").value.trim();
      const password = document.getElementById("edit-cliente-password").value.trim();
      const telefono = document.getElementById("edit-cliente-telefono").value.trim();
      const direccion = document.getElementById("edit-cliente-direccion").value.trim();
      const estado = parseInt(document.getElementById("edit-cliente-estado").value);

      // Validaciones básicas
      if (!nombre) {
        alert("El nombre es requerido");
        document.getElementById("edit-cliente-nombre").focus();
        return;
      }

      if (!email) {
        alert("El email es requerido");
        document.getElementById("edit-cliente-email").focus();
        return;
      }

      if (password && password.length < 6) {
        alert("Si especificas una nueva contraseña, debe tener al menos 6 caracteres");
        document.getElementById("edit-cliente-password").focus();
        return;
      }

      // Preparar datos para enviar
      const data = {
        nombre,
        email,
        telefono: telefono || null,
        direccion: direccion || null,
        estado: Boolean(estado) // Convertir a boolean
      };

      // Solo incluir password si no está vacío
      if (password) {
        data.password = password;
      }

      console.log('Actualizando cliente ID:', clienteId);
      console.log('Datos a enviar:', data);

      // Deshabilitar botón mientras se procesa
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Actualizando...';

      try {
        const token = localStorage.getItem('auth_token');
        
        if (!token) {
          alert('No tienes autorización. Inicia sesión nuevamente.');
          return;
        }

        const res = await fetch(`/api/clientes/${clienteId}`, {
          method: "PUT",
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        const responseData = await res.json();

        if (!res.ok) {
          console.error('Error del servidor:', responseData);
          
          if (responseData.errors) {
            // Mostrar errores de validación
            let errorMessage = "Errores de validación:\n";
            Object.keys(responseData.errors).forEach(field => {
              errorMessage += `- ${field}: ${responseData.errors[field].join(', ')}\n`;
            });
            alert(errorMessage);
          } else {
            alert("Error al actualizar el cliente: " + (responseData.message || 'Error desconocido'));
          }
          return;
        }

        console.log('Cliente actualizado exitosamente:', responseData);
        alert("Cliente actualizado correctamente");

        // Ocultar formulario de edición y mostrar lista
        document.getElementById("clientes-edit-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");

        // Recargar la tabla de clientes
        if (typeof cargarClientes === "function") {
          cargarClientes();
        }

        // Limpiar formulario
        form.reset();
        form.dataset.id = '';

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Error de conexión con el servidor. Intenta nuevamente.");
      } finally {
        // Rehabilitar botón
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i>Actualizar Cliente';
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      if (confirm('¿Estás seguro de que deseas cancelar? Los cambios no guardados se perderán.')) {
        document.getElementById("clientes-edit-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");

        // Limpiar formulario
        const form = document.getElementById("edit-clientes-form");
        if (form) {
          form.reset();
          form.dataset.id = '';
        }
      }
    });
  }
});

// Función global para cargar datos del cliente en el formulario de edición
window.cargarDatosClienteEdit = function(cliente) {
  console.log('Cargando datos del cliente para editar:', cliente);
  
  const form = document.getElementById("edit-clientes-form");
  if (form) {
    form.dataset.id = cliente.id;
    
    document.getElementById("edit-cliente-nombre").value = cliente.nombre || '';
    document.getElementById("edit-cliente-email").value = cliente.email || '';
    document.getElementById("edit-cliente-password").value = ''; // Siempre vacío
    document.getElementById("edit-cliente-telefono").value = cliente.telefono || '';
    document.getElementById("edit-cliente-direccion").value = cliente.direccion || '';
    document.getElementById("edit-cliente-estado").value = cliente.estado ? "1" : "0";
  }
};
