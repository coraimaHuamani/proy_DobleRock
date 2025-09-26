const cargarUsuarios = async () => {
  console.log('Cargando usuarios...');
  const tbody = document.querySelector('#users-tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de usuarios');
    return;
  }

  // Mostrar estado de carga (cambiar colspan a 6)
  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando usuarios...</p>
      </td>
    </tr>
  `;

  try {
    const token = localStorage.getItem('auth_token');
    
    if (!token) {
      throw new Error('No tienes autorización. Inicia sesión nuevamente.');
    }

    const response = await fetch('/api/usuarios', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar usuarios',
      };
    }

    const usuarios = await response.json();
    console.log('Usuarios cargados:', usuarios);
    
    tbody.innerHTML = '';
    
    if (usuarios.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-users text-4xl mb-4"></i>
            <p>No hay usuarios registrados</p>
          </td>
        </tr>
      `;
      return;
    }

    usuarios.forEach((usuario) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#232323] transition-colors';
      tr.dataset.usuarioId = usuario.id;

      // Determinar clase de rol y texto
      let rolClass = '';
      let rolTexto = '';
      
      if (usuario.rol === 1) {
        rolClass = 'bg-purple-900 text-purple-300 border border-purple-700';
        rolTexto = 'Administrador';
      } else if (usuario.rol === 2) {
        rolClass = 'bg-blue-900 text-blue-300 border border-blue-700';
        rolTexto = 'Cliente';
      } else {
        rolClass = 'bg-gray-900 text-gray-300 border border-gray-700';
        rolTexto = 'Sin rol';
      }

      tr.innerHTML = `
        <td class="px-4 py-3 text-sm font-medium text-white">${usuario.id}</td>
        <td class="px-4 py-3 text-sm font-medium text-white">${usuario.nombre || 'Sin nombre'}</td>
        <td class="px-4 py-3 text-sm text-gray-300">${usuario.email || 'Sin email'}</td>
        <td class="px-4 py-3 text-sm">
          <span class="px-2 py-1 rounded-full text-xs font-medium ${rolClass}">
            <i class="fa-solid fa-${usuario.rol === 1 ? 'user-shield' : 'user'} mr-1"></i>
            ${rolTexto}
          </span>
        </td>
        <td class="px-4 py-3 text-sm">
          <span class="px-2 py-1 rounded-full text-xs font-medium ${
            usuario.estado 
              ? 'bg-green-900 text-green-300 border border-green-700' 
              : 'bg-red-900 text-red-300 border border-red-700'
          }">
            <i class="fa-solid fa-${usuario.estado ? 'check-circle' : 'times-circle'} mr-1"></i>
            ${usuario.estado ? 'Activo' : 'Inactivo'}
          </span>
        </td>
        <td class="px-4 py-3 text-sm">
          <div class="flex space-x-2">
            <button onclick="editarUsuario(${usuario.id})" 
              class="text-blue-400 hover:text-blue-300 transition hover:scale-110" 
              title="Editar usuario">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button onclick="eliminarUsuario(${usuario.id}, '${usuario.nombre}')" 
              class="text-red-400 hover:text-red-300 transition hover:scale-110" 
              title="Eliminar usuario">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      
      tbody.appendChild(tr);
    });

    console.log(`✅ Se cargaron ${usuarios.length} usuarios correctamente`);

  } catch (error) {
    console.error('Error al cargar usuarios:', error);
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los usuarios</p>
          <p class="text-sm text-gray-500 mt-1">${error.message}</p>
          <button onclick="cargarUsuarios()" class="mt-3 px-4 py-2 bg-[#e7452e] hover:bg-[#c53a22] text-white rounded text-sm transition">
            <i class="fa-solid fa-refresh mr-2"></i>Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

function editarUsuario(id) {
    console.log('Editando usuario ID:', id);
    
    const editSection = document.getElementById('users-edit-section');
    const btnCreateUser = document.getElementById('btn-create-user');
    const usersContainer = document.getElementById('users-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnCreateUser) btnCreateUser.classList.add('hidden');
    if (usersContainer) usersContainer.classList.add('hidden');

    // Cargar datos del usuario
    const token = localStorage.getItem('auth_token');
    
    fetch(`/api/usuarios/${id}`, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al cargar usuario');
        }
        return response.json();
    })
    .then(data => {
        const usuario = data.usuario;
        console.log('Datos del usuario para editar:', usuario);

        // Llenar el formulario con los datos
        const editForm = document.getElementById('edit-users-form');
        const nombreInput = document.getElementById('edit-user-nombre');
        const emailInput = document.getElementById('edit-user-email');
        const passwordInput = document.getElementById('edit-user-password');
        const rolSelect = document.getElementById('edit-user-rol');
        const telefonoInput = document.getElementById('edit-user-telefono');
        const direccionInput = document.getElementById('edit-user-direccion');
        const estadoSelect = document.getElementById('edit-user-estado');

        if (editForm) editForm.dataset.id = usuario.id;
        if (nombreInput) nombreInput.value = usuario.nombre || '';
        if (emailInput) emailInput.value = usuario.email || '';
        if (passwordInput) passwordInput.value = ''; // Siempre vacío
        if (rolSelect) rolSelect.value = usuario.rol || '';
        if (telefonoInput) telefonoInput.value = usuario.telefono || '';
        if (direccionInput) direccionInput.value = usuario.direccion || '';
        if (estadoSelect) estadoSelect.value = usuario.estado ? '1' : '0';
    })
    .catch(error => {
        console.error('Error al cargar usuario:', error);
        alert('Error al cargar los datos del usuario: ' + error.message);
    });
}

function eliminarUsuario(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar el usuario "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
        const token = localStorage.getItem('auth_token');
        
        fetch(`/api/usuarios/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Usuario eliminado:', data.message);
                cargarUsuarios(); // Recargar la lista
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error al eliminar usuario:', error);
            alert('Error al eliminar el usuario: ' + error.message);
        });
    }
}

// Hacer las funciones disponibles globalmente
window.editarUsuario = editarUsuario;
window.eliminarUsuario = eliminarUsuario;
window.cargarUsuarios = cargarUsuarios;

// Auto-cargar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado, verificando tabla de usuarios...');
    if (document.querySelector('#users-tbody')) {
        console.log('Tabla encontrada, cargando usuarios...');
        setTimeout(cargarUsuarios, 500); // Pequeño delay para asegurar que todo esté listo
    }
});
