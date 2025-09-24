{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\galeria.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen relative text-white px-6 md:px-12 lg:px-24"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative z-10">
            <!-- Hero / Encabezado -->
            <header class="relative overflow-hidden">
                <div class="container mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <h1 class="text-4xl lg:text-6xl font-black tracking-tight">
                            Vibes <span class="text-[#e7452e]">&</span> Beats
                        </h1>
                        <p class="mt-4 text-neutral-300 max-w-xl">
                            Galería multimedia con fotos y clips que transmiten la energía y el ritmo de la música.
                        </p>
                        <div class="mt-8 flex items-center gap-4">
                            <a href="#galeria"
                                class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/15 transition relative overflow-hidden btn-ripple">
                                Ver galería
                            </a>
                            <div class="relative w-12 h-12 will-change-transform" id="vinylParallax">
                                <!-- Vinilo girando (parallax leve al mouse) -->
                                <svg viewBox="0 0 100 100"
                                    class="absolute inset-0 w-full h-full drop-shadow-sm animate-spin-slow">
                                    <circle cx="50" cy="50" r="46" fill="#111" stroke="#444"
                                        stroke-width="2" />
                                    <circle cx="50" cy="50" r="42" fill="none" stroke="#222"
                                        stroke-width="4" stroke-dasharray="6 6" />
                                    <circle cx="50" cy="50" r="6" fill="#e5e7eb" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Controles / Filtros básicos -->
            <section id="galeria" class="container mx-auto px-4 py-10">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold">Galería Multimedia</h2>
                        <div class="h-[2px] w-32 bg-gradient-to-r from-[#e7452e] to-transparent mt-2 animate-sweep-x"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 active-filter btn-ripple"
                            data-filter="all">Todo</button>
                        <button class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 btn-ripple"
                            data-filter="imagen">Fotos</button>
                        <button class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 btn-ripple"
                            data-filter="video">Videos</button>
                    </div>
                </div>

                <!-- Grid responsive con datos dinámicos -->
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5" id="gridReveal">
                    @forelse ($galerias as $index => $item)
                        @php
                            $delay = ($index % 6) * 0.06; // Escalonar las animaciones
                            $mediaClass = $item['tipo'] === 'imagen' ? 'media-foto' : 'media-video';
                        @endphp
                        
                        <article
                            class="card group {{ $mediaClass }} rounded-3xl overflow-hidden bg-white/5 ring-1 ring-white/10 hover:ring-white/20 transition neon-hover reveal"
                            style="--reveal-delay: {{ $delay }}s">
                            <div class="thumb {{ $item['tipo'] === 'imagen' ? 'aspect-[4/3]' : 'aspect-video' }} overflow-hidden relative">
                                @if($item['tipo'] === 'imagen' && $item['archivo_url'])
                                    <img src="{{ $item['archivo_url'] }}" 
                                         alt="{{ $item['titulo'] }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @elseif($item['tipo'] === 'video' && $item['archivo_url'])
                                    <video src="{{ $item['archivo_url'] }}" 
                                           class="w-full h-full object-cover" 
                                           muted playsinline></video>
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                                        <i class="fa-solid fa-{{ $item['tipo'] === 'imagen' ? 'image' : 'video' }} text-4xl text-gray-500"></i>
                                    </div>
                                @endif
                                <span class="shine"></span>
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold truncate">{{ $item['titulo'] }}</h3>
                                    @if($item['descripcion'])
                                        <p class="text-sm text-neutral-400 truncate">{{ $item['descripcion'] }}</p>
                                    @else
                                        <p class="text-sm text-neutral-400">{{ $item['tipo_nombre'] }}</p>
                                    @endif
                                </div>
                                @if($item['archivo_url'])
                                    <button class="open-lightbox text-sm underline decoration-[#e7452e] ml-2 flex-shrink-0" 
                                            data-type="{{ $item['tipo'] === 'imagen' ? 'image' : 'video' }}"
                                            data-src="{{ $item['archivo_url'] }}">Ver</button>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-500 mb-4">
                                <i class="fa-solid fa-images text-6xl text-gray-500"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">Galería vacía</h3>
                            <p class="text-gray-400">Aún no hay contenido disponible en la galería.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- Modal / Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-[60] hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/80 opacity-0 transition-opacity"></div>
        <div
            class="relative max-w-6xl w-[92vw] md:w-[80vw] rounded-2xl overflow-hidden ring-1 ring-white/10 scale-95 opacity-0 transition-all">
            <button id="lbClose" class="absolute top-3 right-3 px-3 py-1 rounded-md bg-white/10 hover:bg-white/15">Cerrar ✕</button>
            <div id="lbContent" class="bg-neutral-900"></div>
        </div>
    </div>

    <!-- Estilos utilitarios y animaciones -->
    <style>
        /* Giro lento del vinilo */
        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }

        /* Reveal escalonado al scroll */
        @keyframes revealUp {
            from {
                transform: translateY(12px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(12px);
        }

        .revealed {
            animation: revealUp .6s cubic-bezier(.2, .75, .25, 1) forwards;
            animation-delay: var(--reveal-delay, 0s);
        }

        /* Línea que barre horizontalmente bajo el título */
        @keyframes sweepX {
            0% {
                transform: translateX(-30%);
                opacity: .4;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateX(80%);
                opacity: .4;
            }
        }

        .animate-sweep-x {
            animation: sweepX 2.8s ease-in-out infinite;
        }

        /* Hover con borde "neón" usando conic-gradient */
        @keyframes conicSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .neon-hover {
            position: relative;
        }

        .neon-hover::before {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: 1.5rem;
            z-index: -1;
            background: conic-gradient(from 0deg, #e7452e, transparent 20%, #e7452e 40%, transparent 60%, #e7452e 80%, transparent);
            filter: blur(10px);
            opacity: 0;
            transform: rotate(0deg);
            transition: opacity .25s ease;
        }

        .neon-hover:hover::before {
            opacity: .35;
            animation: conicSpin 3s linear infinite;
        }

        /* Destello diagonal sobre miniaturas */
        .thumb {
            position: relative;
        }

        .thumb .shine {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(60deg, rgba(255, 255, 255, 0) 40%, rgba(255, 255, 255, .18) 50%, rgba(255, 255, 255, 0) 60%);
            transform: translateX(-120%) skewX(-12deg);
            transition: transform .8s ease;
        }

        .group:hover .thumb .shine {
            transform: translateX(120%) skewX(-12deg);
        }

        /* Microinteracciones tarjetas */
        .card {
            transition: transform .25s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        /* Botones de filtro + ripple */
        .filter-btn {
            transition: background .2s ease, transform .2s ease;
            position: relative;
            overflow: hidden;
        }

        .filter-btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .active-filter {
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .25);
        }

        .btn-ripple::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: .75rem;
            transform: scale(0);
            background: radial-gradient(120px 120px at var(--rx, 50%) var(--ry, 50%), rgba(231, 69, 46, .35), transparent 60%);
            transition: transform .45s ease;
            pointer-events: none;
        }

        .btn-ripple.rippling::after {
            transform: scale(1);
        }

        /* Modal transitions */
        #lightbox.show>div:first-child {
            opacity: 1 !important;
        }

        #lightbox.show>div:last-child {
            opacity: 1 !important;
            transform: scale(1) !important;
        }
    </style>

    <!-- JS mínimo: filtros, reveal on scroll, ripple, lightbox, parallax -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Filtros actualizados para usar 'imagen' y 'video'
            const buttons = document.querySelectorAll('.filter-btn');
            const cards = document.querySelectorAll('.card');
            buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    buttons.forEach(b => b.classList.remove('active-filter'));
                    btn.classList.add('active-filter');
                    // ripple
                    const rect = btn.getBoundingClientRect();
                    btn.style.setProperty('--rx', (e.clientX - rect.left) + 'px');
                    btn.style.setProperty('--ry', (e.clientY - rect.top) + 'px');
                    btn.classList.add('rippling');
                    setTimeout(() => btn.classList.remove('rippling'), 350);

                    const filter = btn.dataset.filter;
                    cards.forEach(card => {
                        const isPhoto = card.classList.contains('media-foto');
                        const isVideo = card.classList.contains('media-video');
                        let show = (filter === 'all') || (filter === 'imagen' && isPhoto) || (filter === 'video' && isVideo);
                        card.style.display = show ? '' : 'none';
                    });
                });
            });

            // Reveal on scroll (IntersectionObserver)
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('revealed');
                });
            }, {
                threshold: 0.12
            });
            document.querySelectorAll('.reveal').forEach(el => io.observe(el));

            // Lightbox
            const lb = document.getElementById('lightbox');
            const lbBackdrop = lb.children[0];
            const lbBox = lb.children[1];
            const lbContent = document.getElementById('lbContent');
            const lbClose = document.getElementById('lbClose');

            function openLB(type, src) {
                lb.classList.remove('hidden');
                lb.classList.add('flex');
                // reset transitions start
                lbBackdrop.classList.remove('opacity-0');
                lbBox.classList.remove('opacity-0', 'scale-95');
                lb.classList.add('show');

                lbContent.innerHTML = '';
                if (type === 'image') {
                    const img = document.createElement('img');
                    img.src = src;
                    img.alt = 'preview';
                    img.className = 'w-full h-auto';
                    lbContent.appendChild(img);
                } else {
                    const vid = document.createElement('video');
                    vid.src = src;
                    vid.controls = true;
                    vid.autoplay = true;
                    vid.className = 'w-full h-auto';
                    lbContent.appendChild(vid);
                }
            }

            function closeLB() {
                lb.classList.remove('show');
                // end animation then hide
                setTimeout(() => {
                    lb.classList.add('hidden');
                    lb.classList.remove('flex');
                    lbContent.innerHTML = '';
                }, 180);
                lbBackdrop.classList.add('opacity-0');
                lbBox.classList.add('opacity-0', 'scale-95');
            }
            
            document.querySelectorAll('.open-lightbox').forEach(btn => {
                btn.addEventListener('click', () => openLB(btn.dataset.type, btn.dataset.src));
            });
            lbBackdrop.addEventListener('click', closeLB);
            lbClose.addEventListener('click', closeLB);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !lb.classList.contains('hidden')) closeLB();
            });

            // Parallax leve en el vinilo
            const vinyl = document.getElementById('vinylParallax');
            vinyl?.addEventListener('mousemove', (e) => {
                const r = vinyl.getBoundingClientRect();
                const cx = r.left + r.width / 2,
                    cy = r.top + r.height / 2;
                const dx = (e.clientX - cx) / r.width,
                    dy = (e.clientY - cy) / r.height;
                vinyl.style.transform = `translateZ(0) rotateX(${ -dy * 8 }deg) rotateY(${ dx * 8 }deg)`;
            });
            vinyl?.addEventListener('mouseleave', () => {
                vinyl.style.transform = 'rotateX(0) rotateY(0)';
            });
        });
    </script>
@endsection
