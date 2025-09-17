@extends('layouts.app')

@section('content')
    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/80"></div>
        <!-- Contenido -->
        <div class="relative flex flex-col mx-auto px-6 md:px-12 lg:px-24 ">

            {{-- HERO --}}
            <header class="py-10 text-center  justify-items-center">
                <h1 class="mt-5 text-[#e7452e] md:text-2xl tracking-widest uppercase">Noticias y eventos</h1>
                <h2 class="mt-5 text-gray-300 w-100% max-w-2xl md:text-lg">Mantente al día con las últimas noticias del mundo
                    del rock, próximos conciertos, lanzamientos de álbumes y eventos exclusivos</h2>
            </header>
            {{-- GRID DE EVENTOS Y NOTICIAS --}}
            @php
                $events = [
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo album',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80',
                    ],
                ];
            @endphp
            <div id="events-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-5 gap-10 mb-8">
            </div>
            <button id="more-events-btn" type="button"
                class="mt-3 py-3 px-5 rounded-3xl bg-[#e7452e] hover:border-white text-[16px] font-bold w-fit self-center">
                Ver todas las noticias
            </button>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const eventsPerRow = 3;
            const allEvents = @json($events);
            let visibleCount = eventsPerRow;
            const container = document.getElementById('events-container');
            const btn = document.getElementById('more-events-btn');

            function renderEvents() {
                container.innerHTML = ""
                allEvents.slice(0, visibleCount).forEach(e => {
                    const article = document.createElement("article");
                    article.className = "group";
                    article.innerHTML = `
              <div class="relative overflow-hidden">
                <div class="relative aspect-[1/1] overflow-hidden bg-[#232323] flex items-center justify-center rounded-lg shadow-lg">
                  ${e.img 
                    ? `<img src="${e.img}" alt="${e.title}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg" />` 
                    : `<span class="text-gray-500 text-xs uppercase tracking-widest">Sin imagen</span>`}
                </div>
              </div>
              <div class="mt-5 text-[11px] uppercase tracking-widest">   
                <span class="text-emerald-400">${e.date}</span>
              </div>
              <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">
                ${e.title}
              </h3>
              <p class="mt-3 text-[11px] uppercase tracking-widest text-gray-300">
                ${e.description}
              </p>
              <button type="button"
                  class="group inline-flex items-center gap-1 mt-3 py-2 hover:border-white uppercase text-[13px] text-[#e7452e] font-bold tracking-widest">
                  LEER MÁS
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                      class="w-3 h-3 aria-hidden transition-transform duration-200 group-hover:translate-x-1">
                    <path d="M3 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </button>
            `;
                    container.appendChild(article);
                });
            }

            // Render inicial
            renderEvents();

            // Al hacer click mostramos +4
            btn.addEventListener('click', () => {
                visibleCount += eventsPerRow;
                renderEvents();

                // ocultar botón si ya no hay más
                if (visibleCount >= allEvents.length) {
                    btn.style.display = "none";
                }
            });
        });
    </script>
@endsection
