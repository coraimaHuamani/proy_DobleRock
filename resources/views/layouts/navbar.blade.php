<!-- Logo y reproductor -->
<div class="bg-[#000000]">
    <div
        class="max-w-[1200px] mx-auto p-2 flex flex-col md:flex-row items-center justify-center md:justify-between w-full gap-4">

        <!-- Logo -->
        <div class="flex items-center mb-2 md:mb-0">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="w-12 h-12 object-contain mr-3" />
            <div class="flex flex-col md:mr-6">
                <span class="text-white font-bold text-xl leading-tight">DOBLE</span>
                <span class="text-[#e7452e] font-bold text-xl leading-tight">ROCK</span>
            </div>
        </div>

        <!-- Reproductor de música -->
        <div
            class="bg-[#232323] rounded-full flex items-center px-3 py-2 shadow-lg space-x-2 w-full max-w-md h-[54px] md:ml-0">

            <!-- Info de canción (puede ser estática o dinámica) -->
            <div class="flex flex-col justify-center flex-1 min-w-0">
                <span class="text-white font-bold text-sm block leading-tight">Radio en vivo</span>
                <span class="text-gray-300 text-xs truncate">DOBLE ROCK</span>
            </div>

            <!-- Botón play/pause -->
            <button id="playBtn"
                class="bg-[#e7452e] hover:bg-orange-600 text-white w-8 h-8 flex items-center justify-center rounded-full"
                aria-label="Play">
                <i id="playIcon" class="fa-solid fa-play"></i>
            </button>

            <!-- Progreso (opcional, en vivo no aplica mucho) -->
            <div class="w-16 h-1 bg-gray-600 rounded-full overflow-hidden">
                <div class="h-1 bg-[#e7452e] w-2/3"></div>
            </div>

            <!-- Audio oculto -->
            <audio id="radioPlayer">
                <source src="http://109.169.15.21:37873/;stream.mp3" type="audio/mpeg">
            </audio>
        </div>


    </div>
</div>

