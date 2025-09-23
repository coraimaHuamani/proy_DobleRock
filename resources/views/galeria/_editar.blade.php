{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\galeria\_editar.blade.php --}}
<div id="galeria-edit-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Editar archivo</h3>
    <form id="edit-galeria-form" data-id="" class="flex flex-col">

      <label for="edit-galeria-titulo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Título</label>
      <input id="edit-galeria-titulo" type="text" name="titulo" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="edit-galeria-descripcion" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
      <textarea id="edit-galeria-descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>
      
      <label for="edit-galeria-tipo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Tipo</label>
      <select id="edit-galeria-tipo" name="tipo" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="imagen">Imagen</option>
        <option value="video">Video</option>
      </select>

      <label for="edit-galeria-archivo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Archivo (dejar vacío para no cambiar)</label>
      <input id="edit-galeria-archivo" type="file" name="archivo" accept="image/*,video/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img id="edit-galeria-preview" src="" alt="Previsualización" class="w-full h-full object-cover hidden"/>
        <video id="edit-galeria-video-preview" controls class="w-full h-full object-cover hidden"></video>
      </div>

      <label for="edit-galeria-estado" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Estado</label>
      <select id="edit-galeria-estado" name="estado" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
      </select>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-edit-galeria" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Actualizar
        </button>
        <button id="btn-cancel-edit-galeria" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/galeria/editarGaleria.js') }}"></script>
@endpush