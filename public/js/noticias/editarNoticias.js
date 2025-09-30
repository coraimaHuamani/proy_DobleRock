import { cargarNoticias } from "./cargarNoticias.js";

document.addEventListener('DOMContentLoaded', () => {
  const btnCancelar = document.getElementById('btn-cancel-edit');
  const btnGuardar = document.getElementById('btn-save-edit');
  const sectionEditar = document.getElementById('news-edit-section');
  const sectionListado = document.getElementById('news-container');
  const btnAgregar = document.getElementById('btn-create-news');

  if (!btnCancelar || !btnGuardar || !sectionEditar || !sectionListado || !btnAgregar) {
    console.warn('No se encontraron algunos elementos del DOM necesarios para la edición.');
    return;
  }

  // AGREGADO: Preview de imagen al cambiar
  const imageInput = document.getElementById("edit-new-image");
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
      }
    });
  }

  btnCancelar.addEventListener('click', () => {
    document.getElementById('news-edit-section').classList.add('hidden');
    document.getElementById('news-container').classList.remove('hidden');
    document.getElementById('btn-create-news').classList.remove('hidden');
  });

  btnGuardar.addEventListener('click', async (e) => {
    e.preventDefault();
    
    const newsId = document.getElementById('edit-news-form')?.getAttribute('data-id');
    if (!newsId) return alert("No se encontró el ID de la noticia");

    const token = localStorage.getItem('auth_token'); // AGREGADO

    if (!token) {
      alert('No estás autenticado. Por favor, inicia sesión.');
      window.location.href = '/login';
      return;
    }

    const formData = new FormData();
    formData.append("_method", "PUT");
    formData.append("title", document.getElementById("edit-new-title").value);
    formData.append("description", document.getElementById("edit-new-description").value);
    formData.append("category", document.getElementById("edit-new-category").value);
    formData.append("source_url", document.getElementById("edit-new-url").value);
    
    const imageInput = document.getElementById("edit-new-image");
    if (imageInput?.files[0]) {
      formData.append("image", imageInput.files[0]);
    }

    if(!formData.get("title") || !formData.get("description") || !formData.get("category") || !formData.get("source_url")) {
      alert("Por favor, completa todos los campos.");
      return;
    }

    try {
      const res = await fetch(`/api/news/${newsId}`, {
        method: "POST", 
        headers: {
          'Authorization': `Bearer ${token}`, // AGREGADO
          'Accept': 'application/json'
        
        },
        body: formData,
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        return alert("Error al editar: " + JSON.stringify(error.errors || error.message));
      }

      alert("Noticia actualizada correctamente");
      await cargarNoticias(); 
      document.getElementById("news-edit-section").classList.add("hidden");
      document.getElementById("news-container").classList.remove("hidden");
      document.getElementById("btn-create-news").classList.remove("hidden");

    } catch (error) {
      alert("Error al conectar con el servidor");
      console.error(error);
    }
  });
});