<!-- Contenedor general con fondo -->
<nav class="bg-[#000000] text-white">
    <div class="max-w-[1200px] mx-auto px-6 py-3 flex items-center justify-between">

        {{-- ENLACES IZQUIERDA --}}
        <ul class="hidden md:flex space-x-6 font-semibold uppercase text-sm">
            <li>
                <a href="/"
                    class="hover:text-[#e7452e] {{ request()->is('/') ? 'text-[#e7452e]' : '' }}">Inicio</a>
            </li>
            <li>
                <a href="{{ route('tienda') }}"
                    class="hover:text-[#e7452e] {{ request()->is('tienda') ? 'text-[#e7452e]' : '' }}">Tienda</a>
            </li>
            <li>
                <a href="/musica"
                    class="hover:text-[#e7452e] {{ request()->is('musica') ? 'text-[#e7452e]' : '' }}">Música</a>
            </li>
            <li>
                <a href="{{ route('noticias') }}"
                    class="hover:text-[#e7452e] {{ request()->is('noticias') ? 'text-[#e7452e]' : '' }}">Noticias</a>
            </li>
            <li>
                <a href="{{ route('galeria') }}"
                    class="hover:text-[#e7452e] {{ request()->is('galeria') ? 'text-[#e7452e]' : '' }}">GALERÍA</a>
            </li>
        </ul>

        {{-- DERECHA: buscador + iconos --}}
        <div class="hidden md:flex items-center space-x-4">
            <!-- Dropdown de usuario -->
            <div id="user-section" class="relative">
                <button id="user-dropdown-btn"
                    class="flex items-center gap-1 text-white hover:text-[#e7452e] px-2 py-1 rounded transition">
                    <i class="fa-solid fa-user-circle text-lg"></i>
                    <span id="user-dropdown-text"
                        class="hidden md:inline font-semibold uppercase text-xs tracking-widest">Mi Cuenta</span>
                    <i class="fa-solid fa-chevron-down ml-1"></i>
                </button>

                <!-- Dropdown menu -->
                <div id="user-dropdown"
                    class="hidden absolute right-0 top-full mt-2 w-56 bg-[#181818] border border-[#232323] rounded-lg shadow-lg z-50">
                    <!-- Para usuarios no logueados -->
                    <div id="guest-options" class="p-2">
                        <a href="/login"
                            class="block w-full px-3 py-2 text-left text-white hover:bg-[#232323] rounded transition">
                            <i class="fa-solid fa-sign-in-alt mr-2 text-[#e7452e]"></i>Iniciar Sesión
                        </a>
                        <a href="/register"
                            class="block w-full px-3 py-2 text-left text-white hover:bg-[#232323] rounded transition">
                            <i class="fa-solid fa-user-plus mr-2 text-[#e7452e]"></i>Registrarse
                        </a>
                    </div>

                    <!-- Para usuarios logueados (oculto inicialmente) -->
                    <div id="logged-options" class="hidden">
                        <div class="p-3 border-b border-[#232323]">
                            <p class="text-white font-semibold text-sm">¡Hola!</p>
                            <p id="user-name-dropdown" class="text-[#e7452e] text-xs font-mono truncate"></p>
                        </div>
                        <div class="p-2">
                            <a href="/perfil"
                                class="block w-full px-3 py-2 text-left text-white hover:bg-[#232323] rounded transition">
                                <i class="fa-solid fa-user-edit mr-2 text-[#e7452e]"></i>Mi Perfil
                            </a>
                            <button id="logout-btn"
                                class="w-full px-3 py-2 text-left text-red-400 hover:bg-[#232323] rounded transition mt-1">
                                <i class="fa-solid fa-sign-out-alt mr-2"></i>Cerrar Sesión
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARRITO --}}
            <div class="relative">
                <button id="open-cart" class="text-white hover:text-[#e7452e] flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count"
                        class="inline-flex items-center justify-center text-xs bg-[#e7452e] rounded-full w-5 h-5">0</span>
                </button>
            </div>
        </div>

        {{-- BOTÓN HAMBURGUESA MOBILE --}}
        <div class="md:hidden">
            <div class="flex items-center gap-2">
                <button id="menu-btn" class="focus:outline-none text-white hover:text-[#e7452e]">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>

                <!-- Usuario móvil -->
                <div id="user-mobile" class="relative">
                    <!-- Para clientes no logueados -->
                    <a href="/register" id="register-link-mobile"
                        class="text-white hover:text-[#e7452e] flex items-center">
                        <i class="fa-solid fa-user"></i>
                    </a>

                    <!-- Para clientes logueados móvil -->
                    <a href="/perfil" id="user-profile-mobile"
                        class="hidden text-white hover:text-[#e7452e] flex items-center">
                        <i class="fa-solid fa-user-circle text-lg"></i>
                    </a>
                </div>

                <button id="open-cart-mobile" class="text-white hover:text-[#e7452e] flex items-center gap-1">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count-mobile"
                        class="inline-flex items-center justify-center text-xs bg-[#e7452e] rounded-full w-5 h-5">0</span>
                </button>
            </div>
        </div>

    </div>

    {{-- PANEL DEL CARRITO (dropdown/side minimalista) --}}
    <div id="cart-panel" class="hidden">
        <div class="fixed inset-0 bg-black/50 z-40"></div>
        <div
            class="fixed right-0 top-0 h-full w-full sm:w-[380px] bg-[#0f0f0f] z-50 shadow-2xl border-l border-[#232323]">
            <div class="p-4 border-b border-[#232323] flex items-center justify-between">
                <h3 class="font-bold text-lg">Tu carrito</h3>
                <button id="close-cart" class="text-gray-300 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-4">
                <ul id="cart-items" class="divide-y divide-[#232323]"></ul>
            </div>
            <div class="p-4 border-t border-[#232323]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-300">Total</span>
                    <span id="cart-total" class="font-bold">S/ 0.00</span>
                </div>
                <button id="checkout-btn"
                    class="w-full bg-[#e7452e] hover:bg-[#cf3d28] text-white rounded-lg py-2 text-sm">
                    Finalizar compra
                </button>
                <script>
                    // Redirigir a login al finalizar compra
                    document.addEventListener('DOMContentLoaded', function() {
                        var checkoutBtn = document.getElementById('checkout-btn');
                        if (checkoutBtn) {
                            checkoutBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                window.location.href = '/login';
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</nav>


<!-- Línea naranja debajo del navbar -->
<div class="w-full h-1 bg-[#e7452e]"></div>

<!-- MENÚ LATERAL MOBILE -->
<div id="mobile-menu"
    class="fixed top-0 left-0 h-full w-64 bg-[#181818] text-white transform -translate-x-full transition-transform duration-300 z-50 shadow-2xl border-r-4 border-[#e7452e]">
    <div class="px-6 py-4">
        <div class="flex justify-end">
            <button id="close-menu" class="mb-4 text-[#e7452e] focus:outline-none text-2xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <ul class="space-y-6 mt-4 font-semibold uppercase text-base">
            <li>
                <a href="/"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('/') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-house text-[#e7452e]"></i> Inicio
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('tienda') }}"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('tienda') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-store text-[#e7452e]"></i> Tienda
                    </div>
                </a>
            </li>
            <li>
                <a href="/musica"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('musica') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-music text-[#e7452e]"></i> Música
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('noticias') }}"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('noticias') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-[#e7452e]"></i> Noticias
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('galeria') }}"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('galeria') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-image text-[#e7452e]"></i> Galería
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<!-- Script para el carrito -->
<script src="{{ asset('js/carrito/carrito.js') }}"></script>

