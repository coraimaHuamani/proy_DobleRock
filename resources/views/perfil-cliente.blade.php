{{-- filepath: d:\Tecnovedades\proy_DobleRock\resources\views\perfil-cliente.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#0d0d0f] py-8">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-[#181818] border border-[#232323] rounded-lg shadow-lg p-8">
                <h1 class="text-[#e7452e] text-2xl font-bold text-center mb-8 tracking-widest uppercase">Mi Perfil</h1>

                <div id="profile-error"
                    class="hidden mb-4 p-3 bg-red-900/50 border border-red-700 rounded text-red-300 text-sm"></div>
                <div id="profile-success"
                    class="hidden mb-4 p-3 bg-green-900/50 border border-green-700 rounded text-green-300 text-sm"></div>

                <form id="profileForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-gray-300 text-sm font-bold mb-2">Nombre completo</label>
                            <input id="nombre" name="nombre" type="text" required
                                class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                        </div>

                        <div>
                            <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Correo
                                electrónico</label>
                            <input id="email" name="email" type="email" required
                                class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="telefono" class="block text-gray-300 text-sm font-bold mb-2">Teléfono</label>
                        <input id="telefono" name="telefono" type="text"
                            class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">
                    </div>

                    <div class="mt-6">
                        <label for="direccion" class="block text-gray-300 text-sm font-bold mb-2">Dirección</label>
                        <textarea id="direccion" name="direccion" rows="3"
                            class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"></textarea>
                    </div>

                    <div class="mt-6">
                        <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Nueva contraseña
                            (opcional)</label>
                        <input id="password" name="password" type="password" minlength="6"
                            class="w-full px-4 py-2 rounded bg-[#232323] border border-[#222] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]"
                            placeholder="Dejar vacío para no cambiar">
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button type="submit"
                            class="flex-1 py-2 rounded bg-[#e7452e] hover:bg-[#c53a22] text-white font-bold uppercase tracking-widest transition duration-200">
                            <i class="fa-solid fa-save mr-2"></i>
                            Actualizar Perfil
                        </button>

                        <a href="/"
                            class="flex-1 py-2 rounded bg-gray-700 hover:bg-gray-600 text-white font-bold uppercase tracking-widest transition duration-200 text-center">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Volver al Inicio
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cargar datos del cliente al cargar la página
        document.addEventListener('DOMContentLoaded', async function() {
            const clienteId = localStorage.getItem('cliente_id');

            if (!clienteId) {
                window.location.href = '/login';
                return;
            }

            try {
                // Cargar datos del cliente
                const response = await fetch(`/api/clientes/${clienteId}`);

                if (!response.ok) {
                    throw new Error('Error al cargar datos del cliente');
                }

                const cliente = await response.json();

                // Llenar el formulario
                document.getElementById('nombre').value = cliente.nombre;
                document.getElementById('email').value = cliente.email;
                document.getElementById('telefono').value = cliente.telefono || '';
                document.getElementById('direccion').value = cliente.direccion || '';

            } catch (error) {
                console.error('Error:', error);
                document.getElementById('profile-error').innerHTML = 'Error al cargar los datos del perfil';
                document.getElementById('profile-error').style.display = 'block';
            }
        });

        // Actualizar perfil
        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const errorDiv = document.getElementById('profile-error');
            const successDiv = document.getElementById('profile-success');
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const clienteId = localStorage.getItem('cliente_id');

            if (!clienteId) {
                window.location.href = '/login';
                return;
            }

            // Ocultar mensajes previos
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';

            // Deshabilitar botón
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Actualizando...';

            const formData = {
                nombre: document.getElementById('nombre').value,
                email: document.getElementById('email').value,
                telefono: document.getElementById('telefono').value,
                direccion: document.getElementById('direccion').value,
            };

            // Solo incluir password si no está vacío
            const password = document.getElementById('password').value;
            if (password.trim()) {
                formData.password = password;
            }

            try {
                const response = await fetch(`/api/clientes/${clienteId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    successDiv.innerHTML = 'Perfil actualizado correctamente';
                    successDiv.style.display = 'block';

                    // Limpiar campo de contraseña
                    document.getElementById('password').value = '';

                } else {
                    let errorMessage = 'Error al actualizar el perfil';

                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    } else if (data.message) {
                        errorMessage = data.message;
                    }

                    errorDiv.innerHTML = errorMessage;
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                errorDiv.innerHTML = 'Error de conexión. Inténtalo de nuevo.';
                errorDiv.style.display = 'block';
                console.error('Error:', error);
            } finally {
                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Actualizar Perfil';
            }
        });
    </script>
@endsection
