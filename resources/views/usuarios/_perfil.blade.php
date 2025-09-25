{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\admin\_perfil.blade.php --}}
<div class="text-white">
    <div id="profile-error" class="hidden mb-4 p-3 bg-red-900/50 border border-red-700 rounded text-red-300 text-sm">
    </div>
    <div id="profile-success"
        class="hidden mb-4 p-3 bg-green-900/50 border border-green-700 rounded text-green-300 text-sm"></div>

    <form id="admin-profile-form" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="admin-nombre" class="block text-gray-300 text-sm font-bold mb-2">Nombre</label>
                <input id="admin-nombre" type="text" name="nombre" required
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            </div>

            <div>
                <label for="admin-email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                <input id="admin-email" type="email" name="email" required
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            </div>
        </div>

        <div>
            <label for="admin-password" class="block text-gray-300 text-sm font-bold mb-2">Nueva Contraseña
                (opcional)</label>
            <input id="admin-password" type="password" name="password" minlength="6"
                class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                placeholder="Dejar vacío para no cambiar">
        </div>

        <div>
            <label for="admin-password-confirm" class="block text-gray-300 text-sm font-bold mb-2">Confirmar Nueva
                Contraseña</label>
            <input id="admin-password-confirm" type="password" minlength="6"
                class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                placeholder="Confirmar contraseña">
        </div>

        <!-- Información del perfil -->
        <div class="bg-[#232323] p-4 rounded-lg">
            <h4 class="text-[#e7452e] font-semibold mb-3">Información del Perfil</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-400">Rol:</span>
                    <span class="text-white font-semibold ml-2">Administrador</span>
                </div>
                <div>
                    <span class="text-gray-400">Estado:</span>
                    <span class="text-green-400 font-semibold ml-2">Activo</span>
                </div>
                <div>
                    <span class="text-gray-400">Fecha de creación:</span>
                    <span id="admin-fecha-creacion" class="text-white ml-2"></span>
                </div>
                <div>
                    <span class="text-gray-400">ID de usuario:</span>
                    <span id="admin-user-id" class="text-white ml-2"></span>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                class="px-6 py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold transition duration-200">
                <i class="fa-solid fa-save mr-2"></i>
                Actualizar Perfil
            </button>
        </div>
    </form>
</div>

<script>
// Pasar el ID del usuario desde PHP a JavaScript
window.USER_ID = '{{ session("user_id") }}';
</script>
<script src="{{ asset('js/usuarios/usuarioPerfil.js') }}"></script>
