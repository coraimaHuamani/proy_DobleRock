@extends('layouts.app')

@section('content')
    <!-- Modal de producto agregado -->
    <div id="add-modal" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-[#181818] text-white px-6 py-3 rounded-lg shadow-lg border border-[#e7452e] flex items-center gap-3 opacity-0 pointer-events-none transition-all duration-300">
        <i class="fa-solid fa-circle-check text-[#e7452e] text-xl"></i>
        <span class="font-mono text-sm">¡Producto agregado al carrito!</span>
    </div>
    <!-- Banner principal con slider y título -->
    <section class="w-full bg-black py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <h2 class="text-center text-lg md:text-2xl font tracking-widest text-white mb-6 uppercase">
                PRODUCTOS MUSICALES, MERCHANDISING Y ACCESORIOS DE ESTILO ROCK.
            </h2>
            <!-- Slider simple -->
                <!-- Cambia las URLs de las imágenes aquí. Dimensión recomendada: 1200x320px -->
                <div id="banner-slider" class="relative overflow-hidden rounded-lg shadow-lg">
                    <div class="flex transition-transform duration-700 w-full" id="slider-track">
                        <div class="w-full flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80" alt="Banner 1" class="w-full h-[320px] object-cover">
                        </div>
                        <div class="w-full flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80" alt="Banner 2" class="w-full h-[320px] object-cover">
                        </div>
                    </div>
                <!-- Controles -->
                <button id="slider-prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center z-10"><i class="fa-solid fa-chevron-left"></i></button>
                <button id="slider-next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center z-10"><i class="fa-solid fa-chevron-right"></i></button>
                <!-- Indicadores -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <span class="slider-dot w-3 h-3 rounded-full bg-white/70 cursor-pointer"></span>
                    <span class="slider-dot w-3 h-3 rounded-full bg-white/30 cursor-pointer"></span>
                </div>
            </div>
        </div>
    </section>
    <script>
    // Mostrar modal de producto agregado
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

    // Interceptar clicks en .add-btn para mostrar el modal
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.add-btn');
        if (btn) {
            showAddModal();
        }
    });

    // Slider JS simple (2 imágenes)
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
    </script>
    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <div class="max-w-[1200px] mx-auto px-6 py-10 text-white">

            {{-- ====== SECCIÓN: MERCHANDISING MUSICAL ====== --}}
            <section class="mb-10">
                <div class="flex items-center mb-6">
                    <span class="inline-block w-8 h-0.5 bg-white mr-3"></span>
                    <h2 class="text-base tracking-widest text-white uppercase">Merchandising Musical</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Taza con diseño de álbum o artista --}}
                        <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                            <img src="https://http2.mlstatic.com/D_NQ_NP_837869-MLA79978531652_102024-O.webp" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Taza "Álbum/Banda"</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Perfecta para fans que quieren música y café en el mismo lugar.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 2</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 19.90</span>
                                <input type="number" min="1" max="2" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="MM-001">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"MM-001","name":"Taza Álbum/Banda","price":19.90,"image":"https://images.unsplash.com/photo-1517685352821-92cf88aee5a5?q=80&w=1200&auto=format&fit=crop","desc":"Taza con diseño de álbum o artista para disfrutar tu bebida favorita mostrando tu banda preferida."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Funda para teléfono --}}
                        <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                            <img src="https://i.ebayimg.com/thumbs/images/g/K-UAAeSw3StoHCU7/s-l1200.jpg"
                                alt="Funda para Teléfono" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Funda para Teléfono</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Protege tu celular con estilo rockero y diseños de bandas.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 1</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 29.90</span>
                                <input type="number" min="1" max="1" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="MM-002">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"MM-002","name":"Funda para Teléfono","price":29.90,"image":"https://images.unsplash.com/photo-1512496015851-a90fb38ba796?q=80&w=1200&auto=format&fit=crop","desc":"Protege tu celular con estilo rockero y diseños de bandas."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Póster o lámina de concierto --}}
                        <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                            <img src="https://e1.pxfuel.com/desktop-wallpaper/883/478/desktop-wallpaper-paramore-cover-paramore-tumblr-backgrounds.jpg"
                                alt="Póster de Concierto" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Póster de Concierto</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Decora tu espacio con arte musical icónico de conciertos.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 2</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 24.90</span>
                                <input type="number" min="1" max="2" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="MM-003">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"MM-003","name":"Póster/Lámina Concierto","price":24.90,"image":"https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=1200&auto=format&fit=crop","desc":"Decora tu espacio con arte musical icónico de conciertos y bandas legendarias."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Gorro o gorra de banda --}}
                        <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                            <img src="https://http2.mlstatic.com/D_NQ_NP_686827-MLA75598912555_042024-O.webp"
                                alt="Gorro de Banda" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Gorro/Gorra Banda</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Luce tu banda favorita mientras te proteges del sol.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 1</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 34.90</span>
                                <input type="number" min="1" max="1" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="MM-004">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"MM-004","name":"Gorro/Gorra Banda","price":34.90,"image":"https://images.unsplash.com/photo-1512436991641-6745cdb1723f?q=80&w=1200&auto=format&fit=crop","desc":"Luce tu banda favorita mientras te proteges del sol con estilo musical."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ====== SECCIÓN: ACCESORIOS ====== --}}
            <section class="mb-10">
                <div class="flex items-center mb-6">
                    <span class="inline-block w-8 h-0.5 bg-white mr-3"></span>
                    <h2 class="text-base tracking-widest text-white uppercase">Accesorios</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Accesorio 1 --}}
                    <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                        <img src="https://static.wixstatic.com/media/9554e1_003b0b0b027e40a5a263a7f7b6819d69~mv2.png/v1/fit/w_500,h_500,q_90/file.png"
                            alt="Gorra Oficial" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2 flex flex-col flex-1 justify-between">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Gorra Oficial</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Ajustable, bordado de alta calidad.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 2</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 39.90</span>
                                <input type="number" min="1" max="2" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="AC-001">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"AC-001","name":"Gorra Oficial","price":39.90,"image":"https://images.unsplash.com/photo-1512496015851-a90fb38ba796?q=80&w=1200&auto=format&fit=crop","desc":"Ajustable, bordado de alta calidad."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Accesorio 2 --}}
                    <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                        <img src="https://m.media-amazon.com/images/I/51zeiPMEG9L._UY1000_.jpg"
                            alt="Llavero Metálico" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2 flex flex-col flex-1 justify-between">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Llavero Metálico</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Grabado láser de alta precisión, resistente al desgaste.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 1</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 14.90</span>
                                <input type="number" min="1" max="1" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="AC-002">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"AC-002","name":"Llavero Metálico","price":14.90,"image":"https://images.unsplash.com/photo-1540574163026-643ea20ade25?q=80&w=1200&auto=format&fit=crop","desc":"Grabado láser, resistente."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Accesorio 3 --}}
                    <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                        <img src="https://i.etsystatic.com/18862427/r/il/746de4/5068983255/il_570xN.5068983255_l6or.jpg"
                            alt="Pulsera Rock" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2 flex flex-col flex-1 justify-between">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Pulsera Rock</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Cuero genuino suave, broche metálico resistente.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 2</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 24.90</span>
                                <input type="number" min="1" max="2" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="AC-003">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"AC-003","name":"Pulsera Rock","price":24.90,"image":"https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200&auto=format&fit=crop","desc":"Cuero genuino, broche metálico."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                    {{-- Accesorio 4 --}}
                    <div class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                        <img src="https://www.puaspersonalizadas.es/wp-content/uploads/2017/10/plectrum-xxl-met-maat-min.png"
                            alt="Púa de Guitarra" class="w-full h-56 object-cover">
                        <div class="p-4 space-y-2 flex flex-col flex-1 justify-between">
                            <h3 class="text-lg font-bold font-mono uppercase tracking-wider">Púa de Guitarra</h3>
                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">Material resistente, edición limitada.</p>
                            <div class="flex items-center justify-between mt-2">
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-400">Stock: 1</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-mono text-base text-white">S/ 9.90</span>
                                <input type="number" min="1" max="1" value="1"
                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                    data-sku="AC-004">
                            </div>
                            <button
                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                data-product='{"sku":"AC-004","name":"Púa de Guitarra","price":9.90,"image":"https://images.unsplash.com/photo-1519125323398-675f0ddb6308?q=80&w=1200&auto=format&fit=crop","desc":"Material resistente, edición limitada."}'>Agregar
                                al carrito</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    {{-- Fondo con estrellas --}}
    <style>
        .shop-wrap {
            background-color: #0d0d0f;
            background-image:
                /* Estrellas grandes */
                radial-gradient(circle at 20% 10%, rgba(255, 255, 255, 0.12) 0 2px, transparent 2px),
                radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.10) 0 1.5px, transparent 1.5px),
                radial-gradient(circle at 40% 70%, rgba(255, 255, 255, 0.09) 0 1.5px, transparent 1.5px),
                radial-gradient(circle at 60% 90%, rgba(255, 255, 255, 0.11) 0 1.5px, transparent 1.5px),
                /* Estrellas pequeñas */
                radial-gradient(circle at 10% 80%, rgba(255, 255, 255, 0.07) 0 1px, transparent 1px),
                radial-gradient(circle at 90% 20%, rgba(255, 255, 255, 0.08) 0 1px, transparent 1px),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.06) 0 1px, transparent 1px);
            background-size: 100% 100%, 16px 16px, 22px 22px, 18px 18px, 24px 24px, 20px 20px, 18px 18px, 22px 22px;
            background-repeat: no-repeat, repeat, repeat, repeat, repeat, repeat, repeat;
            background-attachment: fixed, fixed, fixed, fixed, fixed, fixed, fixed;
        }

        .shop-wrap * {
            letter-spacing: .06em;
        }
    </style>
@endsection
