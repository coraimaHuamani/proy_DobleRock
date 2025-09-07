<!-- Logo y reproductor -->
<div class="bg-black p-2 flex flex-col md:flex-row items-center justify-center md:justify-between w-full gap-4">
    <div class="flex items-center mb-2 md:mb-0">
        <img src="{{ asset('images/image.png') }}" alt="Logo" class="w-12 h-12 object-contain mr-3" />
        <div class="flex flex-col md:mr-6">
            <span class="text-white font-bold text-xl leading-tight">DOBLE</span>
            <span class="text-white font-bold text-xl leading-tight">ROCK</span>
        </div>
    </div>
    <!-- Reproductor de música -->
    <div
        class="bg-[#1a1a1a] rounded-full flex items-center px-3 py-2 shadow-lg space-x-2 w-full max-w-md h-[54px] md:ml-0">
        <div class="flex flex-col justify-center flex-1 min-w-0">
            <span class="text-white font-bold text-sm block leading-tight">Nothing Impossible</span>
            <span class="text-gray-300 text-xs truncate">Matias Martelli</span>
        </div>
        <button class="text-white text-base" aria-label="Anterior"><i class="fa-solid fa-backward-step"></i></button>
        <button class="bg-orange-500 text-white w-8 h-8 flex items-center justify-center rounded-full"
            aria-label="Play">
            <i class="fa-solid fa-play"></i>
        </button>
        <button class="text-white text-base" aria-label="Siguiente"><i class="fa-solid fa-forward-step"></i></button>
        <div class="w-16 h-1 bg-gray-600 rounded-full overflow-hidden">
            <div class="h-1 bg-orange-500 w-2/3"></div>
        </div>
    </div>
</div>
<nav class="bg-[#1a1a1a] text-white px-6 py-3 flex items-center justify-between">
    <!-- ENLACES IZQUIERDA -->
    <ul class="hidden md:flex space-x-6 font-semibold uppercase text-sm">
        <li><a href="#" class="hover:text-orange-500">Inicio</a></li>
        <li><a href="#" class="hover:text-orange-500">Tienda</a></li>
        <li><a href="#" class="hover:text-orange-500">Música</a></li>
        <li><a href="#" class="hover:text-orange-500">Nosotros</a></li>
        <li><a href="#" class="hover:text-orange-500">Contacto</a></li>
    </ul>

    <!-- BOTÓN HAMBURGUESA MOBILE -->
    <div class="md:hidden">
        <button id="menu-btn" class="focus:outline-none">
            <i class="fa-solid fa-bars fa-lg"></i>
        </button>
    </div>

    <!-- DERECHA: buscador + iconos -->
    <div class="hidden md:flex items-center space-x-4">
        <div class="flex items-center bg-gray-800 rounded-full px-3 py-1">
            <input type="text" placeholder="Buscar productos..."
                class="bg-transparent text-sm focus:outline-none text-gray-300 placeholder-gray-400 w-40">
            <button class="text-white hover:text-orange-500">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
        <button class="text-white hover:text-orange-500">
            <i class="fa-solid fa-user"></i>
        </button>
        <div class="relative">
            <button class="text-white hover:text-orange-500">
                <i class="fa-solid fa-cart-shopping"></i>
            </button>
            <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-xs rounded-full px-1.5">1</span>
        </div>
    </div>
</nav>

<!-- MENÚ LATERAL MOBILE -->
<div id="mobile-menu"
    class="fixed top-0 left-0 h-full w-64 bg-[#181818] text-white transform -translate-x-full transition-transform duration-300 z-50 shadow-2xl border-r-4 border-orange-500">
    <div class="px-6 py-4">
        <div class="flex justify-end">
            <button id="close-menu" class="mb-4 text-orange-500 focus:outline-none text-2xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <ul class="space-y-6 mt-4 font-semibold uppercase text-base">
            <li>
                <a href="#" class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-house text-orange-500"></i> Inicio
                    </div>
                    <span class="absolute left-3 right-3 bottom-0 h-1 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#" class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-store text-orange-500"></i> Tienda
                    </div>
                    <span class="absolute left-3 right-3 bottom-0 h-1 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#" class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-music text-orange-500"></i> Música
                    </div>
                    <span class="absolute left-3 right-3 bottom-0 h-1 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#" class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users text-orange-500"></i> Nosotros
                    </div>
                    <span class="absolute left-3 right-3 bottom-0 h-1 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#" class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-orange-500"></i> Contacto
                    </div>
                    <span class="absolute left-3 right-3 bottom-0 h-1 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        const closeBtn = document.getElementById('close-menu');
        const overlay = document.getElementById('overlay');

        if (btn && menu && closeBtn && overlay) {
            btn.addEventListener('click', function() {
                menu.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });

            closeBtn.addEventListener('click', function() {
                menu.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });

            overlay.addEventListener('click', function() {
                menu.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }
    });
</script>