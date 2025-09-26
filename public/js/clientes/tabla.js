const cargarClientes = async () => {
  console.log('Cargando clientes...');
  const tbody = document.querySelector('#clientes-tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de clientes');
    return;
  }

  // Mostrar estado de carga (cambiar colspan a 6)
  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando clientes...</p>
      </td>
    </tr>
  `;

  try {
    const token = localStorage.getItem('auth_token');
    const response = await fetch('/api/clientes', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar clientes',
      };
    }

    const clientes = await response.json();
    console.log('Clientes cargados:', clientes);
    
    tbody.innerHTML = '';
    
    if (clientes.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-users text-4xl mb-4"></i>
            <p>No hay clientes registrados</p>
          </td>
        </tr>
      `;
      return;
    }

    clientes.forEach((cliente) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#232323] transition-colors';
      tr.dataset.clienteId = cliente.id;

      // Formatear fecha
      const fechaRegistro = cliente.created_at ? 
        new Date(cliente.created_at).toLocaleDateString('es-ES', {
          year: 'numeric',
          month: 'short',
          day: '2-digit'
        }) : 'N/A';

      tr.innerHTML = `
        <td class="px-4 py-3 text-sm font-medium text-white">${cliente.id}</td>
        <td class="px-4 py-3 text-sm text-gray-300">${cliente.usuario_id || 'N/A'}</td>
        <td class="px-4 py-3 text-sm font-medium text-white">${cliente.nombre || 'Sin nombre'}</td>
        <td class="px-4 py-3 text-sm text-gray-300">${cliente.email || 'Sin email'}</td>
        <td class="px-4 py-3 text-sm">
          <span class="px-2 py-1 rounded-full text-xs font-medium ${
            cliente.estado 
              ? 'bg-green-900 text-green-300 border border-green-700' 
              : 'bg-red-900 text-red-300 border border-red-700'
          }">
            <i class="fa-solid fa-${cliente.estado ? 'check-circle' : 'times-circle'} mr-1"></i>
            ${cliente.estado ? 'Activo' : 'Inactivo'}
          </span>
        </td>
        <td class="px-4 py-3 text-sm">
          <div class="flex space-x-2">
            <button onclick="editarCliente(${cliente.id})" 
              class="text-blue-400 hover:text-blue-300 transition hover:scale-110" 
              title="Editar cliente">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button onclick="toggleEstadoCliente(${cliente.id}, ${cliente.estado})" 
              class="text-yellow-400 hover:text-yellow-300 transition hover:scale-110" 
              title="${cliente.estado ? 'Desactivar' : 'Activar'} cliente">
              <i class="fa-solid fa-toggle-${cliente.estado ? 'on' : 'off'}"></i>
            </button>
            <button onclick="eliminarCliente(${cliente.id}, '${cliente.nombre}')" 
              class="text-red-400 hover:text-red-300 transition hover:scale-110" 
              title="Eliminar cliente">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      
      tbody.appendChild(tr);
    });

    console.log(`✅ Se cargaron ${clientes.length} clientes correctamente`);

  } catch (error) {
    console.error('Error al cargar clientes:', error);
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los clientes</p>
          <p class="text-sm text-gray-500 mt-1">${error.message}</p>
          <button onclick="cargarClientes()" class="mt-3 px-4 py-2 bg-[#e7452e] hover:bg-[#c53a22] text-white rounded text-sm transition">
            <i class="fa-solid fa-refresh mr-2"></i>Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

function editarCliente(id) {
    console.log('Editando cliente ID:', id);
    
    const editSection = document.getElementById('clientes-edit-section');
    const btnCreateCliente = document.getElementById('btn-create-cliente');
    const clientesContainer = document.getElementById('clientes-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnCreateCliente) btnCreateCliente.classList.add('hidden');
    if (clientesContainer) clientesContainer.classList.add('hidden');

    // IMPORTANTE: Establecer el ID inmediatamente en el formulario
    const form = document.getElementById("edit-clientes-form");
    if (form) {
        form.dataset.id = id;
        console.log('ID establecido en el formulario:', form.dataset.id);
    }

    // Cargar datos del cliente
    const token = localStorage.getItem('auth_token');
    
    fetch(`/api/clientes/${id}`, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al cargar cliente');
        }
        return response.json();
    })
    .then(data => {
        const cliente = data.cliente;
        console.log('Datos del cliente para editar:', cliente);

        // Confirmar que el ID está establecido
        form.dataset.id = cliente.id;
        console.log('ID confirmado en el formulario:', form.dataset.id);

        // Llenar los campos del formulario
        document.getElementById("edit-cliente-nombre").value = cliente.nombre || '';
        document.getElementById("edit-cliente-email").value = cliente.email || '';
        document.getElementById("edit-cliente-password").value = ''; // Siempre vacío
        document.getElementById("edit-cliente-telefono").value = cliente.telefono || '';
        document.getElementById("edit-cliente-direccion").value = cliente.direccion || '';
        document.getElementById("edit-cliente-estado").value = cliente.estado ? "1" : "0";
    })
    .catch(error => {
        console.error('Error al cargar cliente:', error);
        alert('Error al cargar los datos del cliente: ' + error.message);
        
        // Si hay error, volver a la lista
        document.getElementById("clientes-edit-section").classList.add("hidden");
        document.getElementById("clientes-container").classList.remove("hidden");
        document.getElementById("btn-create-cliente").classList.remove("hidden");
    });
}

function toggleEstadoCliente(id, estadoActual) {
    const nuevoEstado = !estadoActual;
    const accion = nuevoEstado ? 'activar' : 'desactivar';
    
    if (confirm(`¿Estás seguro de que deseas ${accion} este cliente?`)) {
        const token = localStorage.getItem('auth_token');
        
        fetch(`/api/clientes/${id}/toggle-estado`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Estado cambiado:', data.message);
                cargarClientes(); // Recargar la tabla
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error al cambiar estado:', error);
            alert('Error al cambiar el estado del cliente: ' + error.message);
        });
    }
}

function eliminarCliente(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar el cliente "${nombre}"?\n\nEsta acción también eliminará el usuario asociado y no se puede deshacer.`)) {
        const token = localStorage.getItem('auth_token');
        
        fetch(`/api/clientes/${id}`, {
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
                console.log('Cliente eliminado:', data.message);
                cargarClientes(); // Recargar la lista
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error al eliminar cliente:', error);
            alert('Error al eliminar el cliente: ' + error.message);
        });
    }
}

// Hacer las funciones disponibles globalmente
window.editarCliente = editarCliente;
window.toggleEstadoCliente = toggleEstadoCliente;
window.eliminarCliente = eliminarCliente;
window.cargarClientes = cargarClientes;

// Auto-cargar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado, verificando tabla de clientes...');
    if (document.querySelector('#clientes-tbody')) {
        console.log('Tabla encontrada, cargando clientes...');
        setTimeout(cargarClientes, 500); // Pequeño delay para asegurar que todo esté listo
    }
});
