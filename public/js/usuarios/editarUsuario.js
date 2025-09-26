document.addEventListener('DOMContentLoaded', () => {
  const btnGuardar = document.getElementById("btn-save-edit-user");
  const btnCancelar = document.getElementById("btn-cancel-edit-user");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("edit-users-form");
      const userId = form ? form.dataset.id : null;

      console.log('=== DEBUG EDITAR USUARIO ===');
      console.log('Formulario encontrado:', !!form);
      console.log('Form dataset completo:', form ? form.dataset : 'No form');
      console.log('Usuario ID extraído:', userId);

      if (!userId || userId === '' || userId === 'undefined') {
        console.error('ID del usuario no válido:', userId);
        alert("Error: No se encontró el ID del usuario. Datos del form: " + JSON.stringify(form?.dataset || {}));
        return;
      }

      // Obtener datos del formulario
      const nombre = document.getElementById("edit-user-nombre").value.trim();
      const email = document.getElementById("edit-user-email").value.trim();
      const password = document.getElementById("edit-user-password").value.trim();
      const rol = parseInt(document.getElementById("edit-user-rol").value);
      const telefono = document.getElementById("edit-user-telefono").value.trim();
      const direccion = document.getElementById("edit-user-direccion").value.trim();
      const estado = parseInt(document.getElementById("edit-user-estado").value);

      // Validaciones básicas
      if (!nombre) {
        alert("El nombre es requerido");
        document.getElementById("edit-user-nombre").focus();
        return;
      }

      if (!email) {
        alert("El email es requerido");
        document.getElementById("edit-user-email").focus();
        return;
      }

      if (!rol || (rol !== 1 && rol !== 2)) {
        alert("Debes seleccionar un rol válido");
        document.getElementById("edit-user-rol").focus();
        return;
      }

      if (password && password.length < 6) {
        alert("Si especificas una nueva contraseña, debe tener al menos 6 caracteres");
        document.getElementById("edit-user-password").focus();
        return;
      }

      // Preparar datos para enviar
      const userData = {
        nombre,
        email,
        rol,
        telefono: telefono || null,
        direccion: direccion || null,
        estado: Boolean(estado)
      };

      // Solo agregar contraseña si se especifica
      if (password) {
        userData.password = password;
      }

      console.log('Actualizando usuario ID:', userId);
      console.log('Datos a enviar:', userData);

      // Deshabilitar botón mientras se procesa
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Actualizando...';

      try {
        const token = localStorage.getItem('auth_token');
        
        if (!token) {
          alert('No tienes autorización. Inicia sesión nuevamente.');
          return;
        }

        const res = await fetch(`/api/usuarios/${userId}`, {
          method: "PUT",
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(userData)
        });

        const data = await res.json();

        if (!res.ok) {
          console.error('Error del servidor:', data);
          
          if (data.errors) {
            // Mostrar errores de validación específicos
            let errorMessage = "Errores de validación:\n";
            Object.keys(data.errors).forEach(field => {
              errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
            });
            alert(errorMessage);
          } else {
            alert("Error al actualizar el usuario: " + (data.message || 'Error desconocido'));
          }
          return;
        }

        console.log('Usuario actualizado exitosamente:', data);
        alert("Usuario actualizado correctamente");

        // Ocultar formulario de edición y mostrar lista
        document.getElementById("users-edit-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");

        // Recargar la tabla de usuarios
        if (typeof cargarUsuarios === "function") {
          cargarUsuarios();
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
        btnGuardar.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i>Actualizar Usuario';
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      if (confirm('¿Estás seguro de que deseas cancelar? Los cambios no guardados se perderán.')) {
        document.getElementById("users-edit-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");

        // Limpiar formulario
        const form = document.getElementById("edit-users-form");
        if (form) {
          form.reset();
          form.dataset.id = '';
        }
      }
    });
  }
});
