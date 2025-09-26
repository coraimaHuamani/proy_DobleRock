document.addEventListener('DOMContentLoaded', () => {
  const btnCreateProducto = document.getElementById('btn-create-producto');
  const sectionCreate = document.getElementById('productos-create-section');
  const sectionList = document.getElementById('productos-container');

  if (btnCreateProducto && sectionCreate && sectionList) {
    btnCreateProducto.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateProducto.classList.add('hidden');

      // Cargar categorías en el select
      loadCategorias();
    });
  }

  // Función para cargar categorías
  async function loadCategorias() {
    const token = localStorage.getItem('auth_token'); // AGREGADO

    if (!token) {
      alert('No estás autenticado. Por favor, inicia sesión.');
      window.location.href = '/login';
      return;
    }

    try {
      const response = await fetch('/api/categorias', {
        headers: {
          'Authorization': `Bearer ${token}`, // AGREGADO
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('Error al cargar categorías');
      }

      const categorias = await response.json();
      
      const select = document.getElementById('create-producto-categoria');
      if (select) {
        select.innerHTML = '<option value="">Seleccionar categoría</option>';
        categorias.forEach(categoria => {
          const option = document.createElement('option');
          option.value = categoria.id;
          option.textContent = categoria.nombre;
          select.appendChild(option);
        });
      }
    } catch (error) {
      console.error('Error al cargar categorías:', error);
      alert('Error al cargar las categorías');
    }
  }

  const btnGuardar = document.getElementById("btn-save-create-producto");
  const btnCancelar = document.getElementById("btn-cancel-create-producto");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-productos-form");
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      const formData = new FormData();

      formData.append("nombre", document.getElementById("create-producto-nombre").value);
      formData.append("descripcion", document.getElementById("create-producto-descripcion").value);
      formData.append("precio", document.getElementById("create-producto-precio").value);
      formData.append("categoria_id", document.getElementById("create-producto-categoria").value);
      formData.append("stock", document.getElementById("create-producto-stock").value);

      const imageInput = document.getElementById("create-producto-imagen");
      if (imageInput.files[0]) {
        formData.append("imagen", imageInput.files[0]);
      }

      try {
        const res = await fetch("/api/productos", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json'
            // No agregar Content-Type para FormData - el navegador lo establece automáticamente
          },
          body: formData,
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
        // Limpiar preview
        const preview = document.getElementById("create-producto-preview");
        const placeholder = document.getElementById("create-producto-placeholder");
        if (preview && placeholder) {
          preview.classList.add("hidden");
          placeholder.classList.remove("hidden");
        }

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
