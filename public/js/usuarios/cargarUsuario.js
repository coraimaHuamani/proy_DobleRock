function cargarUsuarios() {
    const tbody = document.querySelector('#users-table-container tbody');
    if (!tbody) {
        console.error('No se encontró la tabla de usuarios');
        return;
    }

    // Mostrar estado de carga
    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                <p>Cargando usuarios...</p>
            </td>
        </tr>
    `;

    fetch('/api/usuarios')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar usuarios');
            }
            return response.json();
        })
        .then(usuarios => {
            tbody.innerHTML = '';
            
            if (usuarios.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400">
                            <i class="fa-solid fa-users text-4xl mb-4"></i>
                            <p>No hay usuarios registrados</p>
                        </td>
                    </tr>
                `;
                return;
            }

            usuarios.forEach(usuario => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-[#1a1a1a] transition-colors';
                
                const fechaCreacion = usuario.fecha_creacion 
                    ? new Date(usuario.fecha_creacion).toLocaleDateString('es-ES')
                    : 'N/A';
                
                const estadoBadge = usuario.estado 
                    ? '<span class="px-2 py-1 text-xs bg-green-600 text-white rounded">Activo</span>'
                    : '<span class="px-2 py-1 text-xs bg-red-600 text-white rounded">Inactivo</span>';

                tr.innerHTML = `
                    <td class="px-4 py-2 text-white">#${String(usuario.id).padStart(3, '0')}</td>
                    <td class="px-4 py-2 text-white">${usuario.nombre}</td>
                    <td class="px-4 py-2 text-gray-300">${fechaCreacion}</td>
                    <td class="px-4 py-2 text-gray-300">${usuario.rol || 'Usuario'}</td>
                    <td class="px-4 py-2 text-gray-300">${usuario.email}</td>
                    <td class="px-4 py-2">${estadoBadge}</td>
                    <td class="px-4 py-2">
                        <div class="flex gap-2">
                            <button onclick="editarUsuario(${usuario.id})" 
                                class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button onclick="eliminarUsuario(${usuario.id})" 
                                class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-8 text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Error al cargar los usuarios</p>
                        <button onclick="cargarUsuarios()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
                            Reintentar
                        </button>
                    </td>
                </tr>
            `;
        });
}

function editarUsuario(id) {
    const editSection = document.getElementById('users-edit-section');
    const btnCreateUser = document.getElementById('btn-create-user');
    const usersContainer = document.getElementById('users-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnCreateUser) btnCreateUser.classList.add('hidden');
    if (usersContainer) usersContainer.classList.add('hidden');

    // Cargar datos del usuario
    fetch(`/api/usuarios/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar usuario');
            }
            return response.json();
        })
        .then(usuario => {
            const nombreInput = document.getElementById('edit-user-nombre');
            const emailInput = document.getElementById('edit-user-email');
            const passwordInput = document.getElementById('edit-user-password');
            const rolSelect = document.getElementById('edit-user-rol');
            const estadoSelect = document.getElementById('edit-user-estado');
            const editForm = document.getElementById('edit-users-form');

            if (nombreInput) nombreInput.value = usuario.nombre;
            if (emailInput) emailInput.value = usuario.email;
            if (passwordInput) passwordInput.value = ''; // Limpiar contraseña
            if (rolSelect) rolSelect.value = usuario.rol || '';
            if (estadoSelect) estadoSelect.value = usuario.estado ? '1' : '0';
            if (editForm) editForm.dataset.id = usuario.id;
        })
        .catch(error => {
            console.error('Error al cargar usuario:', error);
            alert('Error al cargar los datos del usuario');
        });
}

function eliminarUsuario(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        fetch(`/api/usuarios/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Usuario eliminado:', data);
            cargarUsuarios(); // Recargar la lista
        })
        .catch(error => {
            console.error('Error al eliminar usuario:', error);
            alert('Error al eliminar el usuario');
        });
    }
}

function abrirFormularioCreacion() {
    // Aquí implementarás la lógica para abrir el formulario de creación
    console.log('Abrir formulario de creación');
}

// Cargar usuarios automáticamente cuando se carga el script
document.addEventListener('DOMContentLoaded', () => {
    // Solo cargar si estamos en el dashboard y la tabla existe
    if (document.querySelector('#users-table-container')) {
        cargarUsuarios();
    }
});
