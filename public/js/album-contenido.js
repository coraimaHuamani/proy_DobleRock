document.addEventListener('DOMContentLoaded', () => {
    const albumDetails = document.getElementById('album-details');
    const albumList = document.getElementById('album-list');

    if(!albumDetails && !albumList) {
        return;
    }
    async function loadAlbum(id) {
        try {
            const res = await fetch(`/album/${id}/partial`);
            const html = await res.text();
            albumDetails.innerHTML = html;
            albumList.classList.add('hidden'); 
            albumDetails.classList.remove('hidden');

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
        if (hash.startsWith('#album#id=')) {
            const albumId = hash.split('=')[1];
            loadAlbum(albumId);
        } else {
            albumDetails.classList.add('hidden');
            albumList.classList.remove('hidden');
            albumDetails.innerHTML = '';
        }
    }

    window.addEventListener('hashchange', checkHash);
    checkHash();
});
