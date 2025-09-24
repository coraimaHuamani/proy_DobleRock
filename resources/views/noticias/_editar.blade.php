{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\noticias\_editar.blade.php --}}
<div id="news-edit-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class=" text-left font-bold ">Editar Noticia</h3>
    <form id="edit-news-form" data-id="" class="flex flex-col ">

      <label for="edit-new-title" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Titulo</label>
      <input id="edit-new-title" type="text" name="title" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="edit-new-url" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Url de la fuente</label>
      <input id="edit-new-url" type="url" name="source_url" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="edit-new-description" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
      <textarea id="edit-new-description" name="description" required rows="3" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>

      <label for="edit-new-category" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Categoría</label>
      <select id="edit-new-category" name="category" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="">Seleccionar categoría</option>
        @foreach(\App\Models\News::CATEGORIES as $key => $value)
          <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
      </select>

      <label for="edit-new-image" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Imagen</label>
      <input id="edit-new-image" type="file" name="image" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img
          id="notice-image-preview"
          src=""
          alt="Previsualización de imagen"
          class="w-full h-full object-cover"
        />
      </div>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-edit" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Actualizar
        </button>
        <button id="btn-cancel-edit" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
    <script type="module" src="{{ asset('js/noticias/editarNoticias.js') }}"></script>
@endpush