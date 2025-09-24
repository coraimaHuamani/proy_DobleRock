        document.addEventListener('DOMContentLoaded', () => {
            // Filtros actualizados para usar 'imagen' y 'video'
            const buttons = document.querySelectorAll('.filter-btn');
            const cards = document.querySelectorAll('.card');
            buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    buttons.forEach(b => b.classList.remove('active-filter'));
                    btn.classList.add('active-filter');
                    // ripple
                    const rect = btn.getBoundingClientRect();
                    btn.style.setProperty('--rx', (e.clientX - rect.left) + 'px');
                    btn.style.setProperty('--ry', (e.clientY - rect.top) + 'px');
                    btn.classList.add('rippling');
                    setTimeout(() => btn.classList.remove('rippling'), 350);

                    const filter = btn.dataset.filter;
                    cards.forEach(card => {
                        const isPhoto = card.classList.contains('media-foto');
                        const isVideo = card.classList.contains('media-video');
                        let show = (filter === 'all') || (filter === 'imagen' && isPhoto) || (filter === 'video' && isVideo);
                        card.style.display = show ? '' : 'none';
                    });
                });
            });

            // Reveal on scroll (IntersectionObserver)
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('revealed');
                });
            }, {
                threshold: 0.12
            });
            document.querySelectorAll('.reveal').forEach(el => io.observe(el));

            // Lightbox
            const lb = document.getElementById('lightbox');
            const lbBackdrop = lb.children[0];
            const lbBox = lb.children[1];
            const lbContent = document.getElementById('lbContent');
            const lbClose = document.getElementById('lbClose');

            function openLB(type, src) {
                lb.classList.remove('hidden');
                lb.classList.add('flex');
                // reset transitions start
                lbBackdrop.classList.remove('opacity-0');
                lbBox.classList.remove('opacity-0', 'scale-95');
                lb.classList.add('show');

                lbContent.innerHTML = '';
                if (type === 'image') {
                    const img = document.createElement('img');
                    img.src = src;
                    img.alt = 'preview';
                    img.className = 'w-full h-auto';
                    lbContent.appendChild(img);
                } else {
                    const vid = document.createElement('video');
                    vid.src = src;
                    vid.controls = true;
                    vid.autoplay = true;
                    vid.className = 'w-full h-auto';
                    lbContent.appendChild(vid);
                }
            }

            function closeLB() {
                lb.classList.remove('show');
                // end animation then hide
                setTimeout(() => {
                    lb.classList.add('hidden');
                    lb.classList.remove('flex');
                    lbContent.innerHTML = '';
                }, 180);
                lbBackdrop.classList.add('opacity-0');
                lbBox.classList.add('opacity-0', 'scale-95');
            }
            
            document.querySelectorAll('.open-lightbox').forEach(btn => {
                btn.addEventListener('click', () => openLB(btn.dataset.type, btn.dataset.src));
            });
            lbBackdrop.addEventListener('click', closeLB);
            lbClose.addEventListener('click', closeLB);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !lb.classList.contains('hidden')) closeLB();
            });

            // Parallax leve en el vinilo
            const vinyl = document.getElementById('vinylParallax');
            vinyl?.addEventListener('mousemove', (e) => {
                const r = vinyl.getBoundingClientRect();
                const cx = r.left + r.width / 2,
                    cy = r.top + r.height / 2;
                const dx = (e.clientX - cx) / r.width,
                    dy = (e.clientY - cy) / r.height;
                vinyl.style.transform = `translateZ(0) rotateX(${ -dy * 8 }deg) rotateY(${ dx * 8 }deg)`;
            });
            vinyl?.addEventListener('mouseleave', () => {
                vinyl.style.transform = 'rotateX(0) rotateY(0)';
            });
        });