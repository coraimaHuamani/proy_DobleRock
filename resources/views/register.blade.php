@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#0d0d0f]">
    <div class="w-full max-w-md bg-[#181818] border border-[#232323] rounded-lg shadow-lg p-8">
        <h1 class="text-[#e7452e] text-2xl font-bold text-center mb-6 tracking-widest uppercase">Crear nuevo usuario</h1>
        <form method="POST" action="#">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-300 text-sm mb-2">Nombre</label>
                <input id="name" name="name" type="text" required autofocus class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-300 text-sm mb-2">Correo electrónico</label>
                <input id="email" name="email" type="email" required class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-300 text-sm mb-2">Contraseña</label>
                <input id="password" name="password" type="password" required class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
            </div>
            <button type="submit" class="w-full py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold uppercase tracking-widest transition">Crear cuenta</button>
        </form>
        <div class="mt-6 text-center">
            <a href="/login" class="text-xs text-gray-400 hover:text-[#e7452e]">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</div>
@endsection
