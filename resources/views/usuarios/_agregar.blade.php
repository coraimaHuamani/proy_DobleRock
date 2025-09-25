{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\usuarios\_agregar.blade.php --}}
<div id="users-create-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold">Crear un usuario</h3>
    <form id="create-users-form" data-id="" class="flex flex-col">

      <label for="create-user-nombre" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Nombre</label>
      <input id="create-user-nombre" type="text" name="nombre" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="create-user-email" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Email</label>
      <input id="create-user-email" type="email" name="email" required class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
      
      <label for="create-user-password" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Contraseña</label>
      <input id="create-user-password" type="password" name="password" required minlength="6" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

      <label for="create-user-rol" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Rol</label>
      <select id="create-user-rol" name="rol" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="">Seleccionar rol</option>
        <option value="admin">Administrador</option>
      </select>

      <label for="create-user-estado" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Estado</label>
      <select id="create-user-estado" name="estado" class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
      </select>

      <div class="flex flex-col sm:flex-row mt-8 gap-4">
        <button id="btn-save-create-user" type="submit" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
          Guardar
        </button>
        <button id="btn-cancel-create-user" type="button" class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Volver
        </button>
      </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/usuarios/crearUsuario.js') }}"></script>
@endpush