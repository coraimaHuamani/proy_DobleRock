// Slider JS
        (function() {
            const track = document.getElementById('slider-track');
            const dots = document.querySelectorAll('.slider-dot');
            const prev = document.getElementById('slider-prev');
            const next = document.getElementById('slider-next');
            let idx = 0;
            function showSlide(i) {
                idx = (i+2)%2;
                track.style.transform = `translateX(-${idx*100}%)`;
                dots.forEach((d, j) => d.classList.toggle('bg-white/70', j===idx));
            }
            prev.onclick = () => showSlide(idx-1);
            next.onclick = () => showSlide(idx+1);
            dots.forEach((d, i) => d.onclick = () => showSlide(i));
            showSlide(0);
        })();

        // Filtro de búsqueda actualizado para buscar en todas las secciones
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-product');
            const productosSections = document.querySelectorAll('.productos-section');
            
            if (!input) return;
            
            input.addEventListener('input', function() {
                const val = input.value.trim().toLowerCase();
                
                productosSections.forEach(section => {
                    const cards = section.querySelectorAll('h3');
                    
                    cards.forEach(h3 => {
                        const card = h3.closest('.bg-transparent');
                        if (!val || h3.textContent.toLowerCase().includes(val)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });

        // Modal de producto agregado
        function showAddModal() {
            const modal = document.getElementById('add-modal');
            if (!modal) return;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
            }, 1800);
        }

        // Agregar al carrito - actualizado para trabajar con el nuevo formato
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-btn');
            if (btn && !btn.textContent.includes('Sin stock')) {
                showAddModal();
                console.log('Producto agregado:', JSON.parse(btn.dataset.product));
            }
        });