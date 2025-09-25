document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const errorDiv = document.getElementById('register-error');
    const successDiv = document.getElementById('register-success');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Ocultar mensajes previos
    errorDiv.style.display = 'none';
    successDiv.style.display = 'none';
    
    // Deshabilitar botón
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Creando cuenta...';

    const formData = {
        nombre: document.getElementById('nombre').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        telefono: document.getElementById('telefono').value,
        direccion: document.getElementById('direccion').value,
        estado: true
    };

    try {
        const response = await fetch('/api/clientes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            successDiv.innerHTML = '¡Cuenta creada exitosamente! Bienvenido a DobleRock';
            successDiv.style.display = 'block';
            
            // Limpiar formulario
            document.getElementById('registerForm').reset();
            
            // Redirigir al home después de 2 segundos
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
            
        } else {
            let errorMessage = 'Error al crear la cuenta';
            
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
        // Rehabilitar botón
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fa-solid fa-user-plus mr-2"></i>Crear cuenta';
    }
});