@extends('layouts.app')

@section('content')
    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center"
        style="background-image: url('{{ asset('images/fondoTienda.jpg') }}')">

        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/80"></div>

        <!-- Contenido -->
        <div class="relative mx-auto px-6 md:px-12 lg:px-24">

            {{-- HERO --}}
            <header class="py-10 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-wide text-[#e7452e] uppercase">
                    Tienda Virtual
                </h1>
                <p class="mt-3 text-base md:text-lg text-gray-300 tracking-widest uppercase">
                    Productos musicales, merchandising y otros artículos
                </p>
            </header>

            {{-- CAROUSEL --}}
            @php
                $popular = [
                    [
                        'title' => 'VINILO DOBLE "MUTTER"',
                        'subtitle' => 'Edición remasterizada',
                        'price' => '28,00 EUR',
                        'badge' => 'preorder',
                        'img' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800',
                        'img2' => 'https://images.unsplash.com/photo-1619983081763-26c7764d5fc2?w=800',
                    ],
                    [
                        'title' => 'CAMISETA LOGO CLÁSICO',
                        'subtitle' => '100% algodón',
                        'price' => '25,00 EUR',
                        'badge' => 'lifad',
                        'img' => 'https://images.pexels.com/photos/6311396/pexels-photo-6311396.jpeg?w=800',
                        'img2' => 'https://images.pexels.com/photos/6311399/pexels-photo-6311399.jpeg?w=800',
                    ],
                    [
                        'title' => 'CD ÁLBUM "ZEIT"',
                        'subtitle' => 'Edición estándar',
                        'price' => '15,00 EUR',
                        'badge' => null,
                        'img' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800',
                        'img2' => 'https://images.unsplash.com/photo-1619983081763-26c7764d5fc2?w=800',
                    ],
                ];
            @endphp

            <div id="carousel" class="relative mb-12">
                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <div class="flex transition-transform duration-500" data-carousel-track>
                        @foreach ($popular as $p)
                            <div class="min-w-full grid md:grid-cols-2">
                                {{-- Imagen con swap hover --}}
                                <a href="#"
                                    class="relative block aspect-[16/10] md:aspect-auto md:h-[360px] overflow-hidden">
                                    <img src="{{ $p['img'] }}" alt=""
                                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 opacity-100 hover:opacity-0">
                                    <img src="{{ $p['img2'] }}" alt=""
                                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 opacity-0 hover:opacity-100">
                                    @if ($p['badge'] === 'preorder')
                                        <span
                                            class="absolute left-3 top-3 z-10 text-[10px] uppercase tracking-widest bg-sky-600 text-white px-2 py-1 rounded">preorder</span>
                                    @elseif($p['badge'] === 'lifad')
                                        <span
                                            class="absolute left-3 top-3 z-10 text-[10px] uppercase tracking-widest bg-emerald-600 text-white px-2 py-1 rounded">lifad</span>
                                    @endif
                                </a>
                                {{-- Texto --}}
                                <div class="p-6 md:p-10 flex flex-col justify-center bg-[#121212]">
                                    <h3 class="text-2xl md:text-3xl font-bold uppercase tracking-wider">{{ $p['title'] }}
                                    </h3>
                                    @if ($p['subtitle'])
                                        <p class="mt-1 text-[12px] uppercase tracking-widest text-gray-300">
                                            {{ $p['subtitle'] }}</p>
                                    @endif
                                    <div class="mt-4 text-sm uppercase tracking-widest text-emerald-400">{{ $p['price'] }}
                                    </div>
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
                            </div>
                        @endforeach
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
                <div class="absolute left-1/2 -translate-x-1/2 -bottom-4 flex gap-2" data-carousel-dots>
                    @foreach ($popular as $i => $p)
                        <button type="button" class="w-2.5 h-2.5 rounded-full bg-white/30"
                            aria-label="Ir al slide {{ $i + 1 }}" data-carousel-dot="{{ $i }}"></button>
                    @endforeach
                </div>
            </div>

            {{-- MENÚ --}}
            <nav class="mb-8">
                <ul class="flex justify-center gap-6 uppercase tracking-widest text-sm">
                    <li><a href="#" class="hover:text-orange-400">¿Qué hay de nuevo?</a></li>
                    <li><a href="#" class="hover:text-orange-400">Ropa</a></li>
                    <li><a href="#" class="hover:text-orange-400">Media</a></li>
                    <li><a href="#" class="hover:text-orange-400">Accesorios</a></li>
                    <li><a href="#" class="hover:text-orange-400">LIFAD</a></li>
                </ul>
            </nav>

            {{-- GRID DE PRODUCTOS --}}
            @php
                $products = [
                    ['title' => 'CD Álbum "Zeit"', 'subtitle' => 'Edición estándar', 'price' => '15,00', 'old' => null, 'state' => null, 'img' => null, 'img2' => null],
                    ['title' => 'Vinilo Doble "Mutter"', 'subtitle' => 'Edición remasterizada', 'price' => '28,00', 'old' => '32,00', 'state' => 'preorder', 'img' => null, 'img2' => null],
                    ['title' => 'Camiseta Logo Clásico', 'subtitle' => '100% algodón', 'price' => '25,00', 'old' => null, 'state' => null, 'img' => null, 'img2' => null],
                    ['title' => 'Sudadera "Feuer"', 'subtitle' => 'Con capucha', 'price' => '49,00', 'old' => null, 'state' => 'lifad', 'img' => null, 'img2' => null],
                    ['title' => 'Gorra Negra', 'subtitle' => 'Bordado frontal', 'price' => '19,00', 'old' => null, 'state' => null, 'img' => null, 'img2' => null],
                    ['title' => 'Póster Tour 2025', 'subtitle' => '70x100 cm', 'price' => '12,00', 'old' => null, 'state' => null, 'img' => null, 'img2' => null],
                    ['title' => 'Taza Logo', 'subtitle' => 'Cerámica 300ml', 'price' => '9,00', 'old' => null, 'state' => null, 'img' => null, 'img2' => null],
                    ['title' => 'Llavero Metálico', 'subtitle' => 'Edición limitada', 'price' => '—', 'old' => null, 'state' => 'soldout', 'img' => null, 'img2' => null],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach ($products as $p)
                    <article class="group">
                        <div class="relative overflow-hidden">
                            @if ($p['state'] === 'preorder')
                                <span class="absolute right-3 top-3 z-10 text-[10px] uppercase tracking-widest bg-sky-600 text-white px-2 py-1 rounded">preorder</span>
                            @elseif($p['state'] === 'soldout')
                                <span class="absolute right-3 top-3 z-10 text-[10px] uppercase tracking-widest bg-gray-700 text-white px-2 py-1 rounded">no disponible</span>
                            @elseif($p['state'] === 'lifad')
                                <span class="absolute right-3 top-3 z-10 text-[10px] uppercase tracking-widest bg-emerald-600 text-white px-2 py-1 rounded">lifad</span>
                            @endif

                            {{-- Si no hay imagen --}}
                            <div class="relative block aspect-[1/1] overflow-hidden bg-[#232323] flex items-center justify-center">
                                <span class="text-gray-500 text-xs uppercase tracking-widest">Sin imagen</span>
                            </div>
                        </div>
                        <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">{{ $p['title'] }}</h3>
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
        </div>
    </section>

    {{-- Fondo con estrellas --}}
    <style>
        .shop-wrap {
            background-color: #0d0d0f;
            background-image:
                radial-gradient(circle at 20% 10%, rgba(255, 255, 255, 0.08) 0 1px, transparent 1px),
                radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.06) 0 1px, transparent 1px),
                radial-gradient(circle at 40% 70%, rgba(255, 255, 255, 0.05) 0 1px, transparent 1px),
                radial-gradient(circle at 60% 90%, rgba(255, 255, 255, 0.07) 0 1px, transparent 1px);
            background-size: 16px 16px, 22px 22px, 18px 18px, 24px 24px;
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

            let index = 0;
            let autoplayMs = 4500;
            let timer = null;

            function go(i) {
                index = (i + slides.length) % slides.length;
                track.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((d, di) => {
                    d.style.background = di === index ? 'rgba(255,255,255,0.9)' : 'rgba(255,255,255,0.3)';
                });
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

            prevBtn?.addEventListener('click', () => { go(index - 1); play(); });
            nextBtn?.addEventListener('click', () => { go(index + 1); play(); });
            dots.forEach((dot, di) => dot.addEventListener('click', () => { go(di); play(); }));

            root.addEventListener('mouseenter', stop);
            root.addEventListener('mouseleave', play);

            go(0);
            play();
        });
    </script>
@endsection
