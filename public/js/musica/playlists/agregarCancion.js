document.addEventListener("DOMContentLoaded", () => {
  const btnAddSong = document.getElementById("btn-add-song-to-playlist");
  const table = document.getElementById("playlist-songs-table");

  if (!btnAddSong || !table) {
    console.warn("Botón o tabla de canciones no encontrados");
    return;
  }

  btnAddSong.addEventListener("click", () => {
    const select = document.getElementById("add-song-to-playlist");
    const songId = select.value;
    const songText = select.options[select.selectedIndex]?.text;

    if (!songId) {
      alert("Debes seleccionar una canción");
      return;
    }

    if (playlistSongsTemp.some(s => s.id == songId)) {
      alert("La canción ya está en la lista");
      return;
    }

    playlistSongsTemp.push({ id: songId, text: songText });

    const tr = document.createElement("tr");
    tr.dataset.id = songId;
    tr.innerHTML = `
      <td class="px-4 py-2">${playlistSongsTemp.length}</td>
      <td class="px-4 py-2">${songText}</td>
      <td class="px-4 py-2 text-center">
        <button class="btn-remove-temp px-2 py-1 bg-red-600 text-white rounded" data-id="${songId}">
          <i class="fa-solid fa-trash"></i>
        </button>
      </td>
    `;
    table.appendChild(tr);

    tr.querySelector(".btn-remove-song").addEventListener("click", () => {
      if (song.id) {
        removedSongs.push(song.id);
      } else {
        playlistSongsTemp = playlistSongsTemp.filter(s => s.id !== song.tempId);
      }
      tr.remove();
    });
  });
});
