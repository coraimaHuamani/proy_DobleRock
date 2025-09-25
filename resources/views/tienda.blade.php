@extends('layouts.app')

@section('content')
    <!-- Modal de producto agregado -->
    <div id="add-modal"
        class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-[#181818] text-white px-6 py-3 rounded-lg shadow-lg border border-[#e7452e] flex items-center gap-3 opacity-0 pointer-events-none transition-all duration-300">
        <i class="fa-solid fa-circle-check text-[#e7452e] text-xl"></i>
        <span class="font-mono text-sm">¡Producto agregado al carrito!</span>
    </div>

    <!-- Banner principal con slider y título -->
    <section class="w-full bg-black py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <h2 class="text-center text-base md:text-xl tracking-widest text-white mb-6 uppercase font-normal">
                PRODUCTOS MUSICALES, MERCHANDISING Y ACCESORIOS DE ESTILO ROCK.
            </h2>
            <!-- Slider simple -->
            <div id="banner-slider" class="relative overflow-hidden rounded-lg shadow-lg">
                <div class="flex transition-transform duration-700 w-full" id="slider-track">
                    <div class="w-full flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80"
                            alt="Banner 1" class="w-full h-[320px] object-cover">
                    </div>
                    <div class="w-full flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80"
                            alt="Banner 2" class="w-full h-[320px] object-cover">
                    </div>
                </div>
                <!-- Controles -->
                <button id="slider-prev"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center z-10"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <button id="slider-next"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center z-10"><i
                        class="fa-solid fa-chevron-right"></i></button>
                <!-- Indicadores -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <span class="slider-dot w-3 h-3 rounded-full bg-white/70 cursor-pointer"></span>
                    <span class="slider-dot w-3 h-3 rounded-full bg-white/30 cursor-pointer"></span>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-wrap relative text-white min-h-screen pb-16 bg-cover bg-center"
        style="background-image: url('https://images.pexels.com/photos/15474721/pexels-photo-15474721.jpeg?_gl=1*1s948t4*_ga*MTgxOTg3ODAzNS4xNzU3NzQ0MzM3*_ga_8JE65Q40S6*czE3NTc3NDQzMzYkbzEkZzEkdDE3NTc3NDQzNzUkajIxJGwwJGgw'); background-size: cover; background-position: center;">
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/80"></div>
        <div class="relative max-w-[1200px] mx-auto px-6 py-10 text-white">
            <!-- Buscador de productos -->
            <div class="flex justify-end mb-8">
                <div
                    class="flex items-center bg-transparent border border-[#222] shadow rounded-full px-3 py-1 w-full max-w-xs">
                    <input id="search-product" type="text" placeholder="Buscar productos por nombre..."
                        class="bg-transparent text-sm focus:outline-none text-gray-300 placeholder-gray-400 w-full">
                    <button id="search-btn" class="text-white hover:text-[#e7452e]">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            <!-- PRODUCTOS AGRUPADOS POR CATEGORÍA -->
            @if (
                (isset($productosPorCategoria) && count($productosPorCategoria) > 0) ||
                    (isset($productosSinCategoria) && count($productosSinCategoria) > 0))

                <!-- Productos sin categoría -->
                @if (isset($productosSinCategoria) && count($productosSinCategoria) > 0)
                    <section class="mb-10">
                        <div class="flex items-center mb-6">
                            <span class="inline-block w-8 h-0.5 bg-white mr-3"></span>
                            <h2 class="text-base tracking-widest text-white uppercase">Productos Generales</h2>
                        </div>
                        <div class="productos-section grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($productosSinCategoria as $producto)
                                <div
                                    class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                                    <a href="{{ route('producto.show', $producto['id']) }}">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-full h-56 object-cover cursor-pointer transition hover:scale-105">
                                    </a>
                                    <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                                        <div>
                                            <a href="{{ route('producto.show', $producto['id']) }}"
                                                class="block hover:text-[#e7452e]">
                                                <h3 class="text-lg font-bold font-mono uppercase tracking-wider">
                                                    {{ $producto['nombre'] }}</h3>
                                            </a>
                                            <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">
                                                {{ $producto['descripcion'] ?: 'Producto de calidad' }}</p>
                                        </div>

                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-xs text-gray-400">Stock: {{ $producto['stock'] }}</span>
                                            </div>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="font-mono text-base text-white">S/
                                                    {{ number_format($producto['precio'], 2) }}</span>
                                                <input type="number" min="1" max="{{ $producto['stock'] }}"
                                                    value="1"
                                                    class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                                    data-id="{{ $producto['id'] }}">
                                            </div>
                                            <button
                                                class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                                data-product="{{ json_encode([
                                                    'id' => $producto['id'],
                                                    'name' => $producto['nombre'],
                                                    'price' => $producto['precio'],
                                                    'image' => $producto['imagen_url'],
                                                    'desc' => $producto['descripcion'],
                                                    'stock' => $producto['stock'],
                                                ]) }}">
                                                @if ($producto['stock'] > 0)
                                                    Agregar al carrito
                                                @else
                                                    Sin stock
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Productos agrupados por categoría -->
                @if (isset($productosPorCategoria))
                    @foreach ($productosPorCategoria as $categoriaData)
                        <section class="mb-10">
                            <div class="flex items-center mb-6">
                                <span class="inline-block w-8 h-0.5 bg-white mr-3"></span>
                                <div>
                                    <h2 class="text-base tracking-widest text-white uppercase">
                                        {{ $categoriaData['categoria_nombre'] }}</h2>
                                </div>
                            </div>
                            <div class="productos-section grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach ($categoriaData['productos'] as $producto)
                                    <div
                                        class="bg-transparent overflow-hidden shadow border border-[#222] min-h-[440px] flex flex-col">
                                        <a href="{{ route('producto.show', $producto['id']) }}">
                                            <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                                class="w-full h-56 object-cover cursor-pointer transition hover:scale-105">
                                        </a>
                                        <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                                            <div>
                                                <a href="{{ route('producto.show', $producto['id']) }}"
                                                    class="block hover:text-[#e7452e]">
                                                    <h3 class="text-lg font-bold font-mono uppercase tracking-wider">
                                                        {{ $producto['nombre'] }}</h3>
                                                </a>
                                                <p class="text-xs text-gray-300 font-mono tracking-wider uppercase">
                                                    {{ $producto['descripcion'] ?: 'Producto de calidad' }}</p>
                                            </div>

                                            <div class="mt-auto">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-xs text-gray-400">Stock:
                                                        {{ $producto['stock'] }}</span>
                                                </div>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="font-mono text-base text-white">S/
                                                        {{ number_format($producto['precio'], 2) }}</span>
                                                    <input type="number" min="1" max="{{ $producto['stock'] }}"
                                                        value="1"
                                                        class="qty-input w-16 bg-[#232323] rounded px-2 py-1 text-xs text-center font-mono ml-2"
                                                        data-id="{{ $producto['id'] }}">
                                                </div>
                                                <button
                                                    class="add-btn w-full mt-2 bg-[#181818] hover:bg-[#232323] text-white rounded-lg py-2 text-xs font-mono tracking-wider uppercase"
                                                    data-product="{{ json_encode([
                                                        'id' => $producto['id'],
                                                        'name' => $producto['nombre'],
                                                        'price' => $producto['precio'],
                                                        'image' => $producto['imagen_url'],
                                                        'desc' => $producto['descripcion'],
                                                        'stock' => $producto['stock'],
                                                    ]) }}">
                                                    @if ($producto['stock'] > 0)
                                                        Agregar al carrito
                                                    @else
                                                        Sin stock
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                @endif
            @else
                <section class="mb-10">
                    <div class="flex items-center mb-6">
                        <span class="inline-block w-8 h-0.5 bg-white mr-3"></span>
                        <h2 class="text-base tracking-widest text-white uppercase">Productos</h2>
                    </div>
                    <div class="text-center py-12">
                        <i class="fa-solid fa-box-open text-6xl text-gray-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">No hay productos disponibles</h3>
                        <p class="text-gray-400">Próximamente tendremos productos increíbles para ti.</p>
                    </div>
                </section>
            @endif
        </div>
    </section>

    <!-- Estilos existentes -->
    <link rel="stylesheet" href="{{ asset('css/tienda/tiendaMain.css') }}">

    <!-- JS mínimo filtro para el panel -->
    <script src="{{ asset('js/tienda/tiendaMain.js') }}"></script>

    <!-- JS para el modal de producto agregado -->
    <script src="{{ asset('js/tienda/modalTienda.js') }}"></script>

@endsection
