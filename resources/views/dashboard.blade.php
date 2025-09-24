@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#111] text-white flex">
        <div
            class="bg-black/60 rounded-none md:rounded-2xl shadow-xl w-full border border-[#232323] flex flex-col md:flex-row overflow-hidden my-8">
            <!-- Header móvil -->
            <div class="md:hidden flex items-center justify-between px-6 py-4 border-b border-[#232323] bg-[#181818]">
                <button id="dashboard-menu-toggle" class="text-2xl text-white focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <span class="font-semibold text-[#e7452e] uppercase tracking-widest text-sm">
                    {{ session('user', 'Usuario') }}
                </span>
            </div>
            <!-- Menú lateral -->
            <aside id="dashboard-sidebar"
                class="md:w-64 bg-[#181818] border-r border-[#232323] flex flex-col py-8 px-6 gap-4 h-full
            fixed md:static top-0 left-0 z-40 md:z-auto w-64 transition-transform duration-300
            -translate-x-full md:translate-x-0">
                <div class="hidden md:block mb-8 text-[#e7452e] font-bold uppercase tracking-widest text-lg text-center">
                    {{ session('user', 'Usuario') }}
                </div>
                <button id="menu-categorias"
                    class="flex items-center gap-2 text-white hover:text-[#e7452e] transition font-semibold focus:outline-none">
                    <i class="fa-solid fa-tags"></i>
                    Categorías
                </button>
                <button id="menu-productos"
                    class="flex items-center gap-2 text-white hover:text-[#e7452e] transition font-semibold focus:outline-none">
                    <i class="fa-solid fa-box"></i>
                    Productos
                </button>
                <button id="menu-usuarios"
                    class="flex items-center gap-2 text-white hover:text-[#e7452e] transition font-semibold focus:outline-none">
                    <i class="fa-solid fa-users"></i>
                    Usuarios
                </button>
                <button id="menu-galeria"
                    class="flex items-center gap-2 text-white hover:text-[#e7452e] transition font-semibold focus:outline-none">
                    <i class="fa-solid fa-images"></i>
                    Galería
                </button>
                <button id="menu-noticias"
                    class="flex items-center gap-2 text-white hover:text-[#e7452e] transition font-semibold focus:outline-none">
                    <i class="fa-solid fa-newspaper"></i>
                    Noticias
                </button>
                <!-- Botón de logout -->
                <button id="logout-btn"
                    class="flex items-center gap-2 text-white hover:text-red-500 transition font-semibold focus:outline-none mt-8">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Cerrar sesión
                </button>
            </aside>
            <!-- Overlay para menú móvil -->
            <div id="dashboard-overlay" class="fixed inset-0 bg-black/60 z-30 hidden md:hidden"></div>
            <!-- Contenido dinámico -->
            <main class="flex-1 p-8">
                <div id="panel-categorias" class="hidden">
                    <h2 class="text-xl font-bold text-[#e7452e] mb-4">Gestión de Categorías</h2>
                    @include('categorias._agregar')
                    @include('categorias._editar')
                    <button id="btn-create-categoria" type="button"
                        class="mb-4 px-4 py-2 rounded bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                        Agregar categoría
                    </button>
                    <div id="categorias-container" class="bg-[#181818] rounded-lg border border-[#232323] p-4 overflow-x-auto">
                        @include('categorias._tabla')
                    </div>
                </div>

                <div id="panel-productos">
                    <h2 class="text-xl font-bold text-[#e7452e] mb-4">Gestión de Productos</h2>
                    <button
                        class="mb-4 px-4 py-2 rounded bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">Agregar
                        producto</button>
                    <div class="bg-[#181818] rounded-lg border border-[#232323] p-4">
                        <p class="text-gray-300">Aquí aparecerá la lista de productos y opciones para editar o eliminar.</p>
                    </div>
                </div>
                <div id="panel-usuarios" class="hidden">
                    <h2 class="text-xl font-bold text-[#e7452e] mb-4">Gestión de Usuarios</h2>
                    @include('usuarios._agregar')
                    @include('usuarios._editar')
                    <button id="btn-create-user" type="button"
                        class="mb-4 px-4 py-2 rounded bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                        Agregar usuario
                    </button>
                    <div id="users-container" class="bg-[#181818] rounded-lg border border-[#232323] p-4 overflow-x-auto">
                        @include('usuarios._tabla')
                    </div>
                </div>
                <div id="panel-galeria" class="hidden">
                    <h2 class="text-xl font-bold text-[#e7452e] mb-4">Gestión de Galería</h2>
                    @include('galeria._agregar')
                    @include('galeria._editar')
                    <button id="btn-create-galeria" type="button"
                        class="mb-4 px-4 py-2 rounded bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                        <i class="fa-solid fa-plus mr-1"></i>Agregar imagen/video
                    </button>
                    <div id="galeria-container" class="bg-[#181818] rounded-lg border border-[#232323] p-4 overflow-x-auto">
                        @include('galeria._tabla')
                    </div>
                </div>

                <div id="panel-noticias" class="hidden">
                    <h2 class="text-xl font-bold text-[#e7452e] mb-4">Gestión de Noticias</h2>
                    @include('noticias._editar')
                    @include('noticias._agregar')
                    <button id="btn-create-news" type="button"
                        class="mb-4 px-4 py-2 rounded bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                        Agregar noticia
                    </button>
                    <div id="news-container" class="bg-[#181818] rounded-lg border border-[#232323] p-4 overflow-x-auto">
                        @include('noticias._tabla')
                    </div>
                </div>
            </main>
        </div>
    </div>
    @push('scripts')
        <script type="module" src="{{ asset('js/dashboard.js') }}"></script>
        <script src="{{ asset('js/usuarios/cargarUsuario.js') }}"></script>
        <script src="{{ asset('js/galeria/cargarGaleria.js') }}"></script>
        <script src="{{ asset('js/categoria/tabla.js') }}"></script>
        <script src="{{ asset('js/categoria/editar.js') }}"></script>
        <script src="{{ asset('js/categoria/agregar.js') }}"></script>
        <script src="{{ asset('js/login/logout.js') }}"></script>
    @endpush
@endsection
