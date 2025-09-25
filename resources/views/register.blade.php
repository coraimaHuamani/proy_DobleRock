{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#0d0d0f]">
    <div class="w-full max-w-md bg-[#181818] border border-[#232323] rounded-lg shadow-lg p-8">
        <h1 class="text-[#e7452e] text-2xl font-bold text-center mb-6 tracking-widest uppercase">Crear cuenta</h1>
        
        <div id="register-error" class="hidden mb-4 p-3 bg-red-900/50 border border-red-700 rounded text-red-300 text-sm"></div>
        <div id="register-success" class="hidden mb-4 p-3 bg-green-900/50 border border-green-700 rounded text-green-300 text-sm"></div>

        <form id="registerForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nombre" class="block text-gray-300 text-sm mb-2">Nombre completo</label>
                <input id="nombre" name="nombre" type="text" required autofocus 
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                    placeholder="Tu nombre completo">
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-300 text-sm mb-2">Correo electrónico</label>
                <input id="email" name="email" type="email" required 
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                    placeholder="tu@email.com">
            </div>
            
            <div class="mb-4">
                <label for="telefono" class="block text-gray-300 text-sm mb-2">Teléfono (opcional)</label>
                <input id="telefono" name="telefono" type="text" 
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                    placeholder="+51 999 999 999">
            </div>
            
            <div class="mb-4">
                <label for="direccion" class="block text-gray-300 text-sm mb-2">Dirección (opcional)</label>
                <textarea id="direccion" name="direccion" rows="2"
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                    placeholder="Tu dirección"></textarea>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-300 text-sm mb-2">Contraseña</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                    placeholder="Mínimo 6 caracteres">
            </div>
            
            <button type="submit" class="w-full py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold uppercase tracking-widest transition duration-200">
                <i class="fa-solid fa-user-plus mr-2"></i>
                Crear cuenta
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="/login" class="text-xs text-gray-400 hover:text-[#e7452e] transition">
                ¿Ya tienes cuenta? Inicia sesión
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

<script src="{{ asset('js/registro/registro.js') }}"></script>

@endsection

<script>
    document.getElementById('registerForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        const response = await fetch('/api/register', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        const errorDiv = document.getElementById('register-error');
        const successDiv = document.getElementById('register-success');
        
        // Limpiar mensajes anteriores
        errorDiv.innerHTML = '';
        successDiv.innerHTML = '';
        errorDiv.style.display = 'none';
        successDiv.style.display = 'none';
        
        if (response.ok) {
            successDiv.innerHTML = '¡Cuenta creada exitosamente! Bienvenido a DobleRock';
            successDiv.style.display = 'block';
            
            // Guardar datos del cliente para auto-login
            localStorage.setItem('cliente_id', data.id);
            localStorage.setItem('cliente_nombre', data.nombre);
            
            // Limpiar formulario
            document.getElementById('registerForm').reset();
            
            // Redirigir al home después de 2 segundos
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
            
        } else {
            errorDiv.innerHTML = data.message || 'Error al crear la cuenta. Por favor, intenta nuevamente.';
            errorDiv.style.display = 'block';
        }
    });
</script>
