<div id="album-edit-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Editar Album</h3>
    <form id="edit-album-form" data-id="" class="flex flex-col">

      <label for="edit-album-title" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Título</label>
      <input id="edit-album-title" type="text" name="title" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="edit-album-year" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Year</label>
      <input id="edit-album-year" type="text" name="year" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="edit-album-file" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Imagen del Album</label>
      <input id="edit-album-file" type="file" name="file" required accept="image/*,video/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img id="edit-album-image-preview" src="" alt="Previsualización" class="w-full h-full object-cover hidden"/>
        <div id="edit-album-placeholder" class="w-full h-full flex items-center justify-center text-gray-500">
          <i class="fa-solid fa-file text-4xl"></i>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-edit-album" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-edit-album" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script type="module" src="{{ asset('js/musica/albumes/editarAlbum.js') }}"></script>
@endpush