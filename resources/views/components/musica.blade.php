<!-- SECCIÓN ESCUCHAR MÚSICA -->
<section class="py-16 bg-[#1a1a1a]">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-5xl font-bold text-[#e7452e] mb-2">ESCUCHAR MÚSICA</h2>
        <p class="text-gray-300 text-lg">Descubre los mejores álbumes de rock y música alternativa</p>
    </div>
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
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
                <button class="bg-[#e7452e] hover:bg-[#c6341e] text-white px-4 py-2 rounded">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs de navegación -->
    <div
        class="flex flex-wrap justify-center items-center gap-4 md:gap-8 mb-6 bg-[#181818] rounded-lg py-2 px-2 shadow">
        <button data-tab="albums"
            class="music-tab text-gray-300 border-b-2 border-[#e7452e] pb-2 font-semibold focus:outline-none transition-colors duration-200">
            ÁLBUMES
        </button>
        <button data-tab="songs"
            class="music-tab text-gray-300 hover:text-[#e7452e] pb-2 font-semibold focus:outline-none transition-colors duration-200">
            CANCIONES
        </button>
        <button data-tab="recent"
            class="music-tab text-gray-300 hover:text-[#e7452e] pb-2 font-semibold focus:outline-none transition-colors duration-200">
            RECIENTES
        </button>
        <button data-tab="popular"
            class="music-tab text-gray-300 hover:text-[#e7452e] pb-2 font-semibold focus:outline-none transition-colors duration-200">
            POPULARES
        </button>
    </div>

    <!-- Tarjetas de álbumes -->
    <div id="albums" class="flex flex-wrap justify-center gap-8 max-w-7xl mx-auto px-4">
        <!-- Álbum 1 - Naranja/roja oscura -->
        <div
            class="bg-gradient-to-br from-[#c2410c] to-[#991b1b] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Rock Clásico</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#fcd34d] text-sm font-bold mt-2">45:32</div>
            </div>
        </div>

        <!-- Álbum 2 - Azul oscuro -->
        <div
            class="bg-gradient-to-br from-[#1e40af] to-[#1e3a8a] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Jazz Suave</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#93c5fd] text-sm font-bold mt-2">52:10</div>
            </div>
        </div>

        <!-- Álbum 3 - Morado oscuro -->
        <div
            class="bg-gradient-to-br from-[#5b21b6] to-[#7e22ce] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Pop Moderno</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#d8b4fe] text-sm font-bold mt-2">38:45</div>
            </div>
        </div>


    </div>

    <!-- Tarjetas de canciones -->
    <div id="songs" class="flex flex-wrap justify-center gap-8 hidden">
        <div
            class="bg-gradient-to-br from-[#1e40af] to-[#1e3a8a] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Jazz Suave</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#93c5fd] text-sm font-bold mt-2">52:10</div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de recientes -->
    <div id="recent" class="flex flex-wrap justify-center gap-8 hidden">
        <div
            class="bg-gradient-to-br from-[#1e40af] to-[#1e3a8a] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Jazz Suave</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#93c5fd] text-sm font-bold mt-2">52:10</div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de populares -->
    <div id="popular" class="flex flex-wrap justify-center gap-8 hidden">

        <!-- Álbum 3 - Morado oscuro -->
        <div
            class="bg-gradient-to-br from-[#5b21b6] to-[#7e22ce] rounded-xl shadow-lg w-72 h-56 flex flex-col justify-center items-center text-center transition-transform duration-300 hover:scale-105 cursor-pointer relative">
            <i
                class="fa-solid fa-play-circle fa-3x text-white opacity-60 absolute top-[35%] left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            <div class="z-10 mt-20">
                <span class="text-xl font-bold text-white">Pop Moderno</span>
                <div class="text-gray-300 text-sm">Varios Artistas</div>
                <div class="text-[#d8b4fe] text-sm font-bold mt-2">38:45</div>
            </div>
        </div>
    </div>

</section>
