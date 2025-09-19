        document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorDiv = document.getElementById('login-error');
        errorDiv.style.display = 'none';
        errorDiv.innerText = '';

        try {
        const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
        },
        body: JSON.stringify({
        email,
        password
        })
        });

        const data = await response.json();
        if (response.ok) {
        // Aquí puedes guardar el usuario/token en localStorage o redirigir
        window.location.href = '/dashboard';
        } else {
        errorDiv.innerText = data.message || 'Credenciales incorrectas';
        errorDiv.style.display = 'block';
        }
        } catch (err) {
        errorDiv.innerText = 'Error de red o del servidor';
        errorDiv.style.display = 'block';
        }
        });
