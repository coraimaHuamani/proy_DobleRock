@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#0d0d0f]">
        <div class="w-full max-w-md bg-[#181818] border border-[#232323] rounded-lg shadow-lg p-8">
            <h1 class="text-[#e7452e] text-2xl font-bold text-center mb-6 tracking-widest uppercase">Iniciar Sesión</h1>
            @if (session('error'))
                <div class="mb-4 text-red-500 text-center">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('login.custom') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm mb-2">Usuario</label>
                    <input id="email" name="email" type="text" required autofocus placeholder="Ingrese su usuario"
                        class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm mb-2">Contraseña</label>
                    <input id="password" name="password" type="password" required placeholder="Ingrese su contraseña"
                        class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                </div>
                <button type="submit"
                    class="w-full py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold uppercase tracking-widest transition">Entrar</button>
            </form>
            <div class="mt-6 flex flex-col items-center">
                <a href="/register"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#e7452e] text-[#e7452e] bg-[#181818] hover:bg-[#e7452e] hover:text-white transition font-semibold text-xs uppercase tracking-widest shadow">
                    <i class="fa-solid fa-user-plus"></i>
                    Crear nuevo usuario
                </a>
            </div>
        </div>
    </div>
@endsection
