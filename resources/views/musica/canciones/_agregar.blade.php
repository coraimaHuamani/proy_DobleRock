<div id="song-create-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Agregar nueva cancion</h3>
    <form id="create-song-form" data-id="" class="flex flex-col">

      <label for="create-song-title" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Título</label>
      <input id="create-song-title" type="text" name="title" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-song-artist" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Artista</label>
      <input id="create-song-artist" type="text" name="artist" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-song-genre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Genero</label>
      <input id="create-song-genre" type="text" name="genre" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-song-duration" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Duracion</label>
      <input id="create-song-duration" type="text" pattern="^[0-5]?[0-9]:[0-5][0-9]$" name="duration" placeholder="mm:ss" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

       <label for="create-album-select" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Album</label>
      <select id="create-album-select" name="album" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      </select>

      <label for="create-song-file" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Archivo</label>
      <input id="create-song-file" type="file" name="file" required accept="audio/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">

      <div id="create-song-preview" class="mt-4">
        <p class="text-sm text-gray-400 mb-2">Previsualización:</p>
        <audio  controls class="w-full rounded">
          <source id="create-song-audio-source" src="" type="audio/mpeg">
          Tu navegador no soporta el elemento de audio.
        </audio>
      </div>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-create-song" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-create-song" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/musica/canciones/crearCancion.js') }}"></script>
<script>
  const songInput = document.getElementById('create-song-file');
  const songPreview = document.getElementById('create-song-preview');
  const songSource = document.getElementById('create-song-audio-source');
  
  if(songInput && songPreview && songSource) {
    songInput.addEventListener('change', () => {
      const file = songInput.files[0];
      if (file) {
        if (file.type.startsWith("audio/")) {
          const reader = new FileReader();
          reader.onload = (e) => {
            songSource.src = e.target.result;
            songPreview.classList.remove("hidden");
            songPreview.querySelector("audio").load(); 
          };
          reader.readAsDataURL(file);
        } else {
          alert("Por favor selecciona un archivo de audio válido");
          songInput.value = "";
          songPreview.classList.add("hidden");
        }
      }
    });
  }

</script>
@endpush