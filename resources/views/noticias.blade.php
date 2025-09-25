@extends('layouts.app')

@section('content')
    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center"
        style="background-image:url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size:cover; background-position:center;">
        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex flex-col mx-auto px-6 md:px-12 lg:px-24">
            {{-- HERO --}}
            <header class="py-10 text-center">
                <h1 class="mt-5 text-[#e7452e] md:text-2xl tracking-widest uppercase">Noticias y eventos</h1>
                <h2 class="mt-5 text-gray-300 max-w-2xl mx-auto md:text-lg typewriter">
                    Mantente al día con las últimas noticias del mundo del rock, próximos conciertos, lanzamientos de
                    álbumes y eventos exclusivos
                    <span class="caret">|</span>
                </h2>
                <div class="h-[2px] w-40 mx-auto bg-gradient-to-r from-[#e7452e] to-transparent mt-4 animate-sweep-x"></div>
            </header>


            {{-- GRID DE NOTICIAS DINÁMICAS --}}
            <div id="events-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-5 gap-8 mb-8">
                @forelse ($noticias as $index => $noticia)
                    @php
                        $shift = $index % 2 === 0 ? '-8px' : '8px';
                        $imageUrl = $noticia->image
                            ? asset('storage/' . $noticia->image)
                            : 'https://via.placeholder.com/400x300/232323/e7452e?text=Sin+Imagen';
                    @endphp

                    <article class="group news-card reveal px-4 py-2" style="--rx:{{ $shift }}">
                        <div class="rounded-xl overflow-hidden">
                            <div class="thumb aspect-[1/1] bg-[#232323] relative">
                                {{-- DEBUG: Mostrar ruta de imagen --}}
                                <img src="{{ $imageUrl }}" alt="{{ $noticia->title }}"
                                    class="w-full h-full object-cover block transition-opacity duration-300 rounded-xl"
                                    onerror="this.src='https://via.placeholder.com/400x300/ff0000/ffffff?text=Error+Carga';">
                                <span class="shine"></span>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="date-badge">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M7 3v3M17 3v3M4 11h16M5 7h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                {{ $noticia->created_at->format('d/m/Y') }}
                            </span>
                            @if ($noticia->category)
                                <span
                                    class="px-2 py-1 text-[10px] tracking-widest uppercase rounded bg-white/10 border border-white/10">
                                    {{ $noticia->category }}
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">
                            {{ $noticia->title }}
                        </h3>

                        <p class="mt-3 text-[12px] tracking-wide text-gray-300">
                            {{ Str::limit($noticia->description, 100) }}
                        </p>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No hay noticias disponibles</h3>
                        <p class="text-gray-400">Crea algunas noticias desde el dashboard para que aparezcan aquí.</p>
                    </div>
                @endforelse
            </div>

            <button id="more-events-btn" type="button"
                class="mt-3 py-3 px-6 rounded-3xl bg-[#e7452e] text-[16px] font-bold w-fit self-center flex items-center gap-2 btn-morph btn-ripple">
                <span>Ver todas las noticias</span>
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none">
                    <path d="M4 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="spinner hidden"></span>
            </button>
        </div>
    </section>

    {{-- CSS de noticias --}}
    <link rel="stylesheet" href="{{ asset('css/noticias/noticiasMain.css') }}">
    {{-- JS de noticias --}}
    <script src="{{ asset('js/noticias/noticiasMain.js') }}"></script>
@endsection
