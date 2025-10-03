   document.addEventListener('DOMContentLoaded', function() {
        const clienteId = localStorage.getItem('cliente_id');
        const clienteNombre = localStorage.getItem('cliente_nombre');

        // Elementos desktop
        const userDropdownBtn = document.getElementById('user-dropdown-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userDropdownText = document.getElementById('user-dropdown-text');
        const userNameDropdown = document.getElementById('user-name-dropdown');
        const guestOptions = document.getElementById('guest-options');
        const loggedOptions = document.getElementById('logged-options');
        const logoutBtn = document.getElementById('logout-btn');

        // Elementos móvil
        const userMobileBtn = document.getElementById('user-mobile-btn');
        const userMobileDropdown = document.getElementById('user-mobile-dropdown');
        const userNameMobile = document.getElementById('user-name-mobile');
        const guestMobileOptions = document.getElementById('guest-mobile-options');
        const loggedMobileOptions = document.getElementById('logged-mobile-options');
        const logoutMobileBtn = document.getElementById('logout-mobile-btn');

        // Función para actualizar la interfaz según el estado de login
        function updateUserInterface() {
            if (clienteId && clienteNombre) {
                // Usuario logueado
                if (userDropdownText) userDropdownText.textContent = clienteNombre;
                if (userNameDropdown) userNameDropdown.textContent = clienteNombre;
                if (userNameMobile) userNameMobile.textContent = clienteNombre;

                if (guestOptions) guestOptions.classList.add('hidden');
                if (loggedOptions) loggedOptions.classList.remove('hidden');
                if (guestMobileOptions) guestMobileOptions.classList.add('hidden');
                if (loggedMobileOptions) loggedMobileOptions.classList.remove('hidden');
            } else {
                // Usuario no logueado
                if (userDropdownText) userDropdownText.textContent = 'Mi Cuenta';

                if (guestOptions) guestOptions.classList.remove('hidden');
                if (loggedOptions) loggedOptions.classList.add('hidden');
                if (guestMobileOptions) guestMobileOptions.classList.remove('hidden');
                if (loggedMobileOptions) loggedMobileOptions.classList.add('hidden');
            }
        }

        updateUserInterface();

        // Toggle dropdown desktop
        if (userDropdownBtn && userDropdown) {
            userDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                if (userMobileDropdown) userMobileDropdown.classList.add('hidden');
            });
        }

        // Toggle dropdown móvil
        if (userMobileBtn && userMobileDropdown) {
            userMobileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMobileDropdown.classList.toggle('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
            });
        }

        // Cerrar dropdowns al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (userDropdown && !e.target.closest('#user-section')) {
                userDropdown.classList.add('hidden');
            }
            if (userMobileDropdown && !e.target.closest('#user-mobile-btn')) {
                userMobileDropdown.classList.add('hidden');
            }
        });

        // Logout
        function handleLogout() {
            if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                localStorage.removeItem('cliente_id');
                localStorage.removeItem('cliente_nombre');
                localStorage.removeItem('cliente_email');
                window.location.reload();
            }
        }

        if (logoutBtn) logoutBtn.addEventListener('click', handleLogout);
        if (logoutMobileBtn) logoutMobileBtn.addEventListener('click', handleLogout);
    });


    // Mostrar u ocultar perfil / registro al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const clienteId = localStorage.getItem('cliente_id');
        const clienteNombre = localStorage.getItem('cliente_nombre');

        const registerLink = document.getElementById('register-link');
        const userProfile = document.getElementById('user-profile');
        const userName = document.getElementById('user-name');

        const registerLinkMobile = document.getElementById('register-link-mobile');
        const userProfileMobile = document.getElementById('user-profile-mobile');

        if (clienteId && clienteNombre) {
            if (registerLink) registerLink.style.display = 'none';
            if (userProfile) {
                userProfile.classList.remove('hidden');
                userProfile.style.display = 'flex';
            }
            if (userName) userName.textContent = clienteNombre;

            if (registerLinkMobile) registerLinkMobile.style.display = 'none';
            if (userProfileMobile) {
                userProfileMobile.classList.remove('hidden');
                userProfileMobile.style.display = 'flex';
            }
        } else {
            if (registerLink) registerLink.style.display = 'flex';
            if (userProfile) userProfile.classList.add('hidden');
            if (registerLinkMobile) registerLinkMobile.style.display = 'flex';
            if (userProfileMobile) userProfileMobile.classList.add('hidden');
        }
    });