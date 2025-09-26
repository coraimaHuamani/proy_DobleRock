document.addEventListener('DOMContentLoaded', () => {

  const btnCancelar = document.getElementById('btn-cancel-edit-album');
  const btnGuardar = document.getElementById('btn-save-edit-album');
  const sectionEditar = document.getElementById('album-edit-section');
  const sectionListado = document.getElementById('albums-table-container');
  const btnAgregar = document.getElementById('btn-create-album');

  if (!btnCancelar || !btnGuardar || !sectionEditar || !sectionListado || !btnAgregar) {
    console.warn('No se encontraron algunos elementos del DOM necesarios para la edición.');
    return;
  }

  btnCancelar.addEventListener('click', () => {
    sectionEditar.classList.add('hidden');
    sectionListado.classList.remove('hidden');
    btnAgregar.classList.remove('hidden');
  });

  btnGuardar.addEventListener('click', async (e) => {
    e.preventDefault();
    const editForm = document.getElementById('edit-album-form');
    const albumId = editForm?.dataset.id;
    if (!albumId) return alert("No se encontró el ID de la canción");

    const formData = new FormData();
    formData.append("title", document.getElementById("edit-album-title").value);
    formData.append("year", document.getElementById("edit-album-year").value);
    const albumFileInput = document.getElementById("edit-album-file");
    if (albumFileInput.files.length > 0) {
      formData.append("file", albumFileInput.files[0]);
    } else {
      const filePath = editForm.dataset.filePath;
      if (filePath) {
        formData.append("file_path", filePath);
      }
    }
    
    try {
      const res = await fetch(`/api/albums/${albumId}`, {
        method: "POST",
        headers: { "X-HTTP-Method-Override": "PUT" },
        body: formData,
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        return alert("Error al editar: " + JSON.stringify(error.errors || error.message));
      }

      alert("Musica actualizada correctamente");
      if (typeof cargarAlbumes === "function") {
          cargarAlbumes();
        }
      sectionEditar.classList.add("hidden");
      sectionListado.classList.remove("hidden");
      btnAgregar.classList.remove("hidden");

    } catch (error) {
      alert("Error al conectar con el servidor");
    }
  });
});
