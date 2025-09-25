const cargarGaleria = async () => {
    console.log('Cargando galería...');
    const tbody = document.querySelector('#galeria-table-container tbody');
    if (!tbody) return console.error('No se encontró la tabla de galería');

    // Mostrar estado de carga
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                <p>Cargando galería...</p>
            </td>
        </tr>
    `;

    try {
        const response = await fetch('/api/galeria');
        if (!response.ok) {
            const error = await response.json().catch(() => {});
            throw { message: error?.message || 'Error al cargar galería' };
        }
        const galerias = await response.json();
        tbody.innerHTML = '';

        if (galerias.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">
                        <i class="fa-solid fa-images text-4xl mb-4"></i>
                        <p>No hay elementos en la galería</p>
                    </td>
                </tr>
            `;
            return;
        }

        galerias.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-[#1a1a1a] transition-colors';

            const tipoBadge = item.tipo === 'imagen'
                ? '<span class="px-2 py-1 text-xs bg-green-600 text-white rounded">Imagen</span>'
                : '<span class="px-2 py-1 text-xs bg-orange-600 text-white rounded">Video</span>';

            const archivoPreview = item.archivo
                ? (item.tipo === 'imagen'
                    ? `<img src="/storage/${item.archivo}" alt="${item.titulo}" class="w-10 h-10 rounded object-cover">`
                    : `<div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
                           <i class="fa-solid fa-video text-gray-400 text-xs"></i>
                       </div>`)
                : `<div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
                       <i class="fa-solid fa-file text-gray-400 text-xs"></i>
                   </div>`;

            tr.innerHTML = `
                <td class="px-4 py-2 text-white">${index + 1}</td>
                <td class="px-4 py-2 text-white font-semibold">${item.titulo}</td>
                <td class="px-4 py-2 text-gray-300">${item.descripcion || 'Sin descripción'}</td>
                <td class="px-4 py-2">${tipoBadge}</td>
                <td class="px-4 py-2">${archivoPreview}</td>
                <td class="px-4 py-2">
                    <div class="flex gap-2">
                        <button onclick="editarGaleria(${item.id})" class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button onclick="eliminarGaleria(${item.id})" class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;

            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-8 text-red-400">
                    <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Error al cargar la galería</p>
                    <button onclick="cargarGaleria()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
                        Reintentar
                    </button>
                </td>
            </tr>
        `;
    }
};

function editarGaleria(id) {
    console.log('Editar galería:', id);
    
    // Mostrar sección de editar y ocultar otras
    const editSection = document.getElementById('galeria-edit-section');
    const btnAddNew = document.getElementById('btn-create-galeria');
    const galeriaContainer = document.getElementById('galeria-container');

    if (editSection) editSection.classList.remove('hidden');
    if (btnAddNew) btnAddNew.classList.add('hidden');
    if (galeriaContainer) galeriaContainer.classList.add('hidden');

    // Cargar datos del elemento de galería
    fetch(`/api/galeria/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar elemento de galería');
            }
            return response.json();
        })
        .then(item => {
            const tituloInput = document.getElementById('edit-galeria-titulo');
            const descripcionInput = document.getElementById('edit-galeria-descripcion');
            const tipoSelect = document.getElementById('edit-galeria-tipo');
            const editForm = document.getElementById('edit-galeria-form');
            const imgPreview = document.getElementById('edit-galeria-img-preview');
            const videoPreview = document.getElementById('edit-galeria-video-preview');

            if (tituloInput) tituloInput.value = item.titulo;
            if (descripcionInput) descripcionInput.value = item.descripcion || '';
            if (tipoSelect) tipoSelect.value = item.tipo;
            if (editForm) editForm.dataset.id = item.id;

            // Mostrar preview del archivo actual
            if (item.archivo && imgPreview && videoPreview) {
                if (item.tipo === 'imagen') {
                    imgPreview.src = `/storage/${item.archivo}`;
                    imgPreview.classList.remove('hidden');
                    videoPreview.classList.add('hidden');
                } else if (item.tipo === 'video') {
                    videoPreview.src = `/storage/${item.archivo}`;
                    videoPreview.classList.remove('hidden');
                    imgPreview.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos del elemento');
        });
}

function eliminarGaleria(id) {
    if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) return;

    fetch(`/api/galeria/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (!response.ok) throw new Error('Error al eliminar');
        return response.json().catch(() => ({}));
    })
    .then(data => {
        console.log('Elemento eliminado:', data);
        cargarGaleria();
    })
    .catch(error => {
        console.error('Error al eliminar elemento:', error);
        alert('Error al eliminar el elemento');
    });
}

window.editarGaleria = editarGaleria;
window.eliminarGaleria = eliminarGaleria;
window.cargarGaleria = cargarGaleria;

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#galeria-table-container')) {
        cargarGaleria();
    }
});
