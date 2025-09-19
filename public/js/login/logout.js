document.getElementById('logout-btn').addEventListener('click', async function() {
            try {
                // Si tienes un endpoint API para logout:
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        // Si usas token, agrega aquí el Authorization
                    },
                    // Si necesitas enviar token/csrf, agrégalo aquí
                });
            } catch (e) {
                // Ignorar errores de red
            }
            // Limpia la sesión del lado del cliente y redirige
            window.location.href = '/login';
        });