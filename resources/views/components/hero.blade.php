<div
    class="relative w-full h-[400px] md:h-[500px] flex items-center justify-center bg-[url('images/fondoPrincipal.jpeg')] bg-cover bg-center">
    <!-- Overlay oscuro eliminado, ya que el fondo es un color sólido -->
    <div class="relative z-10 text-center text-black px-4">
        <h1 class="text-4xl md:text-6xl text-gray-200  font-bold mb-2">DOBLE ROCK</h1>
        <h2 class="text-2xl md:text-3xl text-[#fe4931] font-bold mb-4">QUE EL ROCK NUNCA TE FALTE EN TU VIDA</h2>
        <p class="mb-6 text-lg md:text-xl font-bold text-gray-200">
            Descubre la mejor música de rock y encuentra productos únicos<br>
            Escucha nuestras playlists y visita nuestra tienda virtual
        </p>
        <div class="flex justify-center gap-4">
            <a href="#" id="btn-escuchar"
                class="flex items-center gap-2 text-white bg-[#e7452e] hover:bg-orange-600 px-6 py-2 rounded-full font-semibold transition">
                <i class="fa-solid fa-play text-white"></i>
                ESCUCHAR
            </a>
            <a href="/tienda"
                class="flex items-center gap-2 bg-[#e7452e] hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold transition">
                <i class="fa-solid fa-cart-shopping"></i>
                TIENDA
            </a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnEscuchar = document.getElementById('btn-escuchar');
        var radioPlayer = document.getElementById('radioPlayer');
        var playBtn = document.getElementById('playBtn');
        var playIcon = document.getElementById('playIcon');

        if (btnEscuchar && radioPlayer) {
            btnEscuchar.addEventListener('click', function(e) {
                e.preventDefault();
                // Inicia el audio
                radioPlayer.play();
                // Cambia el ícono a pausa si tienes esa lógica
                if (playIcon) {
                    playIcon.classList.remove('fa-play');
                    playIcon.classList.add('fa-pause');
                }
            });
        }
    });
</script>
