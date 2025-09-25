document.addEventListener('DOMContentLoaded', () => {
  const btnCreateProducto = document.getElementById('btn-create-producto');
  const sectionCreate = document.getElementById('productos-create-section');
  const sectionList = document.getElementById('productos-container');

  if (btnCreateProducto && sectionCreate && sectionList) {
    btnCreateProducto.addEventListener('click', () => {
      console.log('Botón agregar producto clickeado'); // Debug
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateProducto.classList.add('hidden');
      
      // Cargar categorías en el select
      cargarCategoriasEnSelect();
    });
  } else {
    console.warn("Elementos para crear producto no encontrados.");
  }

  const btnGuardar = document.getElementById("btn-save-create-producto");
  const btnCancelar = document.getElementById("btn-cancel-create-producto");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-productos-form");

      try {
        const res = await fetch("/api/productos", {
          method: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nombre: document.getElementById("create-producto-nombre").value,
            descripcion: document.getElementById("create-producto-descripcion").value,
            precio: parseFloat(document.getElementById("create-producto-precio").value),
            categoria_id: parseInt(document.getElementById("create-producto-categoria").value) || null,
            stock: parseInt(document.getElementById("create-producto-stock").value)
          })
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Producto creado correctamente");

        document.getElementById("productos-create-section").classList.add("hidden");
        document.getElementById("productos-container").classList.remove("hidden");
        document.getElementById("btn-create-producto").classList.remove("hidden");

        if (typeof cargarProductos === "function") {
          cargarProductos();
        }

        form.reset();

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  }

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("productos-create-section").classList.add("hidden");
      document.getElementById("productos-container").classList.remove("hidden");
      document.getElementById("btn-create-producto").classList.remove("hidden");
    });
  }
});

// Función para cargar categorías en el select
async function cargarCategoriasEnSelect() {
  const categoriaSelect = document.getElementById('create-producto-categoria');
  
  try {
    const response = await fetch('/api/categorias');
    if (response.ok) {
      const categorias = await response.json();
      categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
      
      categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nombre;
        categoriaSelect.appendChild(option);
      });
    }
  } catch (error) {
    console.error('Error al cargar categorías:', error);
  }
}
