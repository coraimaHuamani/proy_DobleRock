{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\login.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#0d0d0f]">
        <div class="w-full max-w-md bg-[#181818] border border-[#232323] rounded-lg shadow-lg p-8">
            <h1 class="text-[#e7452e] text-2xl font-bold text-center mb-6 tracking-widest uppercase">Iniciar Sesión</h1>
            
            <div id="login-error" class="hidden mb-4 p-3 bg-red-900/50 border border-red-700 rounded text-red-300 text-sm"></div>
            
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-900/50 border border-red-700 rounded text-red-300 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.custom') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm mb-2">Correo electrónico</label>
                    <input id="email" name="email" type="email" required autofocus placeholder="tu@email.com"
                        class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm mb-2">Contraseña</label>
                    <input id="password" name="password" type="password" required placeholder="Tu contraseña"
                        class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                </div>
                
                <button type="submit" id="login-btn"
                    class="w-full py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold uppercase tracking-widest transition">
                    <i class="fa-solid fa-sign-in-alt mr-2"></i>
                    Iniciar Sesión
                </button>
            </form>
            
            <div class="mt-6 flex flex-col items-center gap-3">
                <div class="text-center text-xs text-gray-400">
                    <p class="mb-2">¿No tienes cuenta?</p>
                </div>
                <a href="/register"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#e7452e] text-[#e7452e] bg-[#181818] hover:bg-[#e7452e] hover:text-white transition font-semibold text-xs uppercase tracking-widest shadow">
                    <i class="fa-solid fa-user-plus"></i>
                    Crear cuenta como cliente
                </a>
            </div>
            
            <div class="mt-4 text-center">
                <a href="/" class="text-xs text-gray-500 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i>
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>

    @if (session('cliente_login'))
        <script>
            // Auto-login para clientes después del login exitoso
            const clienteData = @json(session('cliente_login'));
            localStorage.setItem('cliente_id', clienteData.id);
            localStorage.setItem('cliente_nombre', clienteData.nombre);
            localStorage.setItem('cliente_email', clienteData.email);
        </script>
    @endif

    <script>
        // Mejorar UX del formulario
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('login-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Iniciando sesión...';
        });
    </script>
@endsection
