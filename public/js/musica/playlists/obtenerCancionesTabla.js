export const getSongsFromTable = () => {
  const rows = document.querySelectorAll("#playlist-songs-table tr");
  let songIds = [];

  rows.forEach(row => {
    const id = row.dataset.id;
    if (id) songIds.push(parseInt(id));
  });

  return songIds;
};
