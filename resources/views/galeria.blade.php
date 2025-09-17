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
                    <h1 class="text-4xl lg:text-6xl font-black tracking-tight">Vibes & Beats</h1>
                    <p class="mt-4 text-neutral-300 max-w-xl">
                        Galería multimedia con fotos y clips que transmiten la energía y el ritmo de la música. </p>
                    <div class="mt-8 flex items-center gap-4">
                        <a href="#galeria" class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/15 transition">
                            Ver galería
                        </a>
                        <div class="relative w-12 h-12">
                            <!-- Vinilo girando -->
                            <svg viewBox="0 0 100 100"
                                class="absolute inset-0 w-full h-full drop-shadow-sm animate-spin-slow">
                                <circle cx="50" cy="50" r="46" fill="#111" stroke="#444"
                                    stroke-width="2" />
                                <circle cx="50" cy="50" r="42" fill="none" stroke="#222" stroke-width="4"
                                    stroke-dasharray="6 6" />
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
                <h2 class="text-2xl lg:text-3xl font-bold">Galería Multimedia</h2>
                <div class="flex items-center gap-2">
                    <button class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 active-filter"
                        data-filter="all">Todo</button>
                    <button class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15"
                        data-filter="foto">Fotos</button>
                    <button class="filter-btn px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15"
                        data-filter="video">Videos</button>
                </div>
            </div>

            <!-- Grid responsive -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
                <!-- Foto -->
                <article
                    class="card group media-foto rounded-3xl overflow-hidden bg-white/5 ring-1 ring-white/10 hover:ring-white/20 transition">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="/images/imagen2.jpg" alt="Imagine Dragons - Backstage de la gira Evolve"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold">Backstage — Gira <em>Evolve</em></h3>
                            <p class="text-sm text-neutral-400">Imagine Dragons</p>
                        </div>

                    </div>
                </article>

                <!-- Foto -->
                <article
                    class="card group media-foto rounded-3xl overflow-hidden bg-white/5 ring-1 ring-white/10 hover:ring-white/20 transition">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="/images/imagen3.jpg" alt="Imagine Dragons - Sesión en estudio para Night Visions"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold">Studio Session — <em>Night Visions</em></h3>
                            <p class="text-sm text-neutral-400">Preproducción & tomas B-roll</p>
                        </div>

                    </div>
                </article>

                <!-- Video -->
                <article
                    class="card group media-video rounded-3xl overflow-hidden bg-white/5 ring-1 ring-white/10 hover:ring-white/20 transition">
                    <div class="aspect-video overflow-hidden">
                        <video src="/videos/clip1.mp4" controls class="w-full h-full object-cover"></video>
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold">“Believer” — Live Jam</h3>
                            <p class="text-sm text-neutral-400">Sesión nocturna · Tomada en vivo</p>
                        </div>

                    </div>
                </article>

                <!-- Video -->
                <article
                    class="card group media-video rounded-3xl overflow-hidden bg-white/5 ring-1 ring-white/10 hover:ring-white/20 transition">
                    <div class="aspect-video overflow-hidden relative">
                        <video src="/videos/clip2.mp4" controls poster="/images/galeria/poster2.jpg"
                            class="w-full h-full object-cover"></video>
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold">“Radioactive” — Ensayo Acústico</h3>
                            <p class="text-sm text-neutral-400">Warm-up en estudio</p>
                        </div>

                    </div>
                </article>
            </div>
        </section>

        </div>
    </div>

    <!-- Estilos utilitarios para animaciones mínimas -->
    <style>
        /* Vinilo: giro lento */
        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }

        /* Microinteracciones tarjetas */
        .card {
            transition: transform .25s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        /* Botones de filtro */
        .filter-btn {
            transition: background .2s ease, transform .2s ease;
        }

        .filter-btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .active-filter {
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .25);
        }
    </style>

    <!-- JS mínimo para filtros -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.filter-btn');
            const cards = document.querySelectorAll('.card');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    buttons.forEach(b => b.classList.remove('active-filter'));
                    btn.classList.add('active-filter');

                    const filter = btn.dataset.filter;
                    cards.forEach(card => {
                        const isPhoto = card.classList.contains('media-foto');
                        const isVideo = card.classList.contains('media-video');
                        let show = false;
                        if (filter === 'all') show = true;
                        if (filter === 'foto' && isPhoto) show = true;
                        if (filter === 'video' && isVideo) show = true;
                        card.style.display = show ? '' : 'none';
                    });
                });
            });
        });
    </script>
@endsection
