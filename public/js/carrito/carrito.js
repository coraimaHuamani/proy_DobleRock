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
        // Fondo oscuro para cerrar carrito
        let $cartOverlay = null;
        if ($cartPanel) {
            $cartOverlay = $cartPanel.querySelector('.fixed.inset-0.bg-black\\/50');
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
        }

        function format(n) {
            return 'S/ ' + n.toFixed(2);
        }

        function getQtyFor(sku) {
            const input = document.querySelector(`.qty-input[data-sku="${sku}"]`);
            let q = parseInt(input?.value ?? '1', 10);
            if (isNaN(q) || q < 1) q = 1;
            return q;
        }

        function addItem(product, qty) {
            const cart = loadCart();
            const idx = cart.findIndex(i => i.sku === product.sku);
            if (idx >= 0) {
                cart[idx].qty += qty;
            } else {
                cart.push({
                    ...product,
                    qty
                });
            }
            saveCart(cart);
            renderCart();
        }

        function removeItem(sku) {
            let cart = loadCart().filter(i => i.sku !== sku);
            saveCart(cart);
            renderCart();
        }

        function updateQty(sku, qty) {
            const cart = loadCart();
            const i = cart.findIndex(x => x.sku === sku);
            if (i >= 0) {
                cart[i].qty = qty < 1 ? 1 : qty;
                saveCart(cart);
                renderCart();
            }
        }

        function renderCart() {
            const cart = loadCart();
            // contador
            const totalItems = cart.reduce((a, b) => a + b.qty, 0);
            if ($countBadge) $countBadge.textContent = totalItems;
            if ($countBadgeMobile) $countBadgeMobile.textContent = totalItems;

            // lista
            if ($cartList) {
                $cartList.innerHTML = '';
                let total = 0;
                cart.forEach(item => {
                    const sub = item.price * item.qty;
                    total += sub;
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-3 py-3 border-b border-[#2a2a2a]';
                    li.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">
                <div class="flex-1">
                    <p class="text-sm font-semibold">${item.name}</p>
                    <p class="text-xs text-gray-400">${item.desc}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-sm">${format(item.price)}</span>
                        <input type="number" min="1" value="${item.qty}"
                            class="w-16 bg-[#232323] rounded px-2 py-1 text-sm text-center change-qty"
                            data-sku="${item.sku}">
                    </div>
                </div>
                <button class="text-[#e7452e] hover:bg-[#232323] rounded-full remove-item flex items-center justify-center w-8 h-8 text-lg" data-sku="${item.sku}" title="Quitar">
                    <i class="fa-solid fa-xmark"></i>
                </button>`;
                    $cartList.appendChild(li);
                });
                if ($cartTotalEl) $cartTotalEl.textContent = format(total);
            }
        }

        // Delegación: agregar
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.add-btn');
            if (btn) {
                const product = JSON.parse(btn.getAttribute('data-product'));
                const qty = getQtyFor(product.sku);
                addItem(product, qty);
            }
            const rem = e.target.closest('.remove-item');
            if (rem) removeItem(rem.getAttribute('data-sku'));
        });

        // Cambios de cantidad dentro del panel
        document.addEventListener('change', (e) => {
            const inp = e.target.closest('.change-qty');
            if (inp) {
                const sku = inp.getAttribute('data-sku');
                const qty = parseInt(inp.value, 10) || 1;
                updateQty(sku, qty);
            }
        });

        // Abrir/cerrar panel
        $openCartBtn?.addEventListener('click', () => $cartPanel?.classList.remove('hidden'));
        $openCartBtnMobile?.addEventListener('click', () => $cartPanel?.classList.remove('hidden'));
        $closeCartBtn?.addEventListener('click', () => $cartPanel?.classList.add('hidden'));
        $cartOverlay?.addEventListener('click', () => $cartPanel?.classList.add('hidden'));

        // Render inicial
        renderCart();
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