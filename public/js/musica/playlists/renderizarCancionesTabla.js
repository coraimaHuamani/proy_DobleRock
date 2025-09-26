// Renderiza la tabla de canciones
export const renderizarCancionesTabla = (songs) => {
  const table = document.getElementById("playlist-songs-table");
  const editForm = document.getElementById("edit-playlist-form");
  const playlistId = editForm?.dataset.id;
  if (!table || !playlistId) return;

  table.innerHTML = "";

  songs.forEach((song, index) => {
    const tr = document.createElement("tr");
    tr.dataset.id = song.id; 
    tr.innerHTML = `
      <td class="px-4 py-2">${index + 1}</td>
      <td class="px-4 py-2">${song.title}</td>
      <td class="px-4 py-2">${song.artist}</td>
      <td class="px-4 py-2 text-center">
        <button type="button" class="btn-remove-song px-2 py-1 bg-red-600 text-white rounded" data-id="${song.id}">
          <i class="fa-solid fa-trash"></i>
        </button>
      </td>
    `;
    table.appendChild(tr);
  });

 
  table.querySelectorAll(".btn-remove-song").forEach(btn => {
    btn.addEventListener("click", async (e) => {
      const songId = e.currentTarget.dataset.id;
      const token = localStorage.getItem("auth_token");
      if (!token) {
        alert("No tienes autorización. Inicia sesión nuevamente.");
        window.location.href = "/login";
        return;
      }
      const res = await fetch(`/api/playlists/${playlistId}/songs`, {
        method: "DELETE",
        headers: {
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json",
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ song_ids: [songId] })
      });

      if (res.ok) {
        const updatedPlaylist = await (await fetch(`/api/playlists/${playlistId}`, {
          headers: {
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
          }
        })).json();

        renderizarCancionesTabla(updatedPlaylist.songs || []);
      }
    });
  });
};

