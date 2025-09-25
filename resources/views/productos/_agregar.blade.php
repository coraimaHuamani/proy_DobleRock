{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\productos\_agregar.blade.php --}}
<div id="productos-create-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Crear un producto</h3>
    <form id="create-productos-form" data-id="" class="flex flex-col">

      <label for="create-producto-nombre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Nombre</label>
      <input id="create-producto-nombre" type="text" name="nombre" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="create-producto-descripcion" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
      <textarea id="create-producto-descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>

      <label for="create-producto-precio" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Precio</label>
      <input id="create-producto-precio" type="number" name="precio" step="0.01" min="0" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-producto-categoria" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Categoría</label>
      <select id="create-producto-categoria" name="categoria_id" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="">Seleccionar categoría</option>
        <!-- Las categorías se cargarán dinámicamente -->
      </select>

      <label for="create-producto-stock" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Stock</label>
      <input id="create-producto-stock" type="number" name="stock" min="0" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-producto-imagen" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Imagen</label>
      <input id="create-producto-imagen" type="file" name="imagen" accept="image/*" class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
      
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img id="create-producto-preview" src="" alt="Previsualización" class="w-full h-full object-cover hidden"/>
        <div id="create-producto-placeholder" class="w-full h-full flex items-center justify-center text-gray-500">
          <i class="fa-solid fa-image text-4xl"></i>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-create-producto" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-create-producto" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("create-producto-imagen");
    const previewImg = document.getElementById("create-producto-preview");
    const placeholder = document.getElementById("create-producto-placeholder");

    if (imageInput && previewImg && placeholder) {
        imageInput.addEventListener("change", () => {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove("hidden");
                    placeholder.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = "";
                previewImg.classList.add("hidden");
                placeholder.classList.remove("hidden");
            }
        });
    }
});
</script>
@endpush