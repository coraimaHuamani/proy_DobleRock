cargarCancionesSelect = async (selectElementId) => {
  const select = document.getElementById(selectElementId);
  if (!select) {
    console.warn(`No se encontró el elemento <select> con id="${selectElementId}"`);
    return;
  }

  try {
    const res = await fetch("/api/songs");
    if (!res.ok) throw new Error("Error al cargar canciones");

    const songs = await res.json();

    select.innerHTML = `<option value="">Seleccionar canción</option>`;

    if (!songs || songs.length === 0) {
      select.innerHTML = `<option value="">No hay canciones disponibles</option>`;
      return;
    }

    songs.forEach(song => {
      const option = document.createElement("option");
      option.value = song.id;
      option.textContent = `${song.title} - ${song.artist}`;
      select.appendChild(option);
    });
  } catch (error) {
    console.error("Error cargando canciones:", error);
    select.innerHTML = `<option value="">Error al cargar canciones</option>`;
  }
}
