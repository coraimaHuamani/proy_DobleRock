const mmssToSeconds = (mmss) => {
  if (!mmss) return 0;
  const [m, s] = mmss.split(":").map(Number);
  if (isNaN(m) || isNaN(s)) return 0;
  return m * 60 + s;
}


document.addEventListener('DOMContentLoaded', () => {

  const btnCancelar = document.getElementById('btn-cancel-edit-song');
  const btnGuardar = document.getElementById('btn-save-edit-song');
  const sectionEditar = document.getElementById('song-edit-section');
  const sectionListado = document.getElementById('songs-table-container');
  const btnAgregar = document.getElementById('btn-create-song');

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
    const editForm = document.getElementById('edit-song-form');
    const songId = editForm?.dataset.id;
    if (!songId) return alert("No se encontró el ID de la canción");
    
    const formData = new FormData();
    formData.append("title", document.getElementById("edit-song-title").value);
    formData.append("artist", document.getElementById("edit-song-artist").value);
    formData.append("genre", document.getElementById("edit-song-genre").value);
    formData.append("duration", mmssToSeconds(document.getElementById("edit-song-duration").value));
    const songFileInput = document.getElementById("edit-song-file");
    if (songFileInput.files.length > 0) {
      formData.append("file", songFileInput.files[0]);
    } else {
      const filePath = editForm.dataset.filePath;
      if (filePath) {
        formData.append("file_path", filePath);
      }
    }

    const token = localStorage.getItem('auth_token');
    if (!token) return alert("No se encontró el token de autenticación");

    try {
      const res = await fetch(`/api/songs/${songId}`, {
        method: "POST",
        headers: { "X-HTTP-Method-Override": "PUT", 'Authorization': `Bearer ${token}`, "Accept": "application/json" },
        body: formData,
      });

      if (!res.ok) {
        const error = await res.json().catch(() => ({}));
        return alert("Error al editar: " + JSON.stringify(error.errors || error.message));
      }

      alert("Musica actualizada correctamente");
      if (typeof cargarCanciones === "function") {
          cargarCanciones();
        }
      sectionEditar.classList.add("hidden");
      sectionListado.classList.remove("hidden");
      btnAgregar.classList.remove("hidden");

    } catch (error) {
      alert("Error al conectar con el servidor");
    }
  });
});
