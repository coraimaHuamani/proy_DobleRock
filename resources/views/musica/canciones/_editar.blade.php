<div id="song-edit-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Editar cancion</h3>
    <form id="edit-song-form" data-id="" class="flex flex-col">

      <label for="edit-song-title" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Título</label>
      <input id="edit-song-title" type="text" name="title" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="edit-song-artist" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Artista</label>
      <input id="edit-song-artist" type="text" name="artist" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="edit-song-genre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Genero</label>
      <input id="edit-song-genre" type="text" name="genre" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="edit-song-duration" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Duracion</label>
      <input id="edit-song-duration" type="text" name="duration" placeholder="mm:ss" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

       <label for="edit-album-select" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Album</label>
      <select id="edit-album-select" name="album" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        
      </select>

      <label for="edit-song-file" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Archivo</label>
      <input id="edit-song-file" type="file" name="file" accept="audio/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      <div id="edit-song-preview" class="mt-4">
        <p class="text-sm text-gray-400 mb-2">Previsualización:</p>
        <audio controls class="w-full rounded">
          <source  src="" type="audio/mpeg">
          Tu navegador no soporta el elemento de audio.
        </audio>
      </div>


      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-edit-song" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-edit-song" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script type="module" src="{{ asset('js/musica/canciones/editarCancion.js') }}"></script>
@endpush