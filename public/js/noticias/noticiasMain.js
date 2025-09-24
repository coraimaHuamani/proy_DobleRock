 document.addEventListener('DOMContentLoaded', () => {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) e.target.classList.add('revealed');
                });
            }, {
                threshold: .14
            });

            // Observar todas las tarjetas para animación de entrada
            document.querySelectorAll('.news-card').forEach(card => {
                io.observe(card);
            });

            // Funcionalidad del botón "Ver más" si existe
            const btn = document.getElementById('more-events-btn');
            if (btn) {
                btn.addEventListener('click', (ev) => {
                    // Ripple effect
                    const rect = btn.getBoundingClientRect();
                    btn.style.setProperty('--rx', (ev.clientX - rect.left) + 'px');
                    btn.style.setProperty('--ry', (ev.clientY - rect.top) + 'px');
                    btn.classList.add('rippling');

                    const text = btn.querySelector('span');
                    const spinner = btn.querySelector('.spinner');

                    if (spinner) spinner.classList.remove('hidden');
                    if (text) text.textContent = 'Cargando…';
                    btn.disabled = true;

                    setTimeout(() => {
                        // Aquí puedes implementar paginación AJAX si lo necesitas
                        window.location.href = "{{ route('noticias') }}";
                    }, 450);
                });
            }
        });