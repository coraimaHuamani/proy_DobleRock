document.addEventListener("DOMContentLoaded", () => {
  const btnAddSong = document.getElementById("btn-add-song-to-playlist");
  const selectSongs = document.getElementById("add-song-to-playlist");
  const table = document.getElementById("playlist-songs-table");

  // Llenar el combobox con TODAS las canciones de la BD
  async function cargarCancionesEnSelect() {
    try {
      const res = await fetch("/api/songs");
      if (!res.ok) throw new Error("Error al cargar canciones");

      const songs = await res.json();
      selectSongs.innerHTML = `<option value="">Seleccionar canción</option>`;

      songs.forEach(song => {
        const option = document.createElement("option");
        option.value = song.id;
        option.textContent = `${song.title} - ${song.artist}`;
        selectSongs.appendChild(option);
      });
    } catch (err) {
      console.error("Error cargando canciones:", err);
      selectSongs.innerHTML = `<option value="">Error al cargar canciones</option>`;
    }
  }

  // Función para refrescar la tabla
  function renderSongsTable(songs = []) {
    table.innerHTML = "";
    if (!songs || songs.length === 0) {
      table.innerHTML = `
        <tr>
          <td colspan="4" class="text-center py-4 text-gray-400">
            No hay canciones en esta playlist
          </td>
        </tr>
      `;
      return;
    }

    songs.forEach((song, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td class="px-4 py-2">${index + 1}</td>
        <td class="px-4 py-2">${song.title}</td>
        <td class="px-4 py-2">${song.artist}</td>
        <td class="px-4 py-2 text-center">
          <button class="btn-remove-song px-2 py-1 bg-red-600 text-white rounded" data-id="${song.id}">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      `;
      table.appendChild(tr);
    });
  }

  // Acción del botón Agregar Canción
  if (btnAddSong && selectSongs) {
    btnAddSong.addEventListener("click", async () => {
      const editForm = document.getElementById("edit-playlist-form");
      const playlistId = editForm?.dataset.id;
      const songId = selectSongs.value;

      if (!playlistId) return alert("No se encontró el ID de la playlist");
      if (!songId) return alert("Debes seleccionar una canción");

      try {
        const res = await fetch(`/api/playlists/${playlistId}/songs`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ song_id: songId })
        });

        if (!res.ok) {
          const error = await res.json().catch(() => ({}));
          return alert("Error al agregar canción: " + (error.message || "desconocido"));
        }

        const updatedPlaylist = await res.json();
        renderSongsTable(updatedPlaylist.songs);

        alert("Canción agregada correctamente");
      } catch (error) {
        console.error(error);
        alert("Error al conectar con el servidor");
      }
    });
  }
  if( typeof cargarCancionesEnSelect === "function" ) {
    cargarCancionesEnSelect();
  }
});
