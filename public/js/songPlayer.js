document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('songPlayer');
    const isPlayer = !!audio; 

    // -------------------- PLAYER (iframe) --------------------
    if (isPlayer) {
        const npPlayPause = document.getElementById('npPlayPause');
        const npEq = document.getElementById('npEq');
        const npTitle = document.getElementById('npTitle');
        const npArtist = document.getElementById('npArtist');
        const npProgressBar = document.getElementById('npProgressBar');
        const npProgressFill = document.getElementById('npProgressFill');

        let currentSrc = null;

        function setGlobalState(playing) {
            npPlayPause.querySelector('.icon-play').classList.toggle('hidden', playing);
            npPlayPause.querySelector('.icon-pause').classList.toggle('hidden', !playing);
            npEq.classList.toggle('hidden', !playing);
        }

        function notifyParent(state) {
            window.parent.postMessage({ action: 'updateButton', ...state }, '*');
        }

        setInterval(() => {
            if (!audio.src) return;
            localStorage.setItem('playerState', JSON.stringify({
                src: audio.src,
                title: npTitle.textContent,
                artist: npArtist.textContent,
                currentTime: audio.currentTime,
                playing: !audio.paused
            }));
        }, 2000);

        const savedState = JSON.parse(localStorage.getItem('playerState') || '{}');
        if (savedState.src) {
            audio.src = savedState.src;
            npTitle.textContent = savedState.title || '—';
            npArtist.textContent = savedState.artist || '-';
            npPlayPause.disabled = false;
            currentSrc = savedState.src;

            const restoreTime = () => {
                if (savedState.currentTime && savedState.currentTime < audio.duration) {
                    audio.currentTime = savedState.currentTime;
                    if (savedState.playing) {
                        audio.play().then(() => setGlobalState(true))
                            .catch(err => console.warn('No se pudo continuar reproducción:', err));
                    } else {
                        setGlobalState(false);
                    }
                }
            };
            audio.addEventListener('loadedmetadata', restoreTime, { once: true });
        }

        function loadAndPlay(src, title, artist) {
            // misma canción 
            if (!src) {
                console.warn('Intento de reproducir sin archivo válido');
                npTitle.textContent = 'Archivo no disponible';
                npArtist.textContent = '';
                setGlobalState(false);
                return;
            }

            if (currentSrc && currentSrc === src) {
                if (audio.paused) {
                    audio.play();
                    setGlobalState(true);
                    notifyParent({ src, playing: true });
                } else {
                    audio.pause();
                    setGlobalState(false);
                    notifyParent({ src, playing: false });
                }
                return;
            }

            // canción nueva
            currentSrc = src;
            audio.src = src;
            audio.play().then(() => {
                npTitle.textContent = title || 'Reproduciendo';
                npArtist.textContent = artist || '';
                npPlayPause.disabled = false;
                setGlobalState(true);
                notifyParent({ src, playing: true });
            }).catch(err => console.error('No se pudo reproducir:', err));
        }

        window.addEventListener('message', (event) => {
            const data = event.data;
            if (data.action === 'play') {
                loadAndPlay(data.src, data.title, data.artist);
            } else if (data.action === 'pause') {
                audio.pause();
                setGlobalState(false);
                notifyParent({ src: audio.src, playing: false });
            }
        });

        npPlayPause.addEventListener('click', () => {
            if (!audio.src) return;
            if (audio.paused) {
                audio.play();
                setGlobalState(true);
                notifyParent({ src: audio.src, playing: true });
            } else {
                audio.pause();
                setGlobalState(false);
                notifyParent({ src: audio.src, playing: false });
            }
        });

        //Progreso 
        audio.addEventListener('timeupdate', () => {
            if (!audio.duration) return;
            npProgressFill.style.width = (audio.currentTime / audio.duration) * 100 + '%';
        });

        npProgressBar.addEventListener('click', (e) => {
            if (!audio.duration) return;
            const rect = npProgressBar.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const percent = Math.min(Math.max(clickX / rect.width, 0), 1);
            audio.currentTime = percent * audio.duration;
            npProgressFill.style.width = (percent * 100) + '%';
        });

        audio.addEventListener('ended', () => {
            setGlobalState(false);
            notifyParent({ src: audio.src, playing: false });
        });
    }

    else {
        let currentBtn = null;

        function setBtnState(btn, playing) {
            if (!btn) return;
            btn.setAttribute('aria-pressed', playing ? 'true' : 'false');
            btn.querySelector('.icon-play')?.classList.toggle('hidden', playing);
            btn.querySelector('.icon-pause')?.classList.toggle('hidden', !playing);
        }

        document.body.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-play');
            if (!btn) return;

            const src = btn.dataset.src;
            if (!src) {
                console.warn('No hay archivo de audio asociado a este botón.');
                btn.classList.add('opacity-60', 'cursor-not-allowed');
                btn.title = 'Sin audio disponible';
                return;
            }
            
            const payload = {
                action: 'play',
                src: btn.dataset.src,
                title: btn.dataset.title,
                artist: btn.dataset.artist
            };

            if (currentBtn && currentBtn !== btn) setBtnState(currentBtn, false);
            currentBtn = btn;

            const iframe = document.querySelector('iframe[src*="player"]');
            if (iframe) iframe.contentWindow.postMessage(payload, '*');
        });

        window.addEventListener('message', (event) => {
            const data = event.data;
            if (data.action === 'updateButton') {
                const btn = document.querySelector(`.btn-play[data-src="${data.src}"]`);
                if (btn) setBtnState(btn, data.playing);
            }
        });
    }
});
