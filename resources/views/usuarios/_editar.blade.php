{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\usuarios\_editar.blade.php --}}
<div id="users-edit-section"
    class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
    <h3 class="text-left font-bold">Editar usuario</h3>
    <form id="edit-users-form" data-id="" class="flex flex-col">

        <label for="edit-user-nombre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Nombre</label>
        <input id="edit-user-nombre" type="text" name="nombre" required
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="edit-user-email" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Email</label>
        <input id="edit-user-email" type="email" name="email" required
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="edit-user-password" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Contraseña (dejar vacío
            para no cambiar)</label>
        <input id="edit-user-password" type="password" name="password" minlength="6"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="edit-user-rol" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Rol</label>
        <select id="edit-user-rol" name="rol"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            <option value="">Seleccionar rol</option>
            <option value="1">Administrador</option>
            <option value="2">Cliente</option>
        </select>

        <label for="edit-user-estado" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Estado</label>
        <select id="edit-user-estado" name="estado"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <div class="flex flex-col sm:flex-row mt-8 gap-4">
            <button id="btn-save-edit-user" type="submit"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Actualizar
            </button>
            <button id="btn-cancel-edit-user" type="button"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Volver
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('js/usuarios/editarUsuario.js') }}"></script>
@endpush
