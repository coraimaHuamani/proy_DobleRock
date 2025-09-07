<!-- SECCIÓN ESCUCHAR MÚSICA -->
<section class="py-16 bg-[#1a1a1a]">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-5xl font-bold text-orange-500 mb-2">ESCUCHAR MÚSICA</h2>
        <p class="text-gray-300 text-lg">Descubre los mejores álbumes de rock y música alternativa</p>
    </div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 px-4">
        <!-- Selector de género -->
        <div class="mb-4 md:mb-0">
            <select class="bg-gray-800 text-white px-4 py-2 rounded focus:outline-none">
                <option>ROCK</option>
                <option>POP</option>
                <option>ALTERNATIVO</option>
            </select>
        </div>
        <!-- Buscador -->
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Buscar canciones..."
                class="bg-gray-800 text-white px-4 py-2 rounded focus:outline-none">
            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>
    <!-- Tabs de navegación -->
    <!-- Tabs de navegación -->
<div class="flex flex-wrap justify-center items-center gap-4 md:gap-8 mb-6 bg-[#181818] rounded-lg py-2 px-2 shadow">
    <button data-tab="albums"
        class="music-tab text-gray-300 border-b-2 border-orange-500 pb-2 font-semibold focus:outline-none transition-colors duration-200">
        ÁLBUMES
    </button>
    <button data-tab="songs"
        class="music-tab text-gray-300 hover:text-orange-500 pb-2 font-semibold focus:outline-none transition-colors duration-200">
        CANCIONES
    </button>
    <button data-tab="recent"
        class="music-tab text-gray-300 hover:text-orange-500 pb-2 font-semibold focus:outline-none transition-colors duration-200">
        RECIENTES
    </button>
    <button data-tab="popular"
        class="music-tab text-gray-300 hover:text-orange-500 pb-2 font-semibold focus:outline-none transition-colors duration-200">
        POPULARES
    </button>
</div>
    <!-- Tarjetas de álbumes -->
    <div id="albums" class="flex flex-wrap justify-center gap-8">
        <!-- Álbum 1 -->
        <div
            class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Clásico</span>
                <div class="text-gray-200 text-sm">Varios Artistas</div>
                <div class="text-orange-200 text-sm font-bold mt-2">45:32</div>
            </div>
        </div>
        <!-- Álbum 2 -->
        <div
            class="bg-gradient-to-br from-orange-700 to-red-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Grandes Éxitos</span>
                <div class="text-gray-200 text-sm">Rock Internacional</div>
                <div class="text-orange-200 text-sm font-bold mt-2">52:18</div>
            </div>
        </div>
        <!-- Álbum 3 -->
        <div
            class="bg-gradient-to-br from-orange-400 to-purple-600 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Lo Mejor del Rock</span>
                <div class="text-gray-200 text-sm">Compilación</div>
                <div class="text-orange-200 text-sm font-bold mt-2">38:45</div>
            </div>
        </div>
    </div>
    <!-- Tarjetas de canciones -->
    <div id="songs" class="flex flex-wrap justify-center gap-8 hidden">
        <!-- Canción 1 con enlace a YouTube -->
        <div
            class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <a href="https://www.youtube.com/watch?v=l482T0yNkeo" target="_blank" class="absolute inset-0 z-20"></a>
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20 pointer-events-none">
                <span class="text-xl font-bold text-white">Highway to Hell</span>
                <div class="text-gray-200 text-sm">AC/DC</div>
                <div class="text-orange-200 text-sm font-bold mt-2">03:28</div>
            </div>
        </div>
        <!-- Canción 2 -->
        <div
            class="bg-gradient-to-br from-orange-700 to-red-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Bohemian Rhapsody</span>
                <div class="text-gray-200 text-sm">Queen</div>
                <div class="text-orange-200 text-sm font-bold mt-2">05:55</div>
            </div>
        </div>
        <!-- Canción 3 -->
        <div
            class="bg-gradient-to-br from-orange-400 to-purple-600 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Smells Like Teen Spirit</span>
                <div class="text-gray-200 text-sm">Nirvana</div>
                <div class="text-orange-200 text-sm font-bold mt-2">04:12</div>
            </div>
        </div>
    </div>
    <!-- Tarjetas de recientes -->
    <div id="recent" class="flex flex-wrap justify-center gap-8 hidden">
        <!-- Reciente 1 -->
        <div
            class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Nuevo Rock</span>
                <div class="text-gray-200 text-sm">Artista Nuevo</div>
                <div class="text-orange-200 text-sm font-bold mt-2">04:00</div>
            </div>
        </div>
        <!-- Reciente 2 -->
        <div
            class="bg-gradient-to-br from-orange-700 to-red-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Moderno</span>
                <div class="text-gray-200 text-sm">Banda Nueva</div>
                <div class="text-orange-200 text-sm font-bold mt-2">03:50</div>
            </div>
        </div>
        <!-- Reciente 3 -->
        <div
            class="bg-gradient-to-br from-orange-400 to-purple-600 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Alternativo</span>
                <div class="text-gray-200 text-sm">Artista Indie</div>
                <div class="text-orange-200 text-sm font-bold mt-2">04:10</div>
            </div>
        </div>
    </div>
    <!-- Tarjetas de populares -->
    <div id="popular" class="flex flex-wrap justify-center gap-8 hidden">
        <!-- Popular 1 -->
        <div
            class="bg-gradient-to-br from-orange-700 to-red-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Hit Popular</span>
                <div class="text-gray-200 text-sm">Artista Famoso</div>
                <div class="text-orange-200 text-sm font-bold mt-2">03:45</div>
            </div>
        </div>
        <!-- Popular 2 -->
        <div
            class="bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Viral</span>
                <div class="text-gray-200 text-sm">Banda Viral</div>
                <div class="text-orange-200 text-sm font-bold mt-2">04:20</div>
            </div>
        </div>
        <!-- Popular 3 -->
        <div
            class="bg-gradient-to-br from-orange-400 to-purple-600 rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-music fa-3x text-white opacity-60 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Legendario</span>
                <div class="text-gray-200 text-sm">Leyenda Rock</div>
                <div class="text-orange-200 text-sm font-bold mt-2">05:00</div>
            </div>
        </div>
    </div>
</section>
