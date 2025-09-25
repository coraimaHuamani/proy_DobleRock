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
                    
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                        const csrfValue = csrfToken ? csrfToken.getAttribute('content') : '';
                        
                        console.log('🔑 CSRF Token:', csrfValue);
                        
                        const response = await fetch('/logout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                            },
                            body: `_token=${encodeURIComponent(csrfValue)}`,
                            redirect: 'follow' // Seguir redirects automáticamente
                        });
                        
                        console.log('📡 Respuesta logout:', response.status, response.url);
                        
                        // Sin importar la respuesta, redirigir al home
                        console.log('✅ Redirigiendo al home...');
                        window.location.href = '/';
                        
                    } catch (error) {
                        console.error('❌ Error en fetch logout:', error);
                        
                        // FALLBACK: Redirigir directamente al home
                        console.log('🔄 Error en logout, pero redirigiendo al home de todas formas...');
                        window.location.href = '/';
                    }
                } else {
                    console.log('❌ Usuario canceló logout');
                }
            });
            
            console.log('✅ Event listener configurado');
        } else {
            console.error('❌ Botón logout del SIDEBAR NO encontrado');
            
            if (allLogoutBtns.length > 0) {
                const firstBtn = allLogoutBtns[0];
                const newBtn = firstBtn.cloneNode(true);
                firstBtn.parentNode.replaceChild(newBtn, firstBtn);
                
                newBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (confirm('¿Cerrar sesión?')) {
                        window.location.href = '/';
                    }
                });
            }
        }
    }, 500);
});