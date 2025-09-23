function cargarGaleria() {
    const tbody = document.querySelector('#galeria-table-container tbody');
    if (!tbody) {
        console.error('No se encontró la tabla de galería');
        return;
    }

    // Mostrar estado de carga
    tbody.innerHTML = `
        <tr>
            <td colspan="8" class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                <p>Cargando galería...</p>
            </td>
        </tr>
    `;

    fetch('/api/galeria')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar galería');
            }
            return response.json();
        })
        .then(galeria => {
            tbody.innerHTML = '';
            
            if (galeria.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">
                            <i class="fa-solid fa-images text-4xl mb-4"></i>
                            <p>No hay archivos en la galería</p>
                        </td>
                    </tr>
                `;
                return;
            }

            galeria.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-[#1a1a1a] transition-colors';
                
                const fechaCreacion = item.fecha_creacion 
                    ? new Date(item.fecha_creacion).toLocaleDateString('es-ES')
                    : 'N/A';
                
                const estadoBadge = item.estado 
                    ? '<span class="px-2 py-1 text-xs bg-green-600 text-white rounded">Activo</span>'
                    : '<span class="px-2 py-1 text-xs bg-red-600 text-white rounded">Inactivo</span>';

                const tipoBadge = item.tipo === 'imagen' 
                    ? '<span class="px-2 py-1 text-xs bg-blue-600 text-white rounded">Imagen</span>'
                    : '<span class="px-2 py-1 text-xs bg-purple-600 text-white rounded">Video</span>';

                const archivoPreview = item.archivo ? 
                    (item.tipo === 'imagen' 
                        ? `<img src="/storage/${item.archivo}" class="w-12 h-12 object-cover rounded" alt="Preview">`
                        : `<i class="fa-solid fa-video text-2xl text-purple-400"></i>`)
                    : 'N/A';

                tr.innerHTML = `
                    <td class="px-4 py-2 text-white">#${String(item.id).padStart(3, '0')}</td>
                    <td class="px-4 py-2 text-white">${item.titulo}</td>
                    <td class="px-4 py-2">${tipoBadge}</td>
                    <td class="px-4 py-2 text-gray-300 max-w-xs truncate">${item.descripcion || 'Sin descripción'}</td>
                    <td class="px-4 py-2">${archivoPreview}</td>
                    <td class="px-4 py-2">${estadoBadge}</td>
                    <td class="px-4 py-2 text-gray-300">${fechaCreacion}</td>
                    <td class="px-4 py-2">
                        <div class="flex gap-2">
                            <button onclick="editarGaleria(${item.id})" 
                                class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button onclick="eliminarGaleria(${item.id})" 
                                class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-8 text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Error al cargar la galería</p>
                        <button onclick="cargarGaleria()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
                            Reintentar
                        </button>
                    </td>
                </tr>
            `;
        });
}

function editarGaleria(id) {
    const editSection = document.getElementById('galeria-edit-section');
    const btnCreateGaleria = document.getElementById('btn-create-galeria');
    const galeriaContainer = document.getElementById('galeria-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnCreateGaleria) btnCreateGaleria.classList.add('hidden');
    if (galeriaContainer) galeriaContainer.classList.add('hidden');

    // Cargar datos del item
    fetch(`/api/galeria/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar item de galería');
            }
            return response.json();
        })
        .then(item => {
            const tituloInput = document.getElementById('edit-galeria-titulo');
            const descripcionInput = document.getElementById('edit-galeria-descripcion');
            const tipoSelect = document.getElementById('edit-galeria-tipo');
            const estadoSelect = document.getElementById('edit-galeria-estado');
            const imgPreview = document.getElementById('edit-galeria-preview');
            const videoPreview = document.getElementById('edit-galeria-video-preview');
            const editForm = document.getElementById('edit-galeria-form');

            if (tituloInput) tituloInput.value = item.titulo;
            if (descripcionInput) descripcionInput.value = item.descripcion || '';
            if (tipoSelect) tipoSelect.value = item.tipo;
            if (estadoSelect) estadoSelect.value = item.estado ? '1' : '0';
            if (editForm) editForm.dataset.id = item.id;

            // Mostrar preview del archivo actual
            if (item.archivo) {
                if (item.tipo === 'imagen' && imgPreview) {
                    imgPreview.src = `/storage/${item.archivo}`;
                    imgPreview.classList.remove('hidden');
                    if (videoPreview) videoPreview.classList.add('hidden');
                } else if (item.tipo === 'video' && videoPreview) {
                    videoPreview.src = `/storage/${item.archivo}`;
                    videoPreview.classList.remove('hidden');
                    if (imgPreview) imgPreview.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar item de galería:', error);
            alert('Error al cargar los datos del archivo');
        });
}

function eliminarGaleria(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este archivo?')) {
        fetch(`/api/galeria/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Archivo eliminado:', data);
            cargarGaleria(); // Recargar la lista
        })
        .catch(error => {
            console.error('Error al eliminar archivo:', error);
            alert('Error al eliminar el archivo');
        });
    }
}

// Cargar galería automáticamente cuando se carga el script
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#galeria-table-container')) {
        cargarGaleria();
    }
});