<!-- Script para el reproductor de audio -->
<script src="{{ asset('js/reproductor/reproductor.js') }}"></script>

<script>
    // Gestión del dropdown de usuario
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

                // Mostrar opciones de usuario logueado
                if (guestOptions) guestOptions.classList.add('hidden');
                if (loggedOptions) loggedOptions.classList.remove('hidden');
                if (guestMobileOptions) guestMobileOptions.classList.add('hidden');
                if (loggedMobileOptions) loggedMobileOptions.classList.remove('hidden');
            } else {
                // Usuario no logueado
                if (userDropdownText) userDropdownText.textContent = 'Mi Cuenta';

                // Mostrar opciones de invitado
                if (guestOptions) guestOptions.classList.remove('hidden');
                if (loggedOptions) loggedOptions.classList.add('hidden');
                if (guestMobileOptions) guestMobileOptions.classList.remove('hidden');
                if (loggedMobileOptions) loggedMobileOptions.classList.add('hidden');
            }
        }

        // Inicializar interfaz
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

        // Funciones de logout
        function handleLogout() {
            if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                localStorage.removeItem('cliente_id');
                localStorage.removeItem('cliente_nombre');
                window.location.reload();
            }
        }

        if (logoutBtn) logoutBtn.addEventListener('click', handleLogout);
        if (logoutMobileBtn) logoutMobileBtn.addEventListener('click', handleLogout);
    });

    // Auto-login cuando viene del registro/login exitoso
    @if (session('cliente_login'))
        const clienteData = @json(session('cliente_login'));
        localStorage.setItem('cliente_id', clienteData.id);
        localStorage.setItem('cliente_nombre', clienteData.nombre);
        localStorage.setItem('cliente_email', clienteData.email);
        window.location.reload();
    @endif

    // Logout desde el backend
    @if (session('logout_cliente'))
        localStorage.removeItem('cliente_id');
        localStorage.removeItem('cliente_nombre');
        localStorage.removeItem('cliente_email');
    @endif

    // Verificar si hay cliente logueado al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const clienteId = localStorage.getItem('cliente_id');
        const clienteNombre = localStorage.getItem('cliente_nombre');

        // Elementos desktop
        const registerLink = document.getElementById('register-link');
        const userProfile = document.getElementById('user-profile');
        const userName = document.getElementById('user-name');

        // Elementos móvil
        const registerLinkMobile = document.getElementById('register-link-mobile');
        const userProfileMobile = document.getElementById('user-profile-mobile');

        if (clienteId && clienteNombre) {
            // Cliente logueado - mostrar perfil en desktop
            if (registerLink) registerLink.style.display = 'none';
            if (userProfile) {
                userProfile.classList.remove('hidden');
                userProfile.style.display = 'flex';
            }
            if (userName) userName.textContent = clienteNombre;

            // Cliente logueado - mostrar perfil en móvil
            if (registerLinkMobile) registerLinkMobile.style.display = 'none';
            if (userProfileMobile) {
                userProfileMobile.classList.remove('hidden');
                userProfileMobile.style.display = 'flex';
            }
        } else {
            // Cliente no logueado - mostrar registro
            if (registerLink) registerLink.style.display = 'flex';
            if (userProfile) userProfile.classList.add('hidden');
            if (registerLinkMobile) registerLinkMobile.style.display = 'flex';
            if (userProfileMobile) userProfileMobile.classList.add('hidden');
        }
    });
</script>
