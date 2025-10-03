
<div class="min-h-screen relative text-white px-6 md:px-12 lg:px-24"
  style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
  <div class="absolute inset-0 bg-black/80"></div>
    <div class="relative z-10">
      <div class="flex container mx-auto px-4 py-12 lg:py-20 gap-10 items-center">
        <img src="{{ $playlistData['cover'] }}" alt="{{ $playlistData['nombre'] }}"
             class="w-40 h-40 object-cover rounded-lg shadow">
        <div>
            <h1 class="text-3xl font-bold">{{ $playlistData['nombre'] }}</h1>
            <p class="text-neutral-400">• {{ $playlistData['items'] }} canciones</p>
        </div>
      </div>

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
      </style>


      <div class="card p-6 mx-auto">
        <h2 class="text-xl font-bold text-[#e7452e] mb-4">Canciones</h2>
        <ul class="divide-y divide-white/10">
            @foreach ($playlistData['canciones'] as $c)
                <li class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button class="btn-play text-white"
                            aria-label="Reproducir {{ $c['titulo'] }}"
                            data-src="{{ $c['src'] }}" data-title="{{ $c['titulo'] }}"
                            data-artist="{{ $c['artista'] }}">
                            <svg class="icon-play w-4 h-4" viewBox="0 0 24 24" fill="none">
                                <path d="M6 4l14 8-14 8V4z" fill="currentColor" />
                            </svg>
                            <svg class="icon-pause w-4 h-4 hidden" viewBox="0 0 24 24" fill="none">
                                <path d="M7 5h4v14H7zM13 5h4v14h-4z" fill="currentColor" />
                            </svg>
                        </button>
                        <div>
                            <p class="font-semibold">{{ $c['titulo'] }}</p>
                            <p class="text-xs text-neutral-400">{{ $c['artista'] }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-neutral-400">{{ $c['duracion'] }}</span>
                </li>
            @endforeach
        </ul>
      </div>
    </div>
</div>
