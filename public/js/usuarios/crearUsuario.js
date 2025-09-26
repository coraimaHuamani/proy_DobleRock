document.addEventListener('DOMContentLoaded', () => {
  const btnCreateUser = document.getElementById('btn-create-user');
  const sectionCreate = document.getElementById('users-create-section');
  const sectionList = document.getElementById('users-container');

  if (btnCreateUser && sectionCreate && sectionList) {
    btnCreateUser.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateUser.classList.add('hidden');
      
      // Limpiar formulario
      const form = document.getElementById("create-users-form");
      if (form) {
        form.reset();
        // Establecer valores por defecto
        document.getElementById("create-user-estado").value = "1"; // Activo por defecto
      }
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
      
      // Obtener datos del formulario
      const nombre = document.getElementById("create-user-nombre").value.trim();
      const email = document.getElementById("create-user-email").value.trim();
      const password = document.getElementById("create-user-password").value;
      const rol = parseInt(document.getElementById("create-user-rol").value);
      const telefono = document.getElementById("create-user-telefono").value.trim();
      const direccion = document.getElementById("create-user-direccion").value.trim();
      const estado = parseInt(document.getElementById("create-user-estado").value);

      // Validaciones básicas
      if (!nombre) {
        alert("El nombre es requerido");
        document.getElementById("create-user-nombre").focus();
        return;
      }

      if (!email) {
        alert("El email es requerido");
        document.getElementById("create-user-email").focus();
        return;
      }

      if (!password || password.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres");
        document.getElementById("create-user-password").focus();
        return;
      }

      if (!rol || (rol !== 1 && rol !== 2)) {
        alert("Debes seleccionar un rol válido");
        document.getElementById("create-user-rol").focus();
        return;
      }

      // Deshabilitar botón mientras se procesa
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Creando...';

      try {
        const token = localStorage.getItem('auth_token');
        
        if (!token) {
          alert('No tienes autorización. Inicia sesión nuevamente.');
          return;
        }

        console.log('Enviando datos del usuario:', {
          nombre, email, rol, telefono, direccion, estado
        });

        const res = await fetch("/api/usuarios", {
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
            rol,
            telefono: telefono || null,
            direccion: direccion || null,
            estado: Boolean(estado) // Convertir a boolean
          })
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
            alert("Error al crear el usuario: " + (data.message || 'Error desconocido'));
          }
          return;
        }

        console.log('Usuario creado exitosamente:', data);
        alert("Usuario creado correctamente");

        // Ocultar formulario y mostrar lista
        document.getElementById("users-create-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");

        // Recargar la tabla de usuarios
        if (typeof cargarUsuarios === "function") {
          cargarUsuarios();
        }

        // Limpiar formulario
        form.reset();
        document.getElementById("create-user-estado").value = "1"; // Volver a activo por defecto

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Error de conexión con el servidor. Intenta nuevamente.");
      } finally {
        // Rehabilitar botón
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i>Crear Usuario';
      }
    });
  } 

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      if (confirm('¿Estás seguro de que deseas cancelar? Los datos no guardados se perderán.')) {
        document.getElementById("users-create-section").classList.add("hidden");
        document.getElementById("users-container").classList.remove("hidden");
        document.getElementById("btn-create-user").classList.remove("hidden");
        
        // Limpiar formulario
        const form = document.getElementById("create-users-form");
        if (form) {
          form.reset();
        }
      }
    });
  }
});
