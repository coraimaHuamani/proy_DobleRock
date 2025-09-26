document.addEventListener('DOMContentLoaded', () => {
    console.log('🔧 Script logout.js cargado');
    
    setTimeout(() => {
        const sidebarLogoutBtn = document.querySelector('#dashboard-sidebar #logout-btn');
        const allLogoutBtns = document.querySelectorAll('#logout-btn');
        
        console.log('🔍 Total botones logout encontrados:', allLogoutBtns.length);
        console.log('🎯 Botón sidebar logout encontrado:', sidebarLogoutBtn);
        
        if (sidebarLogoutBtn) {
            const newBtn = sidebarLogoutBtn.cloneNode(true);
            sidebarLogoutBtn.parentNode.replaceChild(newBtn, sidebarLogoutBtn);
            
            newBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('✅ Click en logout del SIDEBAR detectado');
                
                if (confirm('¿Cerrar sesión?')) {
                    console.log('👤 Usuario confirmó logout');
                    
                    // Deshabilitar botón durante el proceso
                    newBtn.disabled = true;
                    newBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Cerrando...';
                    
                    try {
                        const token = localStorage.getItem('auth_token');
                        
                        if (token) {
                            console.log('🔑 Token encontrado, enviando logout al servidor...');
                            
                            const response = await fetch('/api/logout', {
                                method: 'POST',
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });
                            
                            console.log('📡 Respuesta logout:', response.status);
                            
                            if (response.ok) {
                                const data = await response.json();
                                console.log('✅ Logout exitoso:', data.message);
                            } else {
                                console.warn('⚠️ Error en logout del servidor, pero continuando...');
                            }
                        } else {
                            console.log('❌ No hay token, logout local solamente');
                        }
                        
                        // Limpiar datos locales
                        localStorage.removeItem('auth_token');
                        localStorage.removeItem('user_data');
                        document.cookie = 'auth_token=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        
                        console.log('🧹 Datos locales y cookies limpiados');
                        console.log('🔄 Redirigiendo al login...');
                        
                        // Redirigir al login
                        window.location.href = '/login';
                        
                    } catch (error) {
                        console.error('❌ Error en logout:', error);
                        
                        // Aunque haya error, limpiar datos locales
                        localStorage.removeItem('auth_token');
                        localStorage.removeItem('user_data');
                        document.cookie = 'auth_token=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        
                        console.log('🔄 Error en logout, pero limpiando datos y redirigiendo...');
                        window.location.href = '/login';
                    }
                } else {
                    console.log('❌ Usuario canceló logout');
                }
            });
            
            console.log('✅ Event listener configurado para API logout');
        } else {
            console.error('❌ Botón logout del SIDEBAR NO encontrado');
            
            // Fallback para cualquier botón logout encontrado
            if (allLogoutBtns.length > 0) {
                const firstBtn = allLogoutBtns[0];
                const newBtn = firstBtn.cloneNode(true);
                firstBtn.parentNode.replaceChild(newBtn, firstBtn);
                
                newBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    if (confirm('¿Cerrar sesión?')) {
                        // Limpiar datos locales
                        localStorage.removeItem('auth_token');
                        localStorage.removeItem('user_data');
                        document.cookie = 'auth_token=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        window.location.href = '/login';
                    }
                });
            }
        }
    }, 500);
});