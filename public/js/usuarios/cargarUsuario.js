// Cargar usuarios solo cuando se muestre el panel de usuarios
function cargarUsuarios() {
    fetch('/api/usuarios')
        .then(response => response.json())
        .then(usuarios => {
            const tbody = document.querySelector('#usuariosTable tbody');
            tbody.innerHTML = '';
            usuarios.forEach(usuario => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-[#232323] transition";
                tr.innerHTML = `
                    <td class="px-4 py-2">${usuario.id}</td>
                    <td class="px-4 py-2">${usuario.nombre}</td>
                    <td class="px-4 py-2">${usuario.email}</td>
                    <td class="px-4 py-2">${usuario.rol || ''}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold ${usuario.estado ? 'bg-green-600' : 'bg-red-600'}">
                            ${usuario.estado ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td class="px-4 py-2">${usuario.fecha_creacion ? usuario.fecha_creacion.substring(0,10) : ''}</td>
                    <td class="px-4 py-2">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs mr-2 transition">
                            Editar
                        </button>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition">
                            Eliminar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
}

// Mostrar panel de usuarios y cargar la tabla
document.getElementById('menu-usuarios').addEventListener('click', function() {
    document.getElementById('panel-productos').classList.add('hidden');
    document.getElementById('panel-galeria').classList.add('hidden');
    document.getElementById('panel-usuarios').classList.remove('hidden');
    if (typeof cargarUsuarios === "function") {
        cargarUsuarios();
    }
});