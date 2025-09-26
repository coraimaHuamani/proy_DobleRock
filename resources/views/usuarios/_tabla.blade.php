<div class="overflow-x-auto">
    <table id="users-table-container"
        class="min-w-full divide-y divide-gray-700 bg-[#181818] rounded-lg shadow text-white">
        <thead class="bg-[#232323]">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rol</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody id="users-tbody" class="divide-y divide-gray-700">
            <!-- Los usuarios se cargarán dinámicamente aquí -->
            <tr class="text-center">
                <td colspan="8" class="px-4 py-8 text-gray-400">
                    <i class="fa-solid fa-spinner fa-spin text-xl mb-2"></i>
                    <div>Cargando usuarios...</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>