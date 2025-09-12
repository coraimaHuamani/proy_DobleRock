<div class="group bg-[#1a1a1d] rounded-lg overflow-hidden shadow-lg">
    <div class="relative aspect-[4/3] bg-gray-800 flex items-center justify-center">
        @if ($img)
            <img src="{{ $img }}" alt="{{ $title }}" class="w-full h-full object-cover">
        @else
            <span class="text-gray-500 text-sm uppercase">Sin imagen</span>
        @endif
        @if ($state === 'preorder')
            <span class="absolute top-3 left-3 bg-sky-600 text-white text-xs px-2 py-1 rounded uppercase">
                Preorder
            </span>
        @elseif ($state === 'lifad')
            <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs px-2 py-1 rounded uppercase">
                Lifad
            </span>
        @endif
    </div>
    <div class="p-4">
        <h3 class="text-lg font-bold uppercase text-white">{{ $title }}</h3>
        <p class="text-sm text-gray-400 uppercase">{{ $subtitle }}</p>
        <div class="mt-2 text-emerald-400 font-semibold">{{ $price }} EUR</div>
    </div>
</div>