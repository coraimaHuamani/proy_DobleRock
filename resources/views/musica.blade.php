@extends('layouts.app')

@section('content')
    <div class="min-h-screen relative text-white px-6 md:px-12 lg:px-24"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/80"></div>

        <style>
            /* Estética y micro-animaciones */
            .card {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                background: rgba(255, 255, 255, .05);
                border: 1px solid rgba(255, 255, 255, .08);
                border-radius: 1.5rem;
                transition: transform .25s ease, box-shadow .25s ease
            }

            .card:hover {
                transform: translateY(-3px);
                box-shadow: 0 16px 40px rgba(0, 0, 0, .35)
            }

            .tab-active {
                position: relative
            }

            .tab-active::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                bottom: -2px;
                height: 2px;
                background: linear-gradient(90deg, transparent, #e7452e, transparent)
            }

            @keyframes eq {

                0%,
                100% {
                    transform: scaleY(.3)
                }

                50% {
                    transform: scaleY(1)
                }
            }

            .eq-col {
                width: 6px;
                height: 18px;
                border-radius: 9999px;
                background: #e7452e;
                transform-origin: bottom;
                animation: eq var(--t, 1.3s) ease-in-out infinite;
                opacity: .9
            }

            @keyframes revealUp {
                from {
                    opacity: 0;
                    transform: translateY(10px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            .reveal {
                opacity: 0;
                transform: translateY(10px)
            }

            .reveal.show {
                animation: revealUp .45s ease forwards
            }

            .btn-play {
                width: 36px;
                height: 36px;
                border-radius: 9999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #e7452e;
                font-weight: 700
            }

            .btn-play:hover {
                opacity: .9
            }

            .btn-play[aria-pressed="true"] {
                box-shadow: 0 0 0 6px rgba(231, 69, 46, .18)
            }

            .np-bar {
                position: fixed;
                left: 50%;
                transform: translateX(-50%);
                bottom: 16px;
                z-index: 40
            }

            .np-eq {
                display: flex;
                align-items: flex-end;
                gap: 2px;
                height: 12px
            }

            .np-eq span {
                width: 3px;
                background: #e7452e;
                border-radius: 9999px;
                transform-origin: bottom
            }

            .np-eq.playing span {
                animation: eq 1.2s ease-in-out infinite
            }

            .progress {
                appearance: none;
                width: 100%;
                height: 4px;
                border-radius: 9999px;
                background: rgba(255, 255, 255, .15);
                overflow: hidden
            }

            .progress::-webkit-slider-thumb {
                appearance: none;
                width: 0;
                height: 0
            }

            .progress-fill {
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                background: #e7452e;
                border-radius: 9999px;
                pointer-events: none
            }
        </style>

        <div class="relative z-10">
            <!-- HERO -->
            <header class="relative">
                <div class="container mx-auto px-4 py-12 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <h1 class="text-4xl lg:text-6xl font-black tracking-tight text-left">Música</h1>
                        <p class="mt-4 text-neutral-300 max-w-xl text-left">Explora nuestras <strong>canciones</strong>,
                            <strong>álbumes</strong> y <strong>playlists</strong> y escúchalas aquí mismo.
                        </p>
                        <div class="mt-6 flex items-end gap-1 h-6">
                            <span class="eq-col" style="--t:1.1s"></span><span class="eq-col" style="--t:1.4s"></span>
                            <span class="eq-col" style="--t:1.2s"></span><span class="eq-col" style="--t:1.35s"></span>
                            <span class="eq-col" style="--t:1.15s"></span>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center justify-center">
                        <span class="relative w-32 h-32">
                            <!-- Vinilo girando con mejoras -->
                            <svg viewBox="0 0 100 100"
                                class="absolute inset-0 w-full h-full drop-shadow-lg animate-vinyl-spin">
                                <!-- Círculo principal -->
                                <circle cx="50" cy="50" r="46" fill="#111" stroke="#333"
                                    stroke-width="2" />
                                <!-- Surcos -->
                                <circle cx="50" cy="50" r="42" fill="none" stroke="#222" stroke-width="3"
                                    stroke-dasharray="4 4" />
                                <circle cx="50" cy="50" r="38" fill="none" stroke="#222" stroke-width="2"
                                    stroke-dasharray="2 6" />
                                <!-- Brillo en movimiento -->
                                <circle cx="50" cy="50" r="46" fill="url(#shine)" opacity="0.15" />
                                <!-- Centro -->
                                <circle cx="50" cy="50" r="6" fill="#e5e7eb" class="animate-pulse-center" />
                                <defs>
                                    <linearGradient id="shine" x1="0%" y1="0%" x2="100%"
                                        y2="0%">
                                        <stop offset="0%" stop-color="white" stop-opacity="0" />
                                        <stop offset="50%" stop-color="white" stop-opacity="0.8" />
                                        <stop offset="100%" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>
                    </div>

                    <style>
                        @keyframes vinyl-spin {
                            0% {
                                transform: rotate(0deg);
                            }

                            40% {
                                transform: rotate(180deg);
                            }

                            70% {
                                transform: rotate(270deg);
                            }

                            100% {
                                transform: rotate(360deg);
                            }
                        }

                        .animate-vinyl-spin {
                            animation: vinyl-spin 6s cubic-bezier(.45, .05, .55, .95) infinite;
                            transform-origin: 50% 50%;
                        }

                        @keyframes pulse-center {

                            0%,
                            100% {
                                r: 6;
                                fill: #e5e7eb;
                            }

                            50% {
                                r: 7;
                                fill: #e7452e;
                            }
                        }

                        .animate-pulse-center {
                            animation: pulse-center 2.5s ease-in-out infinite;
                        }
                    </style>

                </div>
            </header>

            <!-- TABS -->
            <section class="container mx-auto px-4">
                <div role="tablist" aria-label="Música" class="flex flex-wrap gap-2">
                    <button role="tab" id="tab-canciones" aria-controls="panel-canciones" aria-selected="true"
                        class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 transition tab-active">Canciones</button>
                    <button role="tab" id="tab-albumes" aria-controls="panel-albumes" aria-selected="false"
                        class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 transition">Álbumes</button>
                    <button role="tab" id="tab-playlists" aria-controls="panel-playlists" aria-selected="false"
                        class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 transition">Playlists</button>
                </div>
            </section>

            <!-- DATA DEMO (pon tus rutas MP3 reales en 'src') -->
            @php
                $canciones = [
                    [
                        'titulo' => 'La leyenda del hada y el mago',
                        'artista' => 'Rata blanca',
                        'duracion' => '5:20',
                        'src' => asset('storage/songs/musica1.mp3'),
                    ],
                    [
                        'titulo' => 'Mujer Amante',
                        'artista' => 'Rata blanca',
                        'duracion' => '5:55',
                        'src' => '/storage/songs/musica2.mp3',
                    ],
                    [
                        'titulo' => 'La leyenda del hada y el mago',
                        'artista' => 'Rata blanca',
                        'duracion' => '5:20',
                        'src' => asset('storage/songs/musica1.mp3'),
                    ],
                    [
                        'titulo' => 'Mujer Amante',
                        'artista' => 'Rata blanca',
                        'duracion' => '5:55',
                        'src' => '/storage/songs/musica2.mp3',
                    ],
                ];
                $albumes = [
                    [
                        'nombre' => 'Doble Rock Vol. 1',
                        'anio' => 2023,
                        'pistas' => 12,
                        'cover' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&auto=format&fit=crop',
                        'sample' => '/audio/vol1-sample.mp3',
                        'artista' => 'Doble Rock',
                    ],
                    [
                        'nombre' => 'Rock Sin Fronteras',
                        'anio' => 2022,
                        'pistas' => 10,
                        'cover' =>
                            'https://images.unsplash.com/photo-1483412033650-1015ddeb83d1?q=80&w=300&auto=format&fit=crop',
                        'sample' => '/audio/rsf-sample.mp3',
                        'artista' => 'Doble Rock',
                    ],
                    [
                        'nombre' => 'Live at Lima',
                        'anio' => 2021,
                        'pistas' => 8,
                        'cover' =>
                            'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=300&auto=format&fit=crop',
                        'sample' => '/audio/live-lima-sample.mp3',
                        'artista' => 'Doble Rock',
                    ],
                ];
                
            @endphp

            <!-- PANELES -->
            <section class="container mx-auto px-4 py-8">
                <!-- Canciones -->
                <div id="panel-canciones" role="tabpanel" aria-labelledby="tab-canciones" class="reveal show">
                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-[#e7452e] mb-4">Canciones</h2>
                        <ul class="divide-y divide-white/10">
                            @foreach ($songs as $song)
                                <li class="py-3 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <button class="btn-play text-white" aria-label="Reproducir {{ $song['titulo'] }}"
                                            data-src="{{ $song['src'] }}" data-title="{{ $song['titulo'] }}"
                                            data-artist="{{ $song['artista'] }}">
                                            <!-- Icono play/pause -->
                                            <svg class="icon-play w-4 h-4 pointer-events-none " viewBox="0 0 24 24"
                                                fill="none">
                                                <path d="M6 4l14 8-14 8V4z" fill="currentColor" />
                                            </svg>
                                            <svg class="icon-pause w-4 h-4 pointer-events-none hidden" viewBox="0 0 24 24"
                                                fill="none">
                                                <path d="M7 5h4v14H7zM13 5h4v14h-4z" fill="currentColor" />
                                            </svg>
                                        </button>
                                        <div>
                                            <p class="font-semibold">{{ $song['titulo'] }}</p>
                                            <p class="text-xs text-neutral-400">{{ $song['artista'] }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-neutral-400">{{  $song['duracion']}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Álbumes -->
                <div id="panel-albumes" role="tabpanel" aria-labelledby="tab-albumes" hidden class="reveal">
                    <div id="album-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($albums as $album)
                            <article class="card p-4">
                                <div class="aspect-[4/3] rounded-xl overflow-hidden mb-4">
                                    <img src="{{ $album['cover'] }}" alt="{{ $album['nombre'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <h3 class="font-semibold">{{ $album['nombre'] }}</h3>
                                <p class="text-sm text-neutral-400">{{ $album['anio'] }} • {{ $album['pistas'] }} pistas</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <button onclick="window.location.hash='album#id={{ $album['id'] }}'" 
                                        class="px-3 py-1 rounded bg-white/10 hover:bg-white/15 text-xs">Detalles</button>
                                    <button class="btn-play text-white"
                                        aria-label="Reproducir muestra {{ $album['nombre'] }}"
                                        data-src="{{ $album['sample'] }}" data-title="{{ $album['nombre'] }} (muestra)"
                                        data-artist="{{ $album['artista'] }}">
                                        <svg class="icon-play w-4 h-4 pointer-events-none " viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M6 4l14 8-14 8V4z" fill="currentColor" />
                                        </svg>
                                        <svg class="w-4 h-4 pointer-events-none icon-pause hidden" viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M7 5h4v14H7zM13 5h4v14h-4z" fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- Panel dinámico para detalle del álbum -->
                    <div id="album-details" class="hidden"></div>
                </div>
                

                <!-- Playlists -->
                <div id="panel-playlists" role="tabpanel" aria-labelledby="tab-playlists" hidden class="reveal">
                    <div id="playlist-list" class="card p-6">
                        <h2 class="text-xl font-bold text-[#e7452e] mb-4">Playlists</h2>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($playlists as $playlist)
                                <li
                                    class="flex items-center justify-between bg-white/5 rounded-xl p-4 ring-1 ring-white/10">
                                    <div>
                                        <p class="font-semibold">{{ $playlist['nombre'] }}</p>
                                        <p class="text-xs text-neutral-400">{{ $playlist['items'] }} canciones</p>
                                        <button onclick="window.location.hash='playlist#id={{ $playlist['id'] }}'" 
                                            class="px-3 py-1 mt-4 rounded bg-white/10 hover:bg-white/15 text-xs">Detalles</button>
                                    </div>
                                    <button class="btn-play text-white"
                                        aria-label="Reproducir muestra playlist {{ $playlist['nombre'] }}"
                                        data-src="{{ $playlist['sample'] }}" data-title="{{ $playlist['nombre'] }} (muestra)"
                                        data-artist="{{ $playlist['artista'] }}">
                                        <svg class="w-4 h-4 pointer-events-none icon-play" viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M6 4l14 8-14 8V4z" fill="currentColor" />
                                        </svg>
                                        <svg class="w-4 h-4 pointer-events-none icon-pause hidden" viewBox="0 0 24 24"
                                            fill="none">
                                            <path d="M7 5h4v14H7zM13 5h4v14h-4z" fill="currentColor" />
                                        </svg>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Panel dinámico para detalle de la playlist -->
                    <div id="playlist-details" class="hidden"></div>

                </div>
            </section>
    </div>

<script src="{{ asset('js/songPlayer.js') }}"></script>
    <!-- JS: Tabs + Player -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Tabs ---
            const tabs = [{
                    btn: '#tab-canciones',
                    panel: '#panel-canciones'
                },
                {
                    btn: '#tab-albumes',
                    panel: '#panel-albumes'
                },
                {
                    btn: '#tab-playlists',
                    panel: '#panel-playlists'
                },
            ];

            function activate(idx, pushHash = true) {
                tabs.forEach((t, i) => {
                    const b = document.querySelector(t.btn),
                        p = document.querySelector(t.panel);
                    const on = i === idx;
                    b.setAttribute('aria-selected', on);
                    b.classList.toggle('tab-active', on);
                    if (on) {
                        p.hidden = false;
                        p.classList.add('show');
                    } else {
                        p.hidden = true;
                        p.classList.remove('show');
                    }
                });
                if (pushHash) location.hash = tabs[idx].panel.replace('#panel-', '');
                document.querySelector(tabs[idx].panel).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            tabs.forEach((t, i) => document.querySelector(t.btn).addEventListener('click', () => activate(i)));
            const map = {
                '#canciones': 0,
                '#albumes': 1,
                '#playlists': 2
            };
            const h = location.hash.toLowerCase();
            if (map[h] != null) activate(map[h], false);

            
          
        });
    </script>
@endsection
