(function() {
                const btn = document.getElementById('playBtn');
                const icon = document.getElementById('playIcon');
                const audio = document.getElementById('radioPlayer');
                const wrapper = document.getElementById('radioWrapper');
                if (!btn || !icon || !audio || !wrapper) return;

                let playing = false;
                const setPlayingUI = (on) => {
                    playing = on;
                    icon.classList.toggle('fa-play', !on);
                    icon.classList.toggle('fa-pause', on);
                    btn.setAttribute('aria-label', on ? 'Pause' : 'Play');
                    wrapper.classList.toggle('is-playing', on);
                };

                btn.addEventListener('click', async () => {
                    try {
                        if (!playing) {
                            await audio.play();
                            setPlayingUI(true);
                        } else {
                            audio.pause();
                            setPlayingUI(false);
                        }
                    } catch (e) {
                        console.error(e);
                    }
                });

                audio.addEventListener('play', () => setPlayingUI(true));
                audio.addEventListener('pause', () => setPlayingUI(false));
                audio.addEventListener('stalled', () => setPlayingUI(false));
            })();