{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\productos\_editar.blade.php --}}
<div id="productos-edit-section"
    class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
    <h3 class="text-left font-bold">Editar producto</h3>
    <form id="edit-productos-form" data-id="" class="flex flex-col">

        <label for="edit-producto-nombre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Nombre</label>
        <input id="edit-producto-nombre" type="text" name="nombre" required
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="edit-producto-descripcion"
            class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
        <textarea id="edit-producto-descripcion" name="descripcion" rows="3"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>

        <label for="edit-producto-precio" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Precio</label>
        <input id="edit-producto-precio" type="number" name="precio" step="0.01" min="0" required
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="edit-producto-categoria" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Categoría</label>
        <select id="edit-producto-categoria" name="categoria_id"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            <option value="">Seleccionar categoría</option>
            <!-- Las categorías se cargarán dinámicamente -->
        </select>

        <label for="edit-producto-stock" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Stock</label>
        <input id="edit-producto-stock" type="number" name="stock" min="0" required
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <div class="flex flex-col sm:flex-row mt-8 gap-4">
            <button id="btn-save-edit-producto" type="submit"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Actualizar
            </button>
            <button id="btn-cancel-edit-producto" type="button"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Volver
            </button>
        </div>
    </form>
</div>
