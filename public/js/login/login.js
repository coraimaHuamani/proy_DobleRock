document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (!loginForm) {
        console.error('Formulario de login no encontrado');
        return;
    }

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('login-btn');
        const errorDiv = document.getElementById('login-error');
        
        console.log('=== INICIANDO LOGIN ===');
        
        // UI Loading
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Iniciando sesión...';
        errorDiv.classList.add('hidden');

        try {
            const formData = new FormData(this);
            const loginData = {
                email: formData.get('email'),
                password: formData.get('password')
            };
            
            console.log('Enviando datos:', loginData);
            
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin', // IMPORTANTE: Para que reciba las cookies
                body: JSON.stringify(loginData)
            });

            const data = await response.json();
            console.log('Respuesta del servidor:', data);

            if (response.ok && data.success) {
                console.log('✅ Login exitoso');
                
                // Solo guardar en localStorage
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user_data', JSON.stringify(data.user));
                
                console.log('✅ Datos guardados en localStorage');
                window.location.href = data.redirect_url;
                
            } else {
                console.error('❌ Error de login:', data);
                errorDiv.textContent = data.message || 'Error de autenticación';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('❌ Error de conexión:', error);
            errorDiv.textContent = 'Error de conexión con el servidor';
            errorDiv.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-sign-in-alt mr-2"></i>Iniciar Sesión';
        }
    });
});
