<div class="mb-4 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-white">Sesiones Activas</h3>
    <button id="refresh-online-users" class="px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
        <i class="fa-solid fa-refresh mr-1"></i>
        Actualizar
    </button>
</div>

<div class="grid gap-4">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-[#232323] p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Administradores</p>
                    <p id="admin-count" class="text-2xl font-bold text-[#e7452e]">0</p>
                </div>
                <i class="fa-solid fa-user-shield text-3xl text-[#e7452e]"></i>
            </div>
        </div>
        
        <div class="bg-[#232323] p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Clientes En Línea</p>
                    <p id="cliente-count" class="text-2xl font-bold text-green-400">0</p>
                </div>
                <i class="fa-solid fa-users text-3xl text-green-400"></i>
            </div>
        </div>
        
        <div class="bg-[#232323] p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Activos</p>
                    <p id="total-count" class="text-2xl font-bold text-blue-400">0</p>
                </div>
                <i class="fa-solid fa-globe text-3xl text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios en línea -->
    <div class="overflow-x-auto">
        <table id="online-users-table" class="min-w-full divide-y divide-gray-700 bg-[#181818] rounded-lg shadow text-white">
            <thead class="bg-[#232323]">
                <tr>
                    <th class="px-4 py-2 text-left">Usuario</th>
                    <th class="px-4 py-2 text-left">Tipo</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Última Actividad</th>
                    <th class="px-4 py-2 text-left">IP</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody id="online-users-tbody" class="divide-y divide-gray-700">
                <!-- Los usuarios en línea se cargarán aquí -->
            </tbody>
        </table>
    </div>
</div>

<script>
let onlineUsers = [];

// Simular datos de usuarios en línea
function loadOnlineUsers() {
    // Obtener datos del localStorage y crear algunos usuarios simulados
    const clienteId = localStorage.getItem('cliente_id');
    const clienteNombre = localStorage.getItem('cliente_nombre');
    const clienteEmail = localStorage.getItem('cliente_email');
    
    onlineUsers = [
        // Admin actual (simulado)
        {
            id: 1,
            nombre: '{{ session("user", "Admin") }}',
            tipo: 'Administrador',
            email: 'admin@doblerock.com',
            ultimaActividad: 'Ahora',
            ip: '127.0.0.1',
            estado: 'online'
        }
    ];
    
    // Agregar cliente si está logueado
    if (clienteId && clienteNombre) {
        onlineUsers.push({
            id: clienteId,
            nombre: clienteNombre,
            tipo: 'Cliente',
            email: clienteEmail || 'cliente@email.com',
            ultimaActividad: 'Hace 2 min',
            ip: '192.168.1.100',
            estado: 'online'
        });
    }
    
    // Agregar algunos usuarios simulados adicionales
    onlineUsers.push(
        {
            id: 101,
            nombre: 'María García',
            tipo: 'Cliente',
            email: 'maria@email.com',
            ultimaActividad: 'Hace 5 min',
            ip: '192.168.1.105',
            estado: 'online'
        },
        {
            id: 102,
            nombre: 'Juan Pérez',
            tipo: 'Cliente',
            email: 'juan@email.com',
            ultimaActividad: 'Hace 15 min',
            ip: '10.0.0.50',
            estado: 'online'
        }
    );
    
    renderOnlineUsers();
}

function renderOnlineUsers() {
    const tbody = document.getElementById('online-users-tbody');
    const adminCount = document.getElementById('admin-count');
    const clienteCount = document.getElementById('cliente-count');
    const totalCount = document.getElementById('total-count');
    
    if (!tbody) return;
    
    // Contar por tipo
    const admins = onlineUsers.filter(u => u.tipo === 'Administrador').length;
    const clientes = onlineUsers.filter(u => u.tipo === 'Cliente').length;
    
    // Actualizar contadores
    if (adminCount) adminCount.textContent = admins;
    if (clienteCount) clienteCount.textContent = clientes;
    if (totalCount) totalCount.textContent = onlineUsers.length;
    
    // Limpiar tabla
    tbody.innerHTML = '';
    
    if (onlineUsers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-8 text-gray-400">
                    <i class="fa-solid fa-users-slash text-4xl mb-4"></i>
                    <p>No hay usuarios en línea</p>
                </td>
            </tr>
        `;
        return;
    }
    
    // Renderizar usuarios
    onlineUsers.forEach((user, index) => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-[#1a1a1a] transition-colors';
        
        const tipoBadge = user.tipo === 'Administrador' 
            ? '<span class="px-2 py-1 text-xs bg-red-600 text-white rounded">Admin</span>'
            : '<span class="px-2 py-1 text-xs bg-green-600 text-white rounded">Cliente</span>';
        
        tr.innerHTML = `
            <td class="px-4 py-2">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-white font-semibold">${user.nombre}</span>
                </div>
            </td>
            <td class="px-4 py-2">${tipoBadge}</td>
            <td class="px-4 py-2 text-gray-300">${user.email}</td>
            <td class="px-4 py-2 text-gray-300">${user.ultimaActividad}</td>
            <td class="px-4 py-2 text-gray-300">${user.ip}</td>
            <td class="px-4 py-2">
                <div class="flex gap-2">
                    <button onclick="viewUserDetails('${user.id}')" 
                        class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    ${user.tipo === 'Cliente' ? `
                        <button onclick="disconnectUser('${user.id}')" 
                            class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    ` : ''}
                </div>
            </td>
        `;
        
        tbody.appendChild(tr);
    });
}

function viewUserDetails(userId) {
    const user = onlineUsers.find(u => u.id == userId);
    if (user) {
        alert(`Detalles del usuario:\n\nNombre: ${user.nombre}\nTipo: ${user.tipo}\nEmail: ${user.email}\nÚltima actividad: ${user.ultimaActividad}\nIP: ${user.ip}`);
    }
}

function disconnectUser(userId) {
    if (confirm('¿Estás seguro de que deseas desconectar a este usuario?')) {
        // Simular desconexión
        onlineUsers = onlineUsers.filter(u => u.id != userId);
        renderOnlineUsers();
        
        // En producción aquí harías una llamada a la API para cerrar la sesión del usuario
        console.log(`Usuario ${userId} desconectado`);
        alert('Usuario desconectado correctamente');
    }
}

// Cargar usuarios al mostrar la sección
document.addEventListener('DOMContentLoaded', function() {
    // Auto-actualizar cada 30 segundos
    setInterval(loadOnlineUsers, 30000);
});

// Botón de actualizar manual
document.getElementById('refresh-online-users')?.addEventListener('click', loadOnlineUsers);

// Hacer funciones globales
window.viewUserDetails = viewUserDetails;
window.disconnectUser = disconnectUser;
window.loadOnlineUsers = loadOnlineUsers;
</script>