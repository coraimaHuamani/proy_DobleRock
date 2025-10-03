document.addEventListener('DOMContentLoaded', () => {
  const playlistDetails = document.getElementById('playlist-details');
  const playlistList = document.getElementById('playlist-list');
  
  if(!playlistDetails && !playlistList) {
    return;
  }

  async function loadplaylist(id) {
      try {
          const res = await fetch(`/playlist/${id}/partial`);
          const html = await res.text();
          playlistDetails.innerHTML = html;
            playlistList.classList.add('hidden'); 
          playlistDetails.classList.remove('hidden');

          const script = document.createElement('script');
          script.src = '/js/songPlayer.js';
          document.body.appendChild(script);

          window.scrollTo({ top: 0, behavior: 'smooth' });
      } catch (err) {
          console.error('Error cargando álbum:', err);
      }
  }

  function checkHash() {
      const hash = window.location.hash;
      if (hash.startsWith('#playlist#id=')) {
          const playlistId = hash.split('=')[1];
          loadplaylist(playlistId);
      } else {
          playlistDetails.classList.add('hidden');
          playlistList.classList.remove('hidden');
          playlistDetails.innerHTML = '';
      }
  }

  window.addEventListener('hashchange', checkHash);
  checkHash();
});
