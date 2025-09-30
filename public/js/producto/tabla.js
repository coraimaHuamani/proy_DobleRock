const cargarProductos = async () => {
  console.log('Cargando productos...');
  const tbody = document.querySelector('#productos-table-container tbody');
  
  if (!tbody) {
    console.error('No se encontró la tabla de productos');
    return;
  }

  const token = localStorage.getItem('auth_token'); // AGREGADO

  if (!token) {
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>No estás autenticado</p>
          <a href="/login" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Iniciar sesión
          </a>
        </td>
      </tr>
    `;
    return;
  }

  // Mostrar estado de carga
  tbody.innerHTML = `
    <tr>
      <td colspan="7" class="text-center py-8 text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Cargando productos...</p>
      </td>
    </tr>
  `;

  try {
    const response = await fetch('/api/productos', {
      headers: {
        'Authorization': `Bearer ${token}`, // AGREGADO
        'Accept': 'application/json'
      }
    });
    
    console.log('Respuesta de API productos:', response);
    
    if (!response.ok) {
      const error = await response.json().catch(() => {});
      throw {
        message: error.message || 'Error al cargar productos',
      };
    }

    const productos = await response.json();
    console.log('Productos cargados:', productos);
    
    tbody.innerHTML = '';
    
    if (productos.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="7" class="text-center py-8 text-gray-400">
            <i class="fa-solid fa-box text-4xl mb-4"></i>
            <p>No hay productos disponibles</p>
          </td>
        </tr>
      `;
      return;
    }

    productos.forEach((producto, index) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-[#1a1a1a] transition-colors';

      // DEBUGGING: Log del producto
      console.log(`Producto ${index + 1}:`, {
        id: producto.id,
        nombre: producto.nombre,
        imagen: producto.imagen,
        imagen_path: producto.image_url ? producto.image_url : 'No imagen'
      });

      // Crear imagen thumbnail con mejor manejo de errores
      let imagenHtml;
      if (producto.image_url) {
        const imagenUrl = producto.image_url;
        imagenHtml = `
          <img src="${imagenUrl}" 
               alt="${producto.nombre}" 
               class="w-10 h-10 rounded object-cover"
               onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSIjNEM1MTY0Ii8+CjxwYXRoIGQ9Ik0yMCAyMkMyMS4xIDIyIDIyIDIxLjEgMjIgMjBDMjIgMTguOSAyMS4xIDE4IDIwIDE4QzE4LjkgMTggMTggMTguOSAxOCAyMEMxOCAyMS4xIDE4LjkgMjIgMjAgMjJaIiBmaWxsPSIjOUM5Qzk0Ii8+CjxwYXRoIGQ9Ik0xNiAyNkwyMCAyMkwyNCAyNkgxNloiIGZpbGw9IiM5QzlDOTQiLz4KPC9zdmc+'; this.classList.add('opacity-50');" 
           onload="console.log('✅ Imagen cargada:', '${imagenUrl}')"
           >
        `;
      } else {
        imagenHtml = `
          <div class="w-10 h-10 rounded bg-gray-600 flex items-center justify-center">
            <i class="fa-solid fa-image text-gray-400 text-xs"></i>
          </div>
        `;
      }

      tr.innerHTML = `
        <td class="px-4 py-2 text-white">${index + 1}</td>
        <td class="px-4 py-2 text-white font-semibold">${producto.nombre}</td>
        <td class="px-4 py-2 text-green-400 font-semibold">S/ ${parseFloat(producto.precio).toFixed(2)}</td>
        <td class="px-4 py-2 text-gray-300">${producto.categoria?.nombre || 'Sin categoría'}</td>
        <td class="px-4 py-2 text-white">${producto.stock}</td>
        <td class="px-4 py-2">${imagenHtml}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2">
            <button onclick="editarProducto(${producto.id})" 
              class="px-2 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition">
              <i class="fa-solid fa-edit"></i>
            </button>
            <button onclick="eliminarProducto(${producto.id})" 
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
        <td colspan="7" class="text-center py-8 text-red-400">
          <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
          <p>Error al cargar los productos</p>
          <button onclick="cargarProductos()" class="mt-2 px-3 py-1 bg-[#e7452e] hover:bg-orange-600 text-white rounded text-sm">
            Reintentar
          </button>
        </td>
      </tr>
    `;
  }
};

function editarProducto(id) {
  console.log('Editar producto:', id);
  
  const token = localStorage.getItem('auth_token'); // AGREGADO
  
  if (!token) {
    alert('No estás autenticado. Por favor, inicia sesión.');
    window.location.href = '/login';
    return;
  }
  
  // Mostrar sección de editar y ocultar otras
  const editSection = document.getElementById('productos-edit-section');
  const btnAddNew = document.getElementById('btn-create-producto');
  const productosContainer = document.getElementById('productos-container');

  if (editSection) editSection.classList.remove('hidden');
  if (btnAddNew) btnAddNew.classList.add('hidden');
  if (productosContainer) productosContainer.classList.add('hidden');

  // Cargar datos del producto y categorías
  Promise.all([
    fetch(`/api/productos/${id}`, {
      headers: {
        'Authorization': `Bearer ${token}`, // AGREGADO
        'Accept': 'application/json'
      }
    }),
    fetch('/api/categorias', {
      headers: {
        'Authorization': `Bearer ${token}`, // AGREGADO
        'Accept': 'application/json'
      }
    })
  ])
  .then(responses => Promise.all(responses.map(r => r.json())))
  .then(([producto, categorias]) => {
    const nombreInput = document.getElementById('edit-producto-nombre');
    const descripcionInput = document.getElementById('edit-producto-descripcion');
    const precioInput = document.getElementById('edit-producto-precio');
    const categoriaSelect = document.getElementById('edit-producto-categoria');
    const stockInput = document.getElementById('edit-producto-stock');
    const previewImg = document.getElementById('edit-producto-preview');
    const editForm = document.getElementById('edit-productos-form');

    if (nombreInput) nombreInput.value = producto.nombre;
    if (descripcionInput) descripcionInput.value = producto.descripcion || '';
    if (precioInput) precioInput.value = producto.precio;
    if (stockInput) stockInput.value = producto.stock;
    if (editForm) editForm.dataset.id = producto.id;

    // Mostrar imagen actual
    if (previewImg && producto.image_url) {
      previewImg.src = producto.image_url;
    }

    // Cargar categorías en el select
    if (categoriaSelect) {
      categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
      categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nombre;
        if (producto.categoria_id == categoria.id) {
          option.selected = true;
        }
        categoriaSelect.appendChild(option);
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al cargar los datos del producto');
  });
}

function eliminarProducto(id) {
  const token = localStorage.getItem('auth_token'); // AGREGADO
  
  if (!token) {
    alert('No estás autenticado. Por favor, inicia sesión.');
    window.location.href = '/login';
    return;
  }

  if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
    fetch(`/api/productos/${id}`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${token}`, // AGREGADO
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al eliminar producto');
      }
      return response.json();
    })
    .then(data => {
      console.log('Producto eliminado:', data);
      alert('Producto eliminado correctamente');
      cargarProductos(); // Recargar la lista
    })
    .catch(error => {
      console.error('Error al eliminar producto:', error);
      alert('Error al eliminar el producto');
    });
  }
}

// Hacer las funciones disponibles globalmente
window.editarProducto = editarProducto;
window.eliminarProducto = eliminarProducto;
window.cargarProductos = cargarProductos;

// Auto-ejecutar al cargar el script si la tabla existe
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('#productos-table-container')) {
    console.log('Auto-cargando productos al cargar la página...');
    cargarProductos();
  }
});
