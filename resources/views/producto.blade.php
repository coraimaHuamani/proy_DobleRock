@extends('layouts.app')

@section('content')
    <div class="min-h-screen relative text-white py-10 px-4"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/80"></div>
        <div class="relative z-10">

            <!-- Solo botón volver -->
            <div class="max-w-6xl mx-auto mb-6 flex items-start">
                <button id="go-back"
                    class="inline-flex items-center gap-2 hover:text-white transition text-neutral-300 text-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Volver
                </button>
            </div>

            <!-- Contenido principal tipo “producto” -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="col-span-1 lg:col-span-12 flex flex-col lg:flex-row gap-8 rounded-2xl border border-white/50 shadow-xl bg-black/30 backdrop-blur-md p-6">
                    <!-- Imagen grande -->
                    <div class="flex-1 flex items-center justify-center min-h-[340px]">
                        <img id="product-image" src="" alt="Producto"
                            class="max-h-[420px] w-auto mx-auto rounded-2xl object-contain transition duration-300">
                    </div>
                    <!-- Info -->
                    <div class="flex-1 flex flex-col justify-center">
                        <h1 id="product-title" class="text-2xl lg:text-3xl font-black tracking-tight uppercase"></h1>
                        <!-- Precios -->
                        <div class="mt-3 flex items-baseline gap-3">
                            <span id="price-compare" class="text-neutral-400 line-through hidden"></span>
                            <span id="product-price" class="text-[#e7452e] text-2xl lg:text-3xl font-extrabold"></span>
                        </div>
                        <!-- Stock + qty + CTA separados -->
                        <div class="mt-5 flex flex-col gap-4 items-start">
                            <span id="product-stock" class="text-xs uppercase tracking-widest text-neutral-400"></span>
                            <div class="flex items-center gap-2 w-full">
                                <div class="flex items-stretch rounded-lg overflow-hidden border border-white/10">
                                    <button id="qty-minus" class="w-9 bg-white/5 hover:bg-white/10">–</button>
                                    <input id="product-qty" type="number" min="1" value="1"
                                        class="w-12 bg-[#232323] text-center text-sm outline-none" />
                                    <button id="qty-plus" class="w-9 bg-white/5 hover:bg-white/10">+</button>
                                </div>
                            </div>
                            <button id="add-to-cart"
                                class="add-btn px-6 py-3 rounded-lg font-bold uppercase tracking-widest bg-white text-black hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed mt-2"
                                data-product=''>
                                Añadir al carrito
                            </button>
                        </div>
                        <!-- Caja de descripción como el ejemplo -->
                        <div class="mt-6 bg-[#171717] border border-[#2b2b2b] rounded-xl p-5 leading-relaxed text-gray-200">
                            <p id="product-desc" class="mb-4"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast -->
        <div id="toast"
            class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 px-4 py-2 bg-[#1e1e1e] border border-white/10 rounded-lg shadow-lg text-sm hidden">
            Añadido al carrito
        </div>

        <script>
            // --- util
            const getQueryParam = (k) => new URLSearchParams(location.search).get(k);

            // --- datos (los tuyos)
            const productos = {
                'MM-001': {
                    sku: 'MM-001',
                    name: 'Taza Álbum/Banda',
                    price: 19.90,
                    image: 'https://http2.mlstatic.com/D_NQ_NP_837869-MLA79978531652_102024-O.webp',
                    desc: 'Taza con diseño de álbum o artista para disfrutar tu bebida favorita mostrando tu banda preferida.',
                    stock: 2
                },
                'MM-002': {
                    sku: 'MM-002',
                    name: 'Funda para Teléfono',
                    price: 29.90,
                    image: 'https://i.ebayimg.com/thumbs/images/g/K-UAAeSw3StoHCU7/s-l1200.jpg',
                    desc: 'Protege tu celular con estilo rockero y diseños de bandas.',
                    stock: 1
                },
                'MM-003': {
                    sku: 'MM-003',
                    name: 'Póster/Lámina Concierto',
                    price: 24.90,
                    image: 'https://e1.pxfuel.com/desktop-wallpaper/883/478/desktop-wallpaper-paramore-cover-paramore-tumblr-backgrounds.jpg',
                    desc: 'Decora tu espacio con arte musical icónico de conciertos y bandas legendarias.',
                    stock: 2
                },
                'MM-004': {
                    sku: 'MM-004',
                    name: 'Gorro/Gorra Banda',
                    price: 34.90,
                    image: 'https://http2.mlstatic.com/D_NQ_NP_686827-MLA75598912555_042024-O.webp',
                    desc: 'Luce tu banda favorita mientras te proteges del sol con estilo musical.',
                    stock: 0
                },
                'AC-001': {
                    sku: 'AC-001',
                    name: 'Gorra Oficial',
                    price: 39.90,
                    image: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80',
                    desc: 'Ajustable, bordado de alta calidad.',
                    stock: 2
                },
                'AC-002': {
                    sku: 'AC-002',
                    name: 'Llavero Metálico',
                    price: 14.90,
                    image: 'https://m.media-amazon.com/images/I/51zeiPMEG9L._UY1000_.jpg',
                    desc: 'Grabado láser, resistente.',
                    stock: 1
                },
                'AC-003': {
                    sku: 'AC-003',
                    name: 'Pulsera Rock',
                    price: 24.90,
                    image: 'https://i.etsystatic.com/18862427/r/il/746de4/5068983255/il_570xN.5068983255_l6or.jpg',
                    desc: 'Cuero genuino, broche metálico.',
                    stock: 2
                },
                'AC-004': {
                    sku: 'AC-004',
                    name: 'Púa de Guitarra',
                    price: 9.90,
                    image: 'https://www.puaspersonalizadas.es/wp-content/uploads/2017/10/plectrum-xxl-met-maat-min.png',
                    desc: 'Material resistente, edición limitada.',
                    stock: 1
                },
            };

            // refs
            const imgEl = document.getElementById('product-image');
            const titleEl = document.getElementById('product-title');
            const descEl = document.getElementById('product-desc');
            const stockEl = document.getElementById('product-stock');
            const priceEl = document.getElementById('product-price');
            const compareEl = document.getElementById('price-compare');
            const qtyEl = document.getElementById('product-qty');
            const addBtn = document.getElementById('add-to-cart');
            const crumb = document.getElementById('crumb-title');

            document.getElementById('go-back').addEventListener('click', (e) => {
                e.preventDefault();
                if (history.length > 1) history.back();
                else location.href = '/tienda';
            });

            const sku = getQueryParam('sku');
            const prod = productos[sku];

            if (prod) {
                imgEl.src = prod.image;
                imgEl.alt = prod.name;
                titleEl.textContent = prod.name;
                descEl.textContent = prod.desc;
                priceEl.textContent = 'S/ ' + prod.price.toFixed(2);

                // si quisieras mostrar un precio tachado (comparativo), añade prod.compare (opcional)
                if (typeof prod.compare === 'number' && prod.compare > prod.price) {
                    compareEl.classList.remove('hidden');
                    compareEl.textContent = 'S/ ' + prod.compare.toFixed(2);
                }

                // stock
                if (prod.stock <= 0) {
                    stockEl.textContent = 'Sin stock';
                    addBtn.disabled = true;
                } else if (prod.stock <= 2) {
                    stockEl.textContent = `Bajo stock (${prod.stock} u.)`;
                } else {
                    stockEl.textContent = `En stock (${prod.stock} u.)`;
                }
                qtyEl.max = Math.max(prod.stock, 1);

                // Set data-product attribute for global cart logic
                addBtn.setAttribute('data-product', JSON.stringify(prod));
            } else {
                // error
                document.querySelector('.max-w-6xl')?.remove();
                const box = document.createElement('div');
                box.className = 'max-w-6xl mx-auto bg-[#181818] border border-[#232323] rounded-2xl p-10 text-center';
                box.textContent = 'Producto no encontrado.';
                document.querySelector('.min-h-screen')?.appendChild(box);
            }

            // qty
            document.getElementById('qty-minus').addEventListener('click', () => {
                let v = parseInt(qtyEl.value || 1);
                v = Math.max(1, v - 1);
                qtyEl.value = v;
            });
            document.getElementById('qty-plus').addEventListener('click', () => {
                let v = parseInt(qtyEl.value || 1);
                v = Math.max(1, Math.min((+qtyEl.max || 99), v + 1));
                qtyEl.value = v;
            });

            // add to cart + toast
            // Toast solo visual, el agregado real lo hace el global del navbar
            function showToast(msg = 'Añadido al carrito') {
                const t = document.getElementById('toast');
                t.textContent = msg;
                t.classList.remove('hidden');
                t.style.opacity = '0';
                requestAnimationFrame(() => {
                    t.style.transition = 'opacity .2s ease';
                    t.style.opacity = '1';
                });
                setTimeout(() => {
                    t.style.opacity = '0';
                    setTimeout(() => t.classList.add('hidden'), 200);
                }, 1400);
            }
            // Escuchar el evento global de click para mostrar el toast si se hace click en este botón
            addBtn.addEventListener('click', () => {
                setTimeout(() => showToast(), 100); // pequeño delay para que el global procese
            });
        </script>
    @endsection
