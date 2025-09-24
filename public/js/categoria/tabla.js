const cargarCategorias = async () => {
  const tbody = document.querySelector('#categorias-table-container tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de categorías');
    return;
  }

  // Mostrar estado de carga
  tbody.innerHTML = `
    <tr>
      <td colspan="4" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando categorías...</p>
      </td>
    </tr>
  `;

  try {
    const response = await fetch('/api/categorias');
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar categorías',
      };
    }

    const categorias = await response.json();
    
    tbody.innerHTML = '';
    
    if (categorias.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="4" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-tags text-4xl mb-4"></i>
            <p>No hay categorías disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    categorias.forEach(categoria => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';

      tr.innerHTML = `
        <td class="px-4 py-2 text-white">${categoria.id}</td>
        <td class="px-4 py-2 text-white font-semibold">${categoria.nombre}</td>
        <td class="px-4 py-2 text-gray-300">${categoria.descripcion || 'Sin descripción'}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button onclick="editarCategoria(${categoria.id})" 
              class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button onclick="eliminarCategoria(${categoria.id})" 
              class="px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
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
        <td colspan="4" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar las categorías</p>
          <button onclick="cargarCategorias()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

function editarCategoria(id) {
  console.log('Editar categoría:', id);
  
  // Mostrar sección de editar y ocultar otras
  const editSection = document.getElementById('categorias-edit-section');
  const btnAddNew = document.getElementById('btn-create-categoria');
  const categoriasContainer = document.getElementById('categorias-container');

  if (editSection) editSection.classList.remove('hidden');
  if (btnAddNew) btnAddNew.classList.add('hidden');
  if (categoriasContainer) categoriasContainer.classList.add('hidden');

  // Cargar datos de la categoría
  fetch(`/api/categorias/${id}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al cargar categoría');
      }
      return response.json();
    })
    .then(categoria => {
      const nombreInput = document.getElementById('edit-categoria-nombre');
      const descripcionInput = document.getElementById('edit-categoria-descripcion');
      const editForm = document.getElementById('edit-categorias-form');

      if (nombreInput) nombreInput.value = categoria.nombre;
      if (descripcionInput) descripcionInput.value = categoria.descripcion || '';
      if (editForm) editForm.dataset.id = categoria.id;
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error al cargar los datos de la categoría');
    });
}

function eliminarCategoria(id) {
  if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
    fetch(`/api/categorias/${id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      console.log('Categoría eliminada:', data);
      cargarCategorias(); // Recargar la lista
    })
    .catch(error => {
      console.error('Error al eliminar categoría:', error);
      alert('Error al eliminar la categoría');
    });
  }
}

// Hacer las funciones disponibles globalmente
window.editarCategoria = editarCategoria;
window.eliminarCategoria = eliminarCategoria;
window.cargarCategorias = cargarCategorias;

// Cargar categorías automáticamente cuando se carga el script
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('#categorias-table-container')) {
    cargarCategorias();
  }
});
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('#categorias-table-container')) {
    cargarCategorias();
  }
});
