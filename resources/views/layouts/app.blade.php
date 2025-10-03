<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Doble Rock')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/144703dbfc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100">

    <!-- NAVBAR INCLUÍDO -->
    @include('layouts.navbar')

    <!-- CONTENIDO PRINCIPAL -->
    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Iframe del reproductor global -->
    <iframe src="{{ route('player') }}" 
        class="fixed bottom-0 left-0 right-0 h-20 w-full border-0 z-50 bg-black"
        style="height:80px;"></iframe>


    <script src="{{ asset('js/music-tabs.js') }}"></script>
    <script src="{{ asset('js/album-contenido.js') }}"></script>
    <script src="{{ asset('js/playlist-contenido.js') }}"></script>

    @stack('scripts')
</body>

</html>
