// Obtener datos del administrador actual
function getUserIdFromStorage() {
    try {
        const userData = localStorage.getItem('user_data');
        if (!userData) return null;
        const parsed = JSON.parse(userData);
        return parsed && parsed.id ? parsed.id : null;
    } catch (e) {
        return null;
    }
}

function getAuthTokenFromStorage() {
    try {
        // claves explícitas que ya usas en otras partes del frontend
        const explicit = localStorage.getItem('auth_token') || localStorage.getItem('token') || localStorage.getItem('access_token');
        if (explicit) return explicit;

        // fallback a user_data JSON
        const userData = localStorage.getItem('user_data');
        if (!userData) return null;
        const parsed = JSON.parse(userData);
        return parsed.token || parsed.api_token || parsed.access_token || null;
    } catch (e) {
        return null;
    }
}

async function ensureCsrf() {
    // Para Laravel Sanctum: solicita la cookie csrf antes de llamadas stateful
    try {
        await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });
    } catch (e) {
        console.warn('No se pudo obtener CSRF cookie:', e);
    }
}

async function loadAdminProfile() {
    try {
        const errorDiv = document.getElementById('profile-error');
        const successDiv = document.getElementById('profile-success');

        const userId = window.USER_ID || getUserIdFromStorage();
        if (!userId) {
            errorDiv.textContent = 'Error: No se pudo obtener el ID del usuario';
            errorDiv.classList.remove('hidden');
            successDiv.classList.add('hidden');
            return;
        }

        const token = getAuthTokenFromStorage();

        // Si no hay token, intentar obtener CSRF cookie para sesión (Sanctum)
        if (!token) {
            await ensureCsrf();
        }

        const headers = { 'Accept': 'application/json' };
        if (token) headers['Authorization'] = `Bearer ${token}`;

        const response = await fetch(`/api/usuarios/${userId}`, {
            method: 'GET',
            headers,
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        const usuario = data.usuario || data;

        if (!usuario || !usuario.id) {
            throw new Error('Respuesta inválida del servidor');
        }

        // Llenar formulario
        const nombreEl = document.getElementById('admin-nombre');
        const emailEl = document.getElementById('admin-email');
        const fechaEl = document.getElementById('admin-fecha-creacion');
        const idEl = document.getElementById('admin-user-id');

        if (nombreEl) nombreEl.value = usuario.nombre || '';
        if (emailEl) emailEl.value = usuario.email || '';
        if (fechaEl) fechaEl.textContent = usuario.created_at ? new Date(usuario.created_at).toLocaleDateString() : '';
        if (idEl) idEl.textContent = usuario.id;

        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');

    } catch (error) {
        console.error('Error al cargar perfil:', error);
        const errorDiv = document.getElementById('profile-error');
        if (error.message && error.message.includes('HTTP 401')) {
            errorDiv.textContent = 'No autorizado (401). Inicia sesión o proporciona token válido.';
        } else {
            errorDiv.textContent = 'Error al cargar los datos del perfil';
        }
        errorDiv.classList.remove('hidden');
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

            const userId = window.USER_ID || getUserIdFromStorage();

            if (!userId) {
                errorDiv.textContent = 'Error: No se pudo obtener el ID del usuario';
                errorDiv.classList.remove('hidden');
                return;
            }

            const password = document.getElementById('admin-password').value;
            const passwordConfirm = document.getElementById('admin-password-confirm').value;

            if (password && password !== passwordConfirm) {
                errorDiv.textContent = 'Las contraseñas no coinciden';
                errorDiv.classList.remove('hidden');
                return;
            }

            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');

            submitBtn.disabled = true;
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Actualizando...';

            const formData = {
                nombre: document.getElementById('admin-nombre').value,
                email: document.getElementById('admin-email').value
            };

            if (password && password.trim()) {
                formData.password = password;
            }

            try {
                const token = getAuthTokenFromStorage();
                if (!token) await ensureCsrf();

                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                };
                if (token) headers['Authorization'] = `Bearer ${token}`;

                const response = await fetch(`/api/usuarios/${userId}`, {
                    method: 'PUT',
                    headers,
                    credentials: 'same-origin',
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    successDiv.textContent = 'Perfil actualizado correctamente';
                    successDiv.classList.remove('hidden');
                    document.getElementById('admin-password').value = '';
                    document.getElementById('admin-password-confirm').value = '';
                    setTimeout(() => { location.reload(); }, 1200);
                } else {
                    let errorMessage = 'Error al actualizar el perfil';
                    if (data && data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    } else if (data && data.message) {
                        errorMessage = data.message;
                    }
                    errorDiv.textContent = errorMessage;
                    errorDiv.classList.remove('hidden');
                }

            } catch (error) {
                console.error('Error actualización:', error);
                errorDiv.textContent = error.message && error.message.includes('401') ? 'No autorizado. Inicia sesión.' : 'Error de conexión. Inténtalo de nuevo.';
                errorDiv.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });

        const refreshBtn = document.getElementById('refresh-profile-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', loadAdminProfile);
        }

        loadAdminProfile();
    }
});

// Hacer función global para el dashboard
window.loadAdminProfile = loadAdminProfile;
