{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\categorias\_editar.blade.php --}}
<div id="categorias-edit-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Editar categoría</h3>
    <form id="edit-categorias-form" data-id="" class="flex flex-col">

      <label for="edit-categoria-nombre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Nombre</label>
      <input id="edit-categoria-nombre" type="text" name="nombre" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="edit-categoria-descripcion" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
      <textarea id="edit-categoria-descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-edit-categoria" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Actualizar
        </button>
        <button id="btn-cancel-edit-categoria" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/categoria/editar.js') }}"></script>
@endpush