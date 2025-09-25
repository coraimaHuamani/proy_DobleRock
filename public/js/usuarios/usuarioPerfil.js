// Obtener datos del administrador actual
async function loadAdminProfile() {
    try {
        const userId = window.USER_ID;
        const errorDiv = document.getElementById('profile-error');

        if (!userId) {
            errorDiv.innerHTML = 'Error: No se pudo obtener el ID del usuario';
            errorDiv.style.display = 'block';
            return;
        }

        const response = await fetch(`/api/usuarios/${userId}`);
        if (!response.ok) throw new Error('Error al cargar datos del perfil');

        const usuario = await response.json();

        // Llenar formulario
        document.getElementById('admin-nombre').value = usuario.nombre;
        document.getElementById('admin-email').value = usuario.email;
        document.getElementById('admin-fecha-creacion').textContent = new Date(usuario.fecha_creacion).toLocaleDateString();
        document.getElementById('admin-user-id').textContent = usuario.id;

    } catch (error) {
        console.error('Error:', error);
        const errorDiv = document.getElementById('profile-error');
        errorDiv.innerHTML = 'Error al cargar los datos del perfil';
        errorDiv.style.display = 'block';
    }
}

// Actualizar perfil de administrador
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('admin-profile-form');
    
    if (profileForm) {
        profileForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const errorDiv = document.getElementById('profile-error');
            const successDiv = document.getElementById('profile-success');
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const userId = window.USER_ID;

            if (!userId) {
                errorDiv.innerHTML = 'Error: No se pudo obtener el ID del usuario';
                errorDiv.style.display = 'block';
                return;
            }

            // Validar contraseñas
            const password = document.getElementById('admin-password').value;
            const passwordConfirm = document.getElementById('admin-password-confirm').value;

            if (password && password !== passwordConfirm) {
                errorDiv.innerHTML = 'Las contraseñas no coinciden';
                errorDiv.style.display = 'block';
                return;
            }

            // Ocultar mensajes previos
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';

            // Deshabilitar botón
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Actualizando...';

            const formData = {
                nombre: document.getElementById('admin-nombre').value,
                email: document.getElementById('admin-email').value
            };

            if (password.trim()) {
                formData.password = password;
            }

            try {
                const response = await fetch(`/api/usuarios/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    successDiv.innerHTML = 'Perfil actualizado correctamente';
                    successDiv.style.display = 'block';

                    // Limpiar campos de contraseña
                    document.getElementById('admin-password').value = '';
                    document.getElementById('admin-password-confirm').value = '';

                    // Recargar si cambió el nombre para actualizar sesión
                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                } else {
                    let errorMessage = 'Error al actualizar el perfil';
                    
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    } else if (data.message) {
                        errorMessage = data.message;
                    }
                    
                    errorDiv.innerHTML = errorMessage;
                    errorDiv.style.display = 'block';
                }

            } catch (error) {
                errorDiv.innerHTML = 'Error de conexión. Inténtalo de nuevo.';
                errorDiv.style.display = 'block';
                console.error('Error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Actualizar Perfil';
            }
        });

        // Botón de recargar
        const refreshBtn = document.getElementById('refresh-profile-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', loadAdminProfile);
        }

        // Cargar perfil automáticamente
        loadAdminProfile();
    }
});

// Hacer función global para el dashboard
window.loadAdminProfile = loadAdminProfile;
