@extends('layouts.app')

@section('content')
    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">

        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/80"></div>

        <!-- Contenido -->
        <div class="relative mx-auto px-6 md:px-12 lg:px-24">

            {{-- HERO --}}
            <header class="py-10 text-center">
                <p class="mt-3 text-base md:text-lg text-gray-300 tracking-widest uppercase">
                    Productos musicales, merchandising y accesorios de estilo rock.
                </p>
            </header>

            {{-- CAROUSEL --}}
            {{-- CAROUSEL --}}
            @php
                $popular = [
                    [
                        'title' => 'VINILO DOBLE "MUTTER"',
                        'subtitle' => 'Edición remasterizada',
                        'price' => '28,00 EUR',
                        'badge' => 'preorder',
                        'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'CAMISETA LOGO CLÁSICO',
                        'subtitle' => '100% algodón',
                        'price' => '25,00 EUR',
                        'badge' => 'lifad',
                        'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'CD ÁLBUM "ZEIT"',
                        'subtitle' => 'Edición estándar',
                        'price' => '15,00 EUR',
                        'badge' => null,
                        'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                ];
            @endphp

            <div id="carousel" class="relative mb-12 grid md:grid-cols-2">
                <!-- Imagen: solo esta parte se desliza -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500" data-carousel-track>
                        @foreach ($popular as $p)
                            <div class="min-w-full">
                                <div class="relative block aspect-[16/10] md:aspect-auto md:h-[360px] overflow-hidden shadow-lg bg-[#232323] flex items-center justify-center">
                                    @if ($p['img'])
                                        <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="w-full h-full object-cover" />
                                    @else
                                        <span class="text-gray-500 text-xs uppercase tracking-widest">Sin imagen</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Detalle: permanece fijo pero cambia el contenido -->
                <div class="p-6 md:p-10 flex flex-col justify-center bg-[#121212]" id="carousel-detail">
                    <h3 class="text-2xl md:text-3xl font-bold uppercase tracking-wider" id="carousel-title">{{ $popular[0]['title'] }}</h3>
                    @if ($popular[0]['subtitle'])
                        <p class="mt-1 text-[12px] uppercase tracking-widest text-gray-300" id="carousel-subtitle">{{ $popular[0]['subtitle'] }}</p>
                    @endif
                    <div class="mt-4 text-sm uppercase tracking-widest text-emerald-400" id="carousel-price">{{ $popular[0]['price'] }}</div>
                    <div class="mt-6 flex gap-3">
                        <button type="button"
                            class="px-5 py-2 border border-white/40 hover:border-white uppercase text-[11px] tracking-widest">
                            ver producto
                        </button>
                        <button type="button"
                            class="px-5 py-2 bg-[#e7452e] hover:bg-orange-600 text-white uppercase text-[11px] tracking-widest">
                            añadir
                        </button>
                    </div>
                </div>

                {{-- Controles --}}
                <button type="button"
                    class="hidden sm:flex items-center justify-center w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 absolute left-3 top-1/2 -translate-y-1/2"
                    aria-label="Anterior" data-carousel-prev>
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" />
                    </svg>
                </button>
                <button type="button"
                    class="hidden sm:flex items-center justify-center w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 absolute right-3 top-1/2 -translate-y-1/2"
                    aria-label="Siguiente" data-carousel-next>
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" />
                    </svg>
                </button>

                {{-- Bullets --}}
                <div class="absolute left-1/2 -translate-x-1/2 -bottom-8 flex gap-2" data-carousel-dots>
                    @foreach ($popular as $i => $p)
                        <button type="button"
                            class="w-3 h-3 bg-white/30 shadow-sm transition-all duration-200 border border-white/40"
                            style="border-radius: 4px;" aria-label="Ir al slide {{ $i + 1 }}"
                            data-carousel-dot="{{ $i }}"></button>
                    @endforeach
                </div>
            </div>

            {{-- MENÚ --}}
            <nav class="mb-8">
                <ul class="flex flex-row flex-wrap justify-center gap-4 md:gap-6 uppercase tracking-widest text-sm">
                    <li><a href="#" class="hover:text-orange-400">¿Qué hay de nuevo?</a></li>
                    <li><a href="#" class="hover:text-orange-400">Polos</a></li>
                    <li><a href="#" class="hover:text-orange-400">Accesorios</a></li>
                    <li><a href="#" class="hover:text-orange-400">Lentes</a></li>
                    <li><a href="#" class="hover:text-orange-400">Gorras</a></li>
                </ul>
            </nav>

            {{-- GRID DE PRODUCTOS --}}
            @php
                $products = [
                    [
                        'title' => 'CD Álbum "Zeit"',
                        'subtitle' => 'Edición estándar',
                        'price' => '15,00',
                        'old' => null,
                        'state' => null,
                        'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Vinilo Doble "Mutter"',
                        'subtitle' => 'Edición remasterizada',
                        'price' => '28,00',
                        'old' => '32,00',
                        'state' => 'preorder',
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-vVVkzKpJ6Bqiv9a1Ju7L1JoBaPzvgBvysw&s',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Camiseta Logo Clásico',
                        'subtitle' => '100% algodón',
                        'price' => '25,00',
                        'old' => null,
                        'state' => null,
                        'img' => 'data:image/jpeg;base64,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',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Sudadera "Feuer"',
                        'subtitle' => 'Con capucha',
                        'price' => '49,00',
                        'old' => null,
                        'state' => 'lifad',
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-Lz_-VUnz9OapycRdiIiehJ2ZbrRmqdaMrA&s',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Gorra Negra',
                        'subtitle' => 'Bordado frontal',
                        'price' => '19,00',
                        'old' => null,
                        'state' => null,
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5D-StUNqHTAUSZyYtlpPM3ukM5d-HGmB1ow&s',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Póster Tour 2025',
                        'subtitle' => '70x100 cm',
                        'price' => '12,00',
                        'old' => null,
                        'state' => null,
                        'img' => 'https://shop.imaginedragonsmusic.com/cdn/shop/files/IMAGD-0057_NARSTour-Banner-Mobile.png?v=1713789956&width=900',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Taza Logo',
                        'subtitle' => 'Cerámica 300ml',
                        'price' => '9,00',
                        'old' => null,
                        'state' => null,
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk_E35BPNAdnabYvWK1vL8L6QKM1t_TiXzvw&s',
                        'img2' => null,
                    ],
                    [
                        'title' => 'Llavero Metálico',
                        'subtitle' => 'Edición limitada',
                        'price' => '—',
                        'old' => null,
                        'state' => 'soldout',
                        'img' => 'https://m.media-amazon.com/images/I/51zeiPMEG9L._UY1000_.jpg',
                        'img2' => null,
                    ],
                ];
            @endphp

            {{-- Línea y título de categoría arriba del primer grupo --}}
            <div class="flex items-center mb-2">
                <span class="block w-8 h-0.5 bg-white mr-2"></span>
                <span class="text-gray-300 text-[13px] tracking-widest uppercase">Polos</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-8">
                @foreach (array_slice($products, 0, 4) as $p)
                    <article class="group">
                        <div class="relative overflow-hidden">
                            <div class="relative block aspect-[1/1] overflow-hidden bg-[#232323] flex items-center justify-center rounded-lg shadow-lg">
                                @if ($p['img'])
                                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg" />
                                @else
                                    <span class="text-gray-500 text-xs uppercase tracking-widest">Sin imagen</span>
                                @endif
                            </div>
                        </div>
                        <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">
                            {{ $p['title'] }}</h3>
                        @if ($p['subtitle'])
                            <div class="text-[11px] text-gray-300 uppercase tracking-widest">{{ $p['subtitle'] }}</div>
                        @endif
                        <div class="mt-1 text-[11px] uppercase tracking-widest">
                            @if ($p['price'] !== '—')
                                @if ($p['old'])
                                    <span class="text-gray-400 line-through mr-2">{{ $p['old'] }} eur</span>
                                @endif
                                <span class="text-emerald-400">{{ $p['price'] }} eur</span>
                            @else
                                <span class="text-gray-400">Actualmente no disponible</span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Línea y título de categoría arriba del segundo grupo --}}
            <div class="flex items-center mb-2">
                <span class="block w-8 h-0.5 bg-white mr-2"></span>
                <span class="text-gray-300 text-[13px] tracking-widest uppercase">Accesorios</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach (array_slice($products, 4, 4) as $p)
                    <article class="group">
                        <div class="relative overflow-hidden">
                            <div class="relative block aspect-[1/1] overflow-hidden bg-[#232323] flex items-center justify-center rounded-lg shadow-lg">
                                @if ($p['img'])
                                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg" />
                                @else
                                    <span class="text-gray-500 text-xs uppercase tracking-widest">Sin imagen</span>
                                @endif
                            </div>
                        </div>
                        <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">
                            {{ $p['title'] }}</h3>
                        @if ($p['subtitle'])
                            <div class="text-[11px] text-gray-300 uppercase tracking-widest">{{ $p['subtitle'] }}</div>
                        @endif
                        <div class="mt-1 text-[11px] uppercase tracking-widest">
                            @if ($p['price'] !== '—')
                                @if ($p['old'])
                                    <span class="text-gray-400 line-through mr-2">{{ $p['old'] }} eur</span>
                                @endif
                                <span class="text-emerald-400">{{ $p['price'] }} eur</span>
                            @else
                                <span class="text-gray-400">Actualmente no disponible</span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- ESPECIALES Y DESCUENTOS --}}
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-20 mb-12">
                <!-- Especial -->
                <div class="flex flex-col">
                    <div class="flex items-center mb-2">
                        <span class="block w-8 h-0.5 bg-white mr-2"></span>
                        <span class="text-gray-300 text-[13px] tracking-widest uppercase">especial</span>
                    </div>
                    <div class="bg-[#181818] shadow-lg flex flex-row w-full h-full" style="border-radius:0; min-height:320px; min-height:220px;">
                        <div class="flex items-center justify-center bg-[#232323] w-1/2 h-full" style="border-radius:0; min-height:220px;">
                            <img src="https://i.pinimg.com/736x/27/4d/93/274d934f0bf454f38ad6c4cdab852486.jpg" alt="Descuento" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex flex-col justify-center flex-1 px-8 py-10">
                            <h3 class="text-2xl md:text-3xl font-bold uppercase tracking-wider mb-4">Hasta un 60 % de descuento</h3>
                            <p class="text-sm uppercase tracking-widest text-gray-300 mb-6">En productos seleccionados<br>hasta fin de existencias</p>
                            <button class="bg-white text-black px-6 py-2 font-bold uppercase tracking-widest shadow" style="border-radius:0;">Comprar ahora</button>
                        </div>
                    </div>
                </div>
                <!-- Exclusivo -->
                <div class="flex flex-col">
                    <div class="flex items-center mb-2">
                        <span class="block w-8 h-0.5 bg-white mr-2"></span>
                        <span class="text-gray-300 text-[13px] tracking-widest uppercase">exclusivo</span>
                    </div>
                    <div class="bg-[#181818] shadow-lg flex flex-row w-full h-full" style="border-radius:0; min-height:320px; min-height:220px;">
                        <div class="flex items-center justify-center bg-[#232323] w-1/2 h-full" style="border-radius:0; min-height:220px;">
                            <img src="https://cdn11.bigcommerce.com/s-p66uh2e57r/images/stencil/1280x1280/products/48148/67099/Gift_Sets_-_The_Beatles_02_-_SQ__90184.1731579821.jpg?c=1" alt="Berlin Store Rock" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex flex-col justify-center flex-1 px-8 py-10">
                            <h3 class="text-2xl md:text-3xl font-bold uppercase tracking-wider mb-4">Berlin Store</h3>
                            <p class="text-sm uppercase tracking-widest text-gray-300 mb-2">Próxima fecha:<br>Viernes<br>12 de septiembre<br>10 - 17 h</p>
                            <p class="text-sm uppercase tracking-widest text-gray-300 mb-6">Dirección:<br>Hertzstrasse 63B<br>13158 Berlin</p>
                            <button class="bg-white text-black px-6 py-2 font-bold uppercase tracking-widest shadow" style="border-radius:0;">Saber más</button>
                        </div>
                    </div>
                </div>
            </div>
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

    {{-- JS del carrusel --}}
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const root = document.querySelector('#carousel');
                    const track = root.querySelector('[data-carousel-track]');
                    const slides = Array.from(track.children);
                    const prevBtn = root.querySelector('[data-carousel-prev]');
                    const nextBtn = root.querySelector('[data-carousel-next]');
                    const dotsWrap = root.querySelector('[data-carousel-dots]');
                    const dots = Array.from(dotsWrap.children);

                    // Detalle fijo
                    const detail = document.getElementById('carousel-detail');
                    const title = document.getElementById('carousel-title');
                    const subtitle = document.getElementById('carousel-subtitle');
                    const price = document.getElementById('carousel-price');

                    // Data
                    const popular = @json($popular);

                    let index = 0;
                    let autoplayMs = 4500;
                    let timer = null;

                    function updateDetail(i) {
                        title.textContent = popular[i].title;
                        if (subtitle) {
                            subtitle.textContent = popular[i].subtitle || '';
                            subtitle.style.display = popular[i].subtitle ? '' : 'none';
                        }
                        price.textContent = popular[i].price;
                    }

                    function go(i) {
                        index = (i + slides.length) % slides.length;
                        track.style.transform = `translateX(-${index * 100}%)`;
                        dots.forEach((d, di) => {
                            d.style.background = di === index ? 'rgba(255,255,255,0.9)' : 'rgba(255,255,255,0.3)';
                        });
                        updateDetail(index);
                    }

                    function play() {
                        stop();
                        timer = setInterval(() => go(index + 1), autoplayMs);
                    }

                    function stop() {
                        if (timer) {
                            clearInterval(timer);
                            timer = null;
                        }
                    }

                    prevBtn?.addEventListener('click', () => {
                        go(index - 1);
                        play();
                    });
                    nextBtn?.addEventListener('click', () => {
                        go(index + 1);
                        play();
                    });
                    dots.forEach((dot, di) => dot.addEventListener('click', () => {
                        go(di);
                        play();
                    }));

                    root.addEventListener('mouseenter', stop);
                    root.addEventListener('mouseleave', play);

                    go(0);
                    play();
                });
            </script>
@endsection
