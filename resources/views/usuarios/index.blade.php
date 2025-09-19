<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    @include('usuarios._tabla')
    <script>
    function cargarUsuarios() {
        fetch('/api/usuarios')
            .then(response => response.json())
            .then(usuarios => {
                const tbody = document.querySelector('#usuariosTable tbody');
                tbody.innerHTML = '';
                usuarios.forEach(usuario => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${usuario.id}</td>
                        <td>${usuario.nombre}</td>
                        <td>${usuario.email}</td>
                        <td>${usuario.rol || ''}</td>
                        <td>${usuario.estado ? 'Activo' : 'Inactivo'}</td>
                        <td>${usuario.fecha_creacion || ''}</td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    document.addEventListener('DOMContentLoaded', cargarUsuarios);
    </script>
</body>
</html>
