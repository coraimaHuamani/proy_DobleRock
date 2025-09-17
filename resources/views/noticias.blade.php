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

            {{-- DATA DEMO (cámbialo por tu foreach) --}}
            @php
                $events = [
                    [
                        'title' => 'Lanzamiento de nuevo álbum',
                        'description' => 'El single principal adelanta un sonido más crudo y una gira sudamericana.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Lanzamiento',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Show en Lima con invitados sorpresa y preventa limitada.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Concierto',
                    ],
                    [
                        'title' => 'Nuevo concierto',
                        'description' => 'Fecha extra anunciada por alta demanda.',
                        'date' => '10 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1483412033650-1015ddeb83d1?auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Concierto',
                    ],
                    [
                        'title' => 'Lanzamiento de nuevo álbum',
                        'description' => 'Edición deluxe en vinilo rojo con booklet fotográfico.',
                        'date' => '15 Oct, 2025',
                        'img' =>
                            'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Lanzamiento',
                    ],
                ];
            @endphp

            {{-- GRID --}}
            <div id="events-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-5 gap-8 mb-8"></div>

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

    <style>
        /* Typewriter */
        .typewriter {
            position: relative
        }

        .caret {
            display: inline-block;
            margin-left: 4px;
            color: #e7452e;
            animation: blink .9s steps(1, end) infinite
        }

        @keyframes blink {
            50% {
                opacity: 0
            }
        }

        /* Sweep under title */
        @keyframes sweepX {
            0% {
                transform: translateX(-30%);
                opacity: .4
            }

            50% {
                opacity: 1
            }

            100% {
                transform: translateX(80%);
                opacity: .4
            }
        }

        .animate-sweep-x {
            animation: sweepX 2.8s ease-in-out infinite
        }

        /* Card base + “neón” conic border on hover (como en galería) */
        .news-card {
            position: relative;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 1rem;
            transition: transform .25s ease, box-shadow .25s ease
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 40px rgba(0, 0, 0, .35)
        }

        .news-card::before {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            background: conic-gradient(from 0deg, #e7452e, transparent 20%, #e7452e 40%, transparent 60%, #e7452e 80%, transparent);
            filter: blur(10px);
            opacity: 0;
            transition: opacity .25s
        }

        .news-card:hover::before {
            opacity: .28
        }

        /* Accent sweep bottom */
        .news-card::after {
            content: "";
            position: absolute;
            left: 10%;
            right: 10%;
            bottom: -1px;
            height: 2px;
            opacity: .2;
            background: linear-gradient(90deg, transparent, #e7452e, transparent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s ease, opacity .35s
        }

        .news-card:hover::after {
            transform: scaleX(1);
            opacity: .9
        }

        /* Thumb shine (como en galería) */
        .thumb {
            position: relative;
            overflow: hidden
        }

        .thumb .shine {
            position: absolute;
            inset: 0;
            background: linear-gradient(60deg, rgba(255, 255, 255, 0) 40%, rgba(255, 255, 255, .18) 50%, rgba(255, 255, 255, 0) 60%);
            transform: translateX(-120%) skewX(-12deg);
            transition: transform .8s ease;
            pointer-events: none
        }

        .group:hover .thumb .shine {
            transform: translateX(120%) skewX(-12deg)
        }

        /* Skeleton shimmer */
        .skeleton {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, .06)
        }

        .skeleton::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, rgba(255, 255, 255, 0) 20%, rgba(255, 255, 255, .14) 40%, rgba(255, 255, 255, 0) 60%);
            animation: shimmer 1.2s linear infinite;
            transform: translateX(-100%)
        }

        @keyframes shimmer {
            to {
                transform: translateX(100%)
            }
        }

        /* Badge fecha */
        .date-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .68rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            background: rgba(231, 69, 46, .12);
            border: 1px solid rgba(231, 69, 46, .35);
            padding: .35rem .55rem;
            border-radius: .5rem;
            animation: datePulse 2.6s ease-in-out infinite
        }

        @keyframes datePulse {

            0%,
            100% {
                box-shadow: 0 0 0 rgba(231, 69, 46, 0)
            }

            50% {
                box-shadow: 0 0 18px rgba(231, 69, 46, .25)
            }
        }

        /* Reveal alternado (reutiliza patrón anterior) */
        .reveal {
            opacity: 0;
            transform: translateY(14px) translateX(var(--rx, 0))
        }

        .revealed {
            opacity: 1;
            transform: translateY(0) translateX(0);
            transition: transform .6s cubic-bezier(.2, .75, .25, 1), opacity .6s
        }

        /* Botón morph + ripple + spinner */
        .btn-morph {
            position: relative;
            overflow: hidden;
            transition: transform .2s ease
        }

        .btn-morph:active {
            transform: translateY(1px) scale(.99)
        }

        .btn-morph .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .8s linear infinite
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .btn-ripple::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            transform: scale(0);
            background: radial-gradient(120px 120px at var(--rx, 50%) var(--ry, 50%), rgba(231, 69, 46, .35), transparent 60%);
            transition: transform .45s ease;
            pointer-events: none
        }

        .btn-ripple.rippling::after {
            transform: scale(1)
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const eventsPerRow = 3;
            const allEvents = @json($events);
            let visibleCount = eventsPerRow;

            const container = document.getElementById('events-container');
            const btn = document.getElementById('more-events-btn');

            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) e.target.classList.add('revealed');
                });
            }, {
                threshold: .14
            });

            function lazyLoadImage(img) {
                const src = img.getAttribute('data-src');
                if (!src) return;
                const real = new Image();
                real.onload = () => {
                    img.src = src;
                    img.classList.remove('opacity-0');
                    const sk = img.parentElement.querySelector('.skeleton');
                    if (sk) sk.remove();
                };
                real.src = src;
            }

            function template(e, idx) {
                const shift = (idx % 2 === 0) ? '-8px' : '8px';
                return `
                <article class="group news-card reveal px-4 py-2" style="--rx:${shift}">
                    <div class="rounded-xl overflow-hidden">
                        <div class="thumb aspect-[1/1] bg-[#232323] relative">
                            <img data-src="${e.img || ''}" alt="${e.title}" class="w-full h-full object-cover block opacity-0 transition-opacity duration-300 rounded-xl">
                            <div class="absolute inset-0 skeleton rounded-xl"></div>
                            <span class="shine"></span>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <span class="date-badge">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                                <path d="M7 3v3M17 3v3M4 11h16M5 7h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            ${e.date || ''}
                        </span>
                        ${e.tag ? `<span class="px-2 py-1 text-[10px] tracking-widest uppercase rounded bg-white/10 border border-white/10">${e.tag}</span>` : ``}
                    </div>

                    <h3 class="mt-3 text-[13px] font-semibold tracking-wider uppercase leading-tight">${e.title}</h3>
                    <p class="mt-3 text-[12px] tracking-wide text-gray-300">${e.description}</p>

                    <button type="button"
                        class="inline-flex items-center gap-1 mt-3 text-[#e7452e] font-semibold tracking-widest text-[12px] group">
                        LEER MÁS
                        <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none">
                            <path d="M4 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </article>`;
            }

            function render() {
                container.innerHTML = "";
                allEvents.slice(0, visibleCount).forEach((e, i) => {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = template(e, i);
                    const card = wrapper.firstElementChild;
                    container.appendChild(card);
                    io.observe(card);
                    lazyLoadImage(card.querySelector('img[data-src]'));
                });
                if (visibleCount >= allEvents.length) btn.style.display = "none";
            }

            render();

            btn.addEventListener('click', (ev) => {
                // ripple
                const rect = btn.getBoundingClientRect();
                btn.style.setProperty('--rx', (ev.clientX - rect.left) + 'px');
                btn.style.setProperty('--ry', (ev.clientY - rect.top) + 'px');
                btn.classList.add('rippling');

                const text = btn.querySelector('span');
                const spinner = btn.querySelector('.spinner');
                spinner.classList.remove('hidden');
                text.textContent = 'Cargando…';
                btn.disabled = true;

                setTimeout(() => {
                    visibleCount += eventsPerRow;
                    render();
                    spinner.classList.add('hidden');
                    btn.disabled = false;
                    btn.classList.remove('rippling');
                    if (visibleCount < allEvents.length) text.textContent = 'Ver más';
                }, 450);
            });
        });
    </script>
@endsection
