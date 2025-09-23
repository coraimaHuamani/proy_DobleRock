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

        {{-- BOTÓN HAMBURGUESA MOBILE --}}
        <div class="md:hidden">
            <div class="flex items-center gap-2">
                <button id="menu-btn" class="focus:outline-none text-white hover:text-[#e7452e]">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <button id="open-cart-mobile" class="text-white hover:text-[#e7452e] flex items-center gap-1 md:hidden">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count-mobile"
                        class="inline-flex items-center justify-center text-xs bg-[#e7452e] rounded-full w-5 h-5">0</span>
                </button>
            </div>
        </div>

        {{-- DERECHA: buscador + iconos --}}
        <div class="hidden md:flex items-center space-x-4">
            {{-- Buscador solo visible en tienda --}}
            <!-- Buscador eliminado del navbar, ahora solo en tienda -->

            <a href="/login"
                class="flex items-center gap-1 text-white hover:text-[#e7452e] px-2 py-1 rounded transition">
                <i class="fa-solid fa-user"></i>
                <span class="hidden md:inline font-semibold uppercase text-xs tracking-widest"></span>
            </a>

            {{-- CARRITO --}}
            <div class="relative">
                <button id="open-cart" class="text-white hover:text-[#e7452e] flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count"
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
