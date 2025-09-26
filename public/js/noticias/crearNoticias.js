import { cargarNoticias } from "./cargarNoticias.js";

document.addEventListener('DOMContentLoaded', () => {
  const btnCreateNews = document.getElementById('btn-create-news');
  const sectionCreate = document.getElementById('news-create-section');
  const sectionList = document.getElementById('news-container');

  if (btnCreateNews && sectionCreate && sectionList) {
    btnCreateNews.addEventListener('click', () => {
      sectionCreate.classList.remove('hidden');      
      sectionList.classList.add('hidden');           
      btnCreateNews.classList.add('hidden');
    });
  } else {
    console.warn("Elementos para crear noticia no encontrados.");
  }

  // AGREGADO: Preview de imagen al seleccionar
  const imageInput = document.getElementById("create-new-image");
  const imagePreview = document.getElementById("notice-image-preview");

  if (imageInput && imagePreview) {
    imageInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
          };
          reader.readAsDataURL(file);
        } else {
          alert('Por favor selecciona un archivo de imagen válido');
          imageInput.value = '';
        }
      } else {
        imagePreview.classList.add('hidden');
        imagePreview.src = '';
      }
    });
  }

  const btnGuardar = document.getElementById("btn-save-create-news");
  const btnCancelar = document.getElementById("btn-cancel-create-news");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", async (e) => {
      e.preventDefault();

      const form = document.getElementById("create-news-form");
      const token = localStorage.getItem('auth_token'); // AGREGADO

      if (!token) {
        alert('No estás autenticado. Por favor, inicia sesión.');
        window.location.href = '/login';
        return;
      }

      const formData = new FormData();
      formData.append("title", document.getElementById("create-new-title").value);
      formData.append("description", document.getElementById("create-new-description").value);
      formData.append("category", document.getElementById("create-new-category").value);
      formData.append("source_url", document.getElementById("create-new-url").value);

      const imageInput = document.getElementById("create-new-image");
      if (imageInput.files[0]) {
        formData.append("image", imageInput.files[0]);
      }

      try {
        const res = await fetch("/api/news", {
          method: "POST",
          headers: {
            'Authorization': `Bearer ${token}`, // AGREGADO
            'Accept': 'application/json'
            // No agregar Content-Type para FormData
          },
          body: formData,
        });

        if (!res.ok) {
          const error = await res.json();
          alert("Error al crear: " + JSON.stringify(error.errors || error.message));
          return;
        }

        alert("Noticia creada correctamente");

        document.getElementById("news-create-section").classList.add("hidden");
        document.getElementById("news-container").classList.remove("hidden");
        document.getElementById("btn-create-news").classList.remove("hidden");

        if (typeof cargarNoticias === "function") {
          await cargarNoticias();
        }

        form.reset();
        // MEJORADO: Limpiar preview
        if (imagePreview) {
          imagePreview.src = "";
          imagePreview.classList.add('hidden');
        }

      } catch (error) {
        console.error("Error al conectar con el servidor:", error);
        alert("Falló la conexión con el servidor.");
      }
    });
  } 

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      document.getElementById("news-create-section").classList.add("hidden");
      document.getElementById("news-container").classList.remove("hidden");
      document.getElementById("btn-create-news").classList.remove("hidden");
      
      // AGREGADO: Limpiar formulario y preview
      const form = document.getElementById("create-news-form");
      if (form) form.reset();
      if (imagePreview) {
        imagePreview.src = "";
        imagePreview.classList.add('hidden');
      }
    });
  }
});