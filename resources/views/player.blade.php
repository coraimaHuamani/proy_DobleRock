<!-- resources/views/player.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Player</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">

  <style>
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
</head>
<body>
  <div id="global-player" class="fixed bottom-0 left-0 right-0 bg-black/90 p-4 flex items-center gap-4 border-t border-white/10">
        <button id="npPlayPause" class="text-white" aria-label="Play/Pause" disabled>
            <svg class="icon-play w-6 h-6" viewBox="0 0 24 24" fill="none">
                <path d="M6 4l14 8-14 8V4z" fill="currentColor" />
            </svg>
            <svg class="icon-pause w-6 h-6 hidden" viewBox="0 0 24 24" fill="none">
                <path d="M7 5h4v14H7zM13 5h4v14h-4z" fill="currentColor" />
            </svg>
        </button>
        <div>
            <p id="npTitle" class="font-bold text-white">—</p>
            <p id="npArtist" class="text-xs text-neutral-400">—</p>
        </div>
        
        <div id="npProgressBar" class="w-full h-2 bg-white/20 rounded cursor-pointer relative">
            <div id="npProgressFill" class="h-2 bg-[#e7452e] w-0 rounded"></div>
        </div>
        <audio id="songPlayer" preload="none" crossorigin="anonymous"></audio>

        <div id="npEq" class="hidden">🎵</div>
    </div>
    <script src="{{ asset('js/songPlayer.js') }}"></script>
  </body>
</html>