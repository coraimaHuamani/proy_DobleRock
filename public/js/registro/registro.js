document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = this;
    const errorDiv = document.getElementById('register-error');
    const successDiv = document.getElementById('register-success');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Ocultar mensajes previos
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    errorDiv.innerHTML = '';
    successDiv.innerHTML = '';

    // Validación básica client-side
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;

    if (!nombre || !email || !password) {
        errorDiv.innerHTML = 'Completa los campos obligatorios';
        errorDiv.classList.remove('hidden');
        return;
    }

    if (password.length < 6) {
        errorDiv.innerHTML = 'La contraseña debe tener al menos 6 caracteres';
        errorDiv.classList.remove('hidden');
        return;
    }

    if (password !== passwordConfirmation) {
        errorDiv.innerHTML = 'Las contraseñas no coinciden';
        errorDiv.classList.remove('hidden');
        return;
    }

    // Deshabilitar botón y mostrar loader
    submitBtn.disabled = true;
    const originalHtml = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Creando cuenta...';

    const payload = {
        nombre,
        email,
        password,
        password_confirmation: passwordConfirmation,
        telefono: document.getElementById('telefono').value.trim() || null,
        direccion: document.getElementById('direccion').value.trim() || null,
        estado: true,
        rol: 2 // cliente
    };

    // Priorizar la ruta pública de registro primero
    const endpoints = ['/api/register', '/register', '/api/usuarios'];

    try {
        let handled = false;

        for (const url of endpoints) {
            try {
                console.log('Intentando endpoint:', url);
                const isFormPost = url === '/register';
                const headers = { 'Accept': 'application/json' };
                let body;

                if (isFormPost) {
                    const fd = new FormData();
                    Object.keys(payload).forEach(k => {
                        if (payload[k] !== null && payload[k] !== undefined) fd.append(k, payload[k]);
                    });
                    const csrf = document.querySelector('input[name="_token"]')?.value;
                    if (csrf) headers['X-CSRF-TOKEN'] = csrf;
                    body = fd;
                } else {
                    headers['Content-Type'] = 'application/json';
                    body = JSON.stringify(payload);
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers,
                    body,
                    credentials: isFormPost ? 'same-origin' : 'omit'
                });

                // Si endpoint no existe o método no permitido, intentar siguiente
                if (response.status === 404 || response.status === 405) {
                    console.warn(`Endpoint ${url} devuelve ${response.status}, probando siguiente.`);
                    continue;
                }

                // Intentar parsear json (si falla, data quedará null)
                let data = null;
                try { data = await response.json(); } catch (err) { data = null; }

                // Si devuelve 401 / Unaunthenticated -> mostrar mensaje claro y no seguir
                if (response.status === 401 || (data && (data.message?.toLowerCase?.().includes('unauth') || data === 'Unauthenticated'))) {
                    errorDiv.innerHTML = 'Registro público deshabilitado en esta API. Usa la ruta web de registro o contacta al administrador.';
                    errorDiv.classList.remove('hidden');
                    console.warn('Respuesta 401/Unauthenticated de', url, data);
                    handled = true;
                    break;
                }

                // Manejo según status
                if (response.ok) {
                    console.log('Registro OK:', data);
                    successDiv.innerHTML = '¡Cuenta creada exitosamente! Redirigiendo...';
                    successDiv.classList.remove('hidden');

                    const usuario = data?.usuario || data || null;
                    if (usuario && usuario.id) {
                        localStorage.setItem('cliente_id', usuario.id);
                        localStorage.setItem('cliente_nombre', usuario.nombre || '');
                    }

                    if (data?.token) localStorage.setItem('auth_token', data.token);
                    if (data?.usuario) localStorage.setItem('user_data', JSON.stringify(data.usuario));

                    form.reset();
                    setTimeout(() => { window.location.href = '/'; }, 1200);
                    handled = true;
                    break;
                } else {
                    // 422 -> validación; mostrar mensajes detallados
                    if (response.status === 422 && data?.errors) {
                        const errorMessage = Object.values(data.errors).flat().join(', ');
                        errorDiv.innerHTML = errorMessage;
                        errorDiv.classList.remove('hidden');
                        console.warn('Validación:', data.errors);
                        handled = true;
                        break;
                    }

                    // Mostrar mensaje devuelto por el servidor si existe
                    let errorMessage = data?.message || `Error al crear la cuenta (${response.status})`;

                    // Si la respuesta no es JSON, intentar obtener texto
                    if (!data) {
                        try { errorMessage = await response.text(); } catch (tErr) { /* ignore */ }
                    }

                    errorDiv.innerHTML = errorMessage;
                    errorDiv.classList.remove('hidden');
                    console.warn(`Error en ${url}:`, response.status, data || errorMessage);
                    handled = true;
                    break;
                }

            } catch (innerErr) {
                // Error de red en este intento: continuar a siguiente endpoint
                console.warn(`Error probando endpoint ${url}:`, innerErr);
                continue;
            }
        }

        if (!handled) {
            errorDiv.innerHTML = 'No se encontró un endpoint de registro disponible en el servidor.';
            errorDiv.classList.remove('hidden');
        }

    } catch (err) {
        console.error('Registro error:', err);
        errorDiv.innerHTML = 'Error de conexión. Inténtalo de nuevo.';
        errorDiv.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;
    }
});
