const cargarClientes = async () => {
  console.log('Cargando clientes...');
  const tbody = document.querySelector('#clientes-table-container tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de clientes');
    return;
  }

  // Mostrar estado de carga
  tbody.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando clientes...</p>
      </td>
    </tr>
  `;

  try {
    const response = await fetch('/api/clientes');
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar clientes',
      };
    }

    const clientes = await response.json();
    
    tbody.innerHTML = '';
    
    if (clientes.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-users text-4xl mb-4"></i>
            <p>No hay clientes disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    clientes.forEach((cliente, index) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';

      tr.innerHTML = `
        <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${cliente.nombre}</td>
        <td class="px-4 py-2 text-white">${cliente.email}</td>
        <td class="px-4 py-2 text-gray-300">${cliente.telefono || 'Sin teléfono'}</td>
        <td class="px-4 py-2">
          <span class="${cliente.estado ? 'text-green-400' : 'text-red-400'} font-semibold">
            ${cliente.estado ? 'Activo' : 'Inactivo'}
          </span>
        </td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button onclick="editarCliente(${cliente.id})" 
              class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button onclick="eliminarCliente(${cliente.id})" 
              class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </td>
      `;
      
      tbody.appendChild(tr);
    });

  } catch (error) {
    console.error('Error:', error);
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los clientes</p>
          <button onclick="cargarClientes()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

function editarCliente(id) {
    const editSection = document.getElementById('clientes-edit-section');
    const btnCreateCliente = document.getElementById('btn-create-cliente');
    const clientesContainer = document.getElementById('clientes-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnCreateCliente) btnCreateCliente.classList.add('hidden');
    if (clientesContainer) clientesContainer.classList.add('hidden');

    // Cargar datos del cliente
    fetch(`/api/clientes/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar cliente');
            }
            return response.json();
        })
        .then(cliente => {
            const nombreInput = document.getElementById('edit-cliente-nombre');
            const emailInput = document.getElementById('edit-cliente-email');
            const passwordInput = document.getElementById('edit-cliente-password');
            const telefonoInput = document.getElementById('edit-cliente-telefono');
            const direccionInput = document.getElementById('edit-cliente-direccion');
            const estadoSelect = document.getElementById('edit-cliente-estado');
            const editForm = document.getElementById('edit-clientes-form');

            if (nombreInput) nombreInput.value = cliente.nombre;
            if (emailInput) emailInput.value = cliente.email;
            if (passwordInput) passwordInput.value = ''; // Limpiar contraseña
            if (telefonoInput) telefonoInput.value = cliente.telefono || '';
            if (direccionInput) direccionInput.value = cliente.direccion || '';
            if (estadoSelect) estadoSelect.value = cliente.estado ? '1' : '0';
            if (editForm) editForm.dataset.id = cliente.id;
        })
        .catch(error => {
            console.error('Error al cargar cliente:', error);
            alert('Error al cargar los datos del cliente');
        });
}

function eliminarCliente(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
        fetch(`/api/clientes/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Cliente eliminado:', data);
            cargarClientes(); // Recargar la lista
        })
        .catch(error => {
            console.error('Error al eliminar cliente:', error);
            alert('Error al eliminar el cliente');
        });
    }
}

// Hacer las funciones disponibles globalmente
window.editarCliente = editarCliente;
window.eliminarCliente = eliminarCliente;
window.cargarClientes = cargarClientes;

// Cargar clientes automáticamente cuando se carga el script
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#clientes-table-container')) {
        cargarClientes();
    }
});
