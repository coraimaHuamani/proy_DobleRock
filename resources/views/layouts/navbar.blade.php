<!-- Logo y reproductor -->
<div class="bg-[#000000]">
    <div
        class="max-w-[1200px] mx-auto p-2 flex flex-col md:flex-row items-center justify-center md:justify-between w-full gap-4">

        <!-- Logo -->
        <!-- Logo -->
        <a href="/" class="flex items-center mb-2 md:mb-0">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="w-12 h-12 object-contain mr-3" />
            <div class="flex flex-col md:mr-6">
                <span class="text-white font-bold text-xl leading-tight">DOBLE</span>
                <span class="text-[#e7452e] font-bold text-xl leading-tight">ROCK</span>
            </div>
        </a>

        <!-- Reproductor de música – Modern UI (solo badge, menos rectangular) -->
        <div id="radioWrapper" class="w-full max-w-sm min-w-[260px]">
            <div
                class="group relative mx-auto flex items-center gap-3 rounded-full border border-white/10 bg-[#232323]/80 px-3.5 py-2 shadow-[0_10px_30px_rgba(0,0,0,.35)] backdrop-blur-md supports-[backdrop-filter]:backdrop-blur-md">

                <!-- Glow decorativo -->
                <div class="pointer-events-none absolute -inset-0.5 rounded-full opacity-0 blur-lg transition-opacity duration-500 group-hover:opacity-100"
                    style="background: radial-gradient(60% 60% at 50% 50%, rgba(231,69,46,0.22), transparent 60%);">
                </div>

                <!-- Punto de estado -->
                <div class="relative flex items-center justify-center shrink-0">
                    <span class="relative flex h-2.5 w-2.5">
                        <span
                            class="absolute inset-0 rounded-full bg-[#e7452e]/60 animate-[pulse_2.2s_cubic-bezier(0,0,0.2,1)_infinite]"></span>
                        <span
                            class="relative z-[1] h-2.5 w-2.5 rounded-full bg-[#e7452e] shadow-[0_0_10px_rgba(231,69,46,.8)]"></span>
                    </span>
                </div>

                <!-- Info compacta -->
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="text-white/90 text-[13px] font-semibold tracking-wide">Radio en vivo</span>
                        <!-- ÚNICO “DOBLE ROCK” que se mantiene -->
                        <span
                            class="rounded-full border border-white/10 bg-white/5 px-2.5 py-[3px] text-[10px] text-white/80">
                            DOBLE ROCK
                        </span>
                    </div>
                </div>

                <!-- Ecualizador (solo en play) -->
                <div class="hidden sm:flex h-5 items-end gap-[3px] pr-0.5" aria-hidden="true">
                    <span class="eq-bar eq-1 w-[2px] rounded-full bg-[#e7452e]"></span>
                    <span class="eq-bar eq-2 w-[2px] rounded-full bg-[#e7452e]"></span>
                    <span class="eq-bar eq-3 w-[2px] rounded-full bg-[#e7452e]"></span>
                </div>

                <!-- Botón Play/Pause (IDs conservados) -->
                <button id="playBtn"
                    class="relative grid h-10 w-10 place-items-center shrink-0 rounded-full bg-[#e7452e] text-white shadow-[0_6px_16px_rgba(231,69,46,.45)] transition-all duration-200 hover:scale-105 hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-[#e7452e]/60 focus:ring-offset-2 focus:ring-offset-black"
                    aria-label="Play">
                    <span class="play-ring pointer-events-none absolute inset-0 rounded-full opacity-0"></span>
                    <i id="playIcon" class="fa-solid fa-play text-[13px]"></i>
                </button>

                <!-- Audio -->
                <audio id="radioPlayer" preload="none" class="hidden">
                    <source src="http://109.169.15.21:37873/;stream.mp3" type="audio/mpeg">
                </audio>
            </div>
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
                                // Verifica si el usuario está logueado (ajusta según tu sistema)
                                var clienteId = localStorage.getItem('cliente_id');
                                if (clienteId) {
                                    window.location.href = '/checkout'; // Página de pago
                                } else {
                                    // Guarda intención y redirige a login
                                    localStorage.setItem('checkout_pending', '1');
                                    window.location.href = '/login';
                                }
                            });
                        }
                    });

                    // Después de login, redirige a checkout si corresponde
                    document.addEventListener('DOMContentLoaded', function() {
                        if (localStorage.getItem('checkout_pending') === '1') {
                            localStorage.removeItem('checkout_pending');
                            window.location.href = '/checkout';
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

<!-- Script para el reproductor diseño de transiciones -->
<script src="{{ asset('js/reproductor/reproductorDiseño.js') }}"></script>

<!-- Script para la sesiones del cliente -->
<script src="{{ asset('js/clientes/cliente_login.js') }}"></script>

<!-- Diseño y estilo para el reproductor -->
<link rel="stylesheet" href="{{ asset('css/reproductor/reproductor.css') }}">
