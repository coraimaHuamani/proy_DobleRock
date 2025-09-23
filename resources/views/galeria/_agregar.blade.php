{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\galeria\_agregar.blade.php --}}
<div id="galeria-create-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Agregar nuevo archivo</h3>
    <form id="create-galeria-form" data-id="" class="flex flex-col">

      <label for="create-galeria-titulo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Título</label>
      <input id="create-galeria-titulo" type="text" name="titulo" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="create-galeria-descripcion" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
      <textarea id="create-galeria-descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>
      
      <label for="create-galeria-tipo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Tipo</label>
      <select id="create-galeria-tipo" name="tipo" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="">Seleccionar tipo</option>
        <option value="imagen">Imagen</option>
        <option value="video">Video</option>
      </select>

      <label for="create-galeria-archivo" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Archivo</label>
      <input id="create-galeria-archivo" type="file" name="archivo" required accept="image/*,video/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img id="create-galeria-preview" src="" alt="Previsualización" class="w-full h-full object-cover hidden"/>
        <video id="create-galeria-video-preview" controls class="w-full h-full object-cover hidden"></video>
        <div id="create-galeria-placeholder" class="w-full h-full flex items-center justify-center text-gray-500">
          <i class="fa-solid fa-file text-4xl"></i>
        </div>
      </div>

      <label for="create-galeria-estado" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Estado</label>
      <select id="create-galeria-estado" name="estado" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
      </select>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-create-galeria" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-create-galeria" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/galeria/crearGaleria.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const archivoInput = document.getElementById("create-galeria-archivo");
    const imgPreview = document.getElementById("create-galeria-preview");
    const videoPreview = document.getElementById("create-galeria-video-preview");
    const placeholder = document.getElementById("create-galeria-placeholder");

    if (archivoInput) {
      archivoInput.addEventListener("change", () => {
        const file = archivoInput.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            if (file.type.startsWith('image/')) {
              imgPreview.src = e.target.result;
              imgPreview.classList.remove('hidden');
              videoPreview.classList.add('hidden');
              placeholder.classList.add('hidden');
            } else if (file.type.startsWith('video/')) {
              videoPreview.src = e.target.result;
              videoPreview.classList.remove('hidden');
              imgPreview.classList.add('hidden');
              placeholder.classList.add('hidden');
            }
          };
          reader.readAsDataURL(file);
        } else {
          imgPreview.classList.add('hidden');
          videoPreview.classList.add('hidden');
          placeholder.classList.remove('hidden');
        }
      });
    }
  });
</script>
@endpush