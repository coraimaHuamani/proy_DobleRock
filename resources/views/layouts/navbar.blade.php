<!-- Logo y reproductor -->
<div class="bg-[#000000]">
    <div
        class="max-w-[1200px] mx-auto p-2 flex flex-col md:flex-row items-center justify-center md:justify-between w-full gap-4">

        <!-- Logo -->
        <div class="flex items-center mb-2 md:mb-0">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="w-12 h-12 object-contain mr-3" />
            <div class="flex flex-col md:mr-6">
                <span class="text-white font-bold text-xl leading-tight">DOBLE</span>
                <span class="text-[#e7452e] font-bold text-xl leading-tight">ROCK</span>
            </div>
        </div>

        <!-- Reproductor de música -->
        <div
            class="bg-[#232323] rounded-full flex items-center px-3 py-2 shadow-lg space-x-2 w-full max-w-md h-[54px] md:ml-0">
            <div class="flex flex-col justify-center flex-1 min-w-0">
                <span class="text-white font-bold text-sm block leading-tight">Nothing Impossible</span>
                <span class="text-gray-300 text-xs truncate">Matias Martelli</span>
            </div>
            <button class="text-white text-base hover:text-[#e7452e]" aria-label="Anterior">
                <i class="fa-solid fa-backward-step"></i>
            </button>
            <button
                class="bg-[#e7452e] hover:bg-orange-600 text-white w-8 h-8 flex items-center justify-center rounded-full"
                aria-label="Play">
                <i class="fa-solid fa-play"></i>
            </button>
            <button class="text-white text-base hover:text-[#e7452e]" aria-label="Siguiente">
                <i class="fa-solid fa-forward-step"></i>
            </button>
            <div class="w-16 h-1 bg-gray-600 rounded-full overflow-hidden">
                <div class="h-1 bg-[#e7452e] w-2/3"></div>
            </div>
        </div>

    </div>
</div>

<!-- Contenedor general con fondo -->
<nav class="bg-[#000000] text-white">
    <div class="max-w-[1200px] mx-auto px-6 py-3 flex items-center justify-between">

        {{-- ENLACES IZQUIERDA --}}
        <ul class="hidden md:flex space-x-6 font-semibold uppercase text-sm">
            <li>
                <a href="/"
                    class="hover:text-[#e7452e] {{ request()->is('/') ? 'text-[#e7452e]' : '' }}">Inicio</a>
            </li>
            <li>
                <a href="{{ route('tienda') }}"
                    class="hover:text-[#e7452e] {{ request()->is('tienda') ? 'text-[#e7452e]' : '' }}">Tienda</a>
            </li>
            <li><a href="#" class="hover:text-[#e7452e]">Música</a></li>
            <li>
                <a href="{{ route('noticias') }}"
                    class="hover:text-[#e7452e] {{ request()->is('noticias') ? 'text-[#e7452e]' : '' }}">Noticias</a>
            </li>
            <li>
                <a href="{{ route('galeria') }}"
                    class="hover:text-[#e7452e] {{ request()->is('galeria') ? 'text-[#e7452e]' : '' }}">GALERÍA</a>
            </li>
        </ul>

        {{-- BOTÓN HAMBURGUESA MOBILE --}}
        <div class="md:hidden">
            <button id="menu-btn" class="focus:outline-none text-white hover:text-[#e7452e]">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>
        </div>

        {{-- DERECHA: buscador + iconos --}}
        <div class="hidden md:flex items-center space-x-4">
            <div class="flex items-center bg-[#232323] rounded-full px-3 py-1">
                <input type="text" placeholder="Buscar productos..."
                    class="bg-transparent text-sm focus:outline-none text-gray-300 placeholder-gray-400 w-40">
                <button class="text-white hover:text-[#e7452e]">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <button class="text-white hover:text-[#e7452e]">
                <i class="fa-solid fa-user"></i>
            </button>

            {{-- CARRITO --}}
            <div class="relative">
                <button id="open-cart" class="text-white hover:text-[#e7452e] flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count"
                        class="inline-flex items-center justify-center text-xs bg-[#e7452e] rounded-full w-5 h-5">0</span>
                </button>
            </div>
        </div>
    </div>

    {{-- PANEL DEL CARRITO (dropdown/side minimalista) --}}
    <div id="cart-panel" class="hidden">
        <div class="fixed inset-0 bg-black/50 z-40"></div>
        <div
            class="fixed right-0 top-0 h-full w-full sm:w-[380px] bg-[#0f0f0f] z-50 shadow-2xl border-l border-[#232323]">
            <div class="p-4 border-b border-[#232323] flex items-center justify-between">
                <h3 class="font-bold text-lg">Tu carrito</h3>
                <button id="close-cart" class="text-gray-300 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-4">
                <ul id="cart-items" class="divide-y divide-[#232323]"></ul>
            </div>
            <div class="p-4 border-t border-[#232323]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-300">Total</span>
                    <span id="cart-total" class="font-bold">S/ 0.00</span>
                </div>
                <button class="w-full bg-[#e7452e] hover:bg-[#cf3d28] text-white rounded-lg py-2 text-sm">
                    Finalizar compra
                </button>
            </div>
        </div>
    </div>
</nav>


<!-- Línea naranja debajo del navbar -->
<div class="w-full h-1 bg-[#e7452e]"></div>

<!-- MENÚ LATERAL MOBILE -->
<div id="mobile-menu"
    class="fixed top-0 left-0 h-full w-64 bg-[#181818] text-white transform -translate-x-full transition-transform duration-300 z-50 shadow-2xl border-r-4 border-[#e7452e]">
    <div class="px-6 py-4">
        <div class="flex justify-end">
            <button id="close-menu" class="mb-4 text-[#e7452e] focus:outline-none text-2xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <ul class="space-y-6 mt-4 font-semibold uppercase text-base">
            <li>
                <a href="/"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('/') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-house text-[#e7452e]"></i> Inicio
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('tienda') }}"
                    class="hover:text-[#e7452e] w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative {{ request()->is('tienda') ? 'text-[#e7452e]' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-store text-[#e7452e]"></i> Tienda
                    </div>
                </a>
            </li>
            <li>
                <a href="#"
                    class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-music text-[#e7452e]"></i> Música
                    </div>
                    <span
                        class="absolute left-3 right-3 bottom-0 h-1 bg-[#e7452e] rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users text-[#e7452e]"></i> Nosotros
                    </div>
                    <span
                        class="absolute left-3 right-3 bottom-0 h-1 bg-[#e7452e] rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="w-full flex flex-col items-start px-3 py-3 rounded transition-all duration-200 group relative">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-[#e7452e]"></i> Contacto
                    </div>
                    <span
                        class="absolute left-3 right-3 bottom-0 h-1 bg-[#e7452e] rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200"></span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<script>
    // === CARRITO GLOBAL ===
    (function() {
        const STORAGE_KEY = 'cart';
        const $countBadge = document.getElementById('cart-count');
        const $cartPanel = document.getElementById('cart-panel');
        const $cartList = document.getElementById('cart-items');
        const $cartTotalEl = document.getElementById('cart-total');
        const $openCartBtn = document.getElementById('open-cart');
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
</script>
