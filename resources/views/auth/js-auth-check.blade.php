<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificando acceso...</title>
    <style>
        body { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
        }
        .loading { 
            text-align: center; 
            background: rgba(0,0,0,0.5);
            padding: 40px;
            border-radius: 10px;
        }
        .spinner { 
            border: 4px solid #333; 
            border-top: 4px solid #e7452e; 
            border-radius: 50%; 
            width: 50px; 
            height: 50px; 
            animation: spin 1s linear infinite; 
            margin: 0 auto 20px;
        }
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
    </style>
</head>
<body>
    <div class="loading">
        <div class="spinner"></div>
        <div>Verificando permisos de acceso...</div>
    </div>

    <script>
        (function() {
            const token = localStorage.getItem('auth_token');
            const userData = localStorage.getItem('user_data');
            const requiredRole = '{{ $required_role }}';
            const targetUrl = '{{ $target_url }}';
            
            console.log('Verificando acceso...');

            if (!token || !userData) {
                console.log('No hay token, redirigiendo al login');
                window.location.href = '/login';
                return;
            }

            try {
                const user = JSON.parse(userData);
                
                // Verificar rol
                if (requiredRole === 'admin' && user.rol !== 1) {
                    alert('No tienes permisos de administrador');
                    window.location.href = '/';
                    return;
                }

                if (requiredRole === 'cliente' && user.rol !== 2) {
                    alert('No tienes permisos de cliente');
                    window.location.href = '/';
                    return;
                }

                // Verificar token con API
                fetch('/api/usuarios', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Token válido, accediendo...');
                        // Redirigir con parámetro de bypass
                        window.location.href = targetUrl + '?verified=true';
                    } else {
                        console.log('Token inválido');
                        localStorage.clear();
                        window.location.href = '/login';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = '/login';
                });

            } catch (error) {
                console.error('Error procesando datos:', error);
                localStorage.clear();
                window.location.href = '/login';
            }
        })();
    </script>
</body>
</html>