// === CARRITO GLOBAL ===
(function() {
    const STORAGE_KEY = 'cart';
    const $countBadge = document.getElementById('cart-count');
    const $countBadgeMobile = document.getElementById('cart-count-mobile');
    const $cartPanel = document.getElementById('cart-panel');
    const $cartList = document.getElementById('cart-items');
    const $cartTotalEl = document.getElementById('cart-total');
    const $openCartBtn = document.getElementById('open-cart');
    const $openCartBtnMobile = document.getElementById('open-cart-mobile');
    const $closeCartBtn = document.getElementById('close-cart');
    
    // Fondo oscuro para cerrar carrito - selector corregido
    let $cartOverlay = null;
    if ($cartPanel) {
        $cartOverlay = $cartPanel.querySelector('.fixed.inset-0.bg-black\\/50');
        if (!$cartOverlay) {
            // Buscar por clases separadas si el selector con escape no funciona
            $cartOverlay = $cartPanel.querySelector('.fixed.inset-0');
        }
    }

    function loadCart() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
        } catch {
            return [];
        }
    }

    function saveCart(cart) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        console.log('Carrito guardado:', cart); // Debug
    }

    function format(n) {
        return 'S/ ' + parseFloat(n).toFixed(2);
    }

    function getQtyFor(id) {
        const input = document.querySelector(`.qty-input[data-id="${id}"]`);
        let q = parseInt(input?.value ?? '1', 10);
        if (isNaN(q) || q < 1) q = 1;
        console.log('Cantidad obtenida:', q, 'para ID:', id); // Debug
        return q;
    }

    function showErrorModal(message) {
        // Crear modal de error si no existe
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
        }, 3000); // 3 segundos para mensaje de error
    }

    function addItem(product, qty) {
        console.log('Agregando producto:', product, 'cantidad:', qty); // Debug
        const cart = loadCart();
        const idx = cart.findIndex(i => i.id === parseInt(product.id));
        
        let newQty = qty;
        if (idx >= 0) {
            // Si ya existe, verificar que no exceda el stock
            const currentQty = cart[idx].qty;
            newQty = currentQty + qty;
            
           if (newQty > product.stock) {
    showErrorModal(`Lo sentimos, has alcanzado el límite de stock disponible: ${product.stock} unidades.`);
    return;
}
            
            cart[idx].qty = newQty;
            console.log('Producto existente, nueva cantidad:', cart[idx].qty); // Debug
        } else {
            // Verificar stock para producto nuevo
            if (qty > product.stock) {
                showErrorModal(`No puedes agregar ${qty} productos. Stock disponible: ${product.stock}`);
                return;
            }
            
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                image: product.image,
                desc: product.desc || 'Producto de calidad',
                stock: product.stock,
                qty: qty
            });
            console.log('Producto nuevo agregado'); // Debug
        }
        saveCart(cart);
        renderCart();
    }

    function removeItem(id) {
        console.log('Eliminando producto ID:', id); // Debug
        let cart = loadCart().filter(i => i.id !== parseInt(id));
        saveCart(cart);
        renderCart();
    }

    function updateQty(id, qty) {
        console.log('Actualizando cantidad:', qty, 'para ID:', id); // Debug
        const cart = loadCart();
        const i = cart.findIndex(x => x.id === parseInt(id));
        if (i >= 0) {
            const product = cart[i];
            
            // Verificar que no exceda el stock
            if (qty > product.stock) {
                showErrorModal(`No puedes tener más de ${product.stock} productos en el carrito.`);
                // Restaurar la cantidad anterior
                const input = document.querySelector(`.change-qty[data-id="${id}"]`);
                if (input) input.value = product.qty;
                return;
            }
            
            cart[i].qty = qty < 1 ? 1 : qty;
            saveCart(cart);
            renderCart();
        }
    }

    function renderCart() {
        const cart = loadCart();
        console.log('Renderizando carrito:', cart); // Debug
        
        // contador - solo mostrar si hay productos
        const totalItems = cart.reduce((a, b) => a + b.qty, 0);
        if ($countBadge) {
            if (totalItems > 0) {
                $countBadge.textContent = totalItems;
                $countBadge.style.display = 'inline-flex';
            } else {
                $countBadge.style.display = 'none';
            }
        }
        if ($countBadgeMobile) {
            if (totalItems > 0) {
                $countBadgeMobile.textContent = totalItems;
                $countBadgeMobile.style.display = 'inline-flex';
            } else {
                $countBadgeMobile.style.display = 'none';
            }
        }

        // lista
        if ($cartList) {
            $cartList.innerHTML = '';
            let total = 0;
            
            if (cart.length === 0) {
                $cartList.innerHTML = `
                    <li class="text-center py-8 text-gray-400">
                        <i class="fa-solid fa-cart-shopping text-4xl mb-3"></i>
                        <p>Tu carrito está vacío</p>
                    </li>
                `;
            } else {
                cart.forEach(item => {
                    const sub = item.price * item.qty;
                    total += sub;
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-3 py-3 border-b border-[#2a2a2a]';
                    li.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white">${item.name}</p>
                    <p class="text-xs text-gray-400">${item.desc}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-sm text-white">${format(item.price)}</span>
                        <input type="number" min="1" max="${item.stock}" value="${item.qty}"
                            class="w-16 bg-[#232323] rounded px-2 py-1 text-sm text-center text-white change-qty"
                            data-id="${item.id}">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Stock: ${item.stock}</p>
                </div>
                <button class="text-[#e7452e] hover:bg-[#232323] rounded-full remove-item flex items-center justify-center w-8 h-8 text-lg" data-id="${item.id}" title="Quitar">
                    <i class="fa-solid fa-xmark"></i>
                </button>`;
                    $cartList.appendChild(li);
                });
            }
            
            if ($cartTotalEl) $cartTotalEl.textContent = format(total);
        }
    }

    // Delegación: agregar
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.add-btn');
        if (btn && !btn.textContent.includes('Sin stock')) {
            console.log('Botón agregar clickeado'); // Debug
            try {
                const product = JSON.parse(btn.getAttribute('data-product'));
                console.log('Producto parseado:', product); // Debug
                const qty = getQtyFor(product.id);
                console.log('Cantidad:', qty); // Debug
                addItem(product, qty);
                
                // Mostrar modal de éxito
                const modal = document.getElementById('add-modal');
                if (modal) {
                    modal.classList.remove('opacity-0', 'pointer-events-none');
                    modal.classList.add('opacity-100');
                    setTimeout(() => {
                        modal.classList.add('opacity-0', 'pointer-events-none');
                        modal.classList.remove('opacity-100');
                    }, 1800);
                }
            } catch (error) {
                console.error('Error al agregar producto:', error);
            }
        }
        
        const rem = e.target.closest('.remove-item');
        if (rem) {
            removeItem(rem.getAttribute('data-id'));
        }
    });

    // Cambios de cantidad dentro del panel
    document.addEventListener('change', (e) => {
        const inp = e.target.closest('.change-qty');
        if (inp) {
            const id = inp.getAttribute('data-id');
            const qty = parseInt(inp.value, 10) || 1;
            updateQty(id, qty);
        }
    });

    // Abrir/cerrar panel
    $openCartBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Abriendo carrito'); // Debug
        $cartPanel?.classList.remove('hidden');
    });
    
    $openCartBtnMobile?.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Abriendo carrito móvil'); // Debug
        $cartPanel?.classList.remove('hidden');
    });
    
    $closeCartBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Cerrando carrito'); // Debug
        $cartPanel?.classList.add('hidden');
    });
    
    // Cerrar carrito haciendo clic en el overlay
    if ($cartOverlay) {
        $cartOverlay.addEventListener('click', (e) => {
            if (e.target === $cartOverlay) {
                console.log('Cerrando carrito por overlay'); // Debug
                $cartPanel?.classList.add('hidden');
            }
        });
    }

    // Render inicial
    renderCart();
    console.log('Carrito inicializado'); // Debug
})();

document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-menu');
    const overlay = document.getElementById('overlay');

    if (btn && menu && closeBtn && overlay) {
        btn.addEventListener('click', function() {
            menu.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', function() {
            menu.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', function() {
            menu.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Cerrar menú al hacer clic en cualquier enlace del menú móvil
        const mobileLinks = menu.querySelectorAll('a');
        mobileLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                menu.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        });
    }
});