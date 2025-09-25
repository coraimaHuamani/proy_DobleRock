   // Validar stock en inputs de cantidad
        function validateStock(input, maxStock) {
            const value = parseInt(input.value);
            if (value > maxStock) {
                // Mostrar modal de error personalizado
                showStockErrorModal(`No puedes seleccionar más de ${maxStock} productos. Stock disponible: ${maxStock}`);
                input.value = maxStock;
            } else if (value < 1) {
                input.value = 1;
            }
        }
        
        // Función para mostrar modal de error de stock
        function showStockErrorModal(message) {
            let errorModal = document.getElementById('stock-error-modal');
            if (!errorModal) {
                errorModal = document.createElement('div');
                errorModal.id = 'stock-error-modal';
                errorModal.className = 'fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-[#181818] text-white px-6 py-3 rounded-lg shadow-lg border border-red-500 flex items-center gap-3 opacity-0 pointer-events-none transition-all duration-300';
                errorModal.innerHTML = `
                    <i class="fa-solid fa-exclamation-triangle text-red-500 text-xl"></i>
                    <span id="error-message" class="font-mono text-sm"></span>
                `;
                document.body.appendChild(errorModal);
            }

            const messageSpan = errorModal.querySelector('#error-message');
            if (messageSpan) messageSpan.textContent = message;

            errorModal.classList.remove('opacity-0', 'pointer-events-none');
            errorModal.classList.add('opacity-100');
            
            setTimeout(() => {
                errorModal.classList.add('opacity-0', 'pointer-events-none');
                errorModal.classList.remove('opacity-100');
            }, 3000);
        }
        
        // Hacer las funciones globales
        window.validateStock = validateStock;
        window.showStockErrorModal = showStockErrorModal;