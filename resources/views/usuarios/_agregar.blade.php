{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\usuarios\_agregar.blade.php --}}
<div id="users-create-section" class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
    <h3 class="text-left font-bold text-xl mb-4">
        <i class="fa-solid fa-user-plus mr-2 text-[#e7452e]"></i>
        Crear Usuario
    </h3>
    
    <form id="create-users-form" class="flex flex-col space-y-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nombre -->
            <div>
                <label for="create-user-nombre" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-user mr-2"></i>Nombre *
                </label>
                <input id="create-user-nombre" type="text" name="nombre" required placeholder="Nombre completo"
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
            </div>

            <!-- Email -->
            <div>
                <label for="create-user-email" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-envelope mr-2"></i>Email *
                </label>
                <input id="create-user-email" type="email" name="email" required placeholder="usuario@ejemplo.com"
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Contraseña -->
            <div>
                <label for="create-user-password" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-lock mr-2"></i>Contraseña *
                </label>
                <input id="create-user-password" type="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres"
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
            </div>

            <!-- Rol -->
            <div>
                <label for="create-user-rol" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-user-shield mr-2"></i>Rol *
                </label>
                <select id="create-user-rol" name="rol" required
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
                    <option value="">Seleccionar rol</option>
                    <option value="1">👑 Administrador</option>
                    <option value="2">👤 Cliente</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Teléfono -->
            <div>
                <label for="create-user-telefono" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-phone mr-2"></i>Teléfono
                </label>
                <input id="create-user-telefono" type="tel" name="telefono" placeholder="+58 414 123 4567"
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
            </div>

            <!-- Estado -->
            <div>
                <label for="create-user-estado" class="block text-gray-300 text-sm font-bold mb-2">
                    <i class="fa-solid fa-toggle-on mr-2"></i>Estado
                </label>
                <select id="create-user-estado" name="estado"
                    class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e]">
                    <option value="1">✅ Activo</option>
                    <option value="0">❌ Inactivo</option>
                </select>
            </div>
        </div>

        <!-- Dirección -->
        <div>
            <label for="create-user-direccion" class="block text-gray-300 text-sm font-bold mb-2">
                <i class="fa-solid fa-map-marker-alt mr-2"></i>Dirección
            </label>
            <textarea id="create-user-direccion" name="direccion" rows="3" placeholder="Dirección completa (opcional)"
                class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e] focus:border-[#e7452e] resize-none"></textarea>
        </div>

        <!-- Mensaje informativo -->
        <div class="bg-blue-900/30 border border-blue-700/50 rounded-lg p-3 text-sm text-blue-200">
            <i class="fa-solid fa-info-circle mr-2"></i>
            <strong>Información:</strong> Los campos marcados con (*) son obligatorios. El teléfono y dirección son opcionales.
        </div>

        <!-- Botones -->
        <div class="flex flex-col sm:flex-row mt-8 gap-4 pt-4 border-t border-gray-600">
            <button id="btn-save-create-user" type="submit"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Crear Usuario
            </button>
            <button id="btn-cancel-create-user" type="button"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition duration-300">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Cancelar
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/usuarios/crearUsuario.js') }}"></script>
@endpush