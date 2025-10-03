@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 text-center">
    <div class="mb-6">
        <span class="inline-block bg-[#e7452e] text-white rounded-full p-4">
            <i class="fa-solid fa-check text-3xl"></i>
        </span>
    </div>
    <h1 class="text-2xl font-bold mb-2 text-[#e7452e]">¡Pago realizado con éxito!</h1>
    <p class="text-gray-300 mb-6">Gracias por tu compra. Recibirás la confirmación en tu correo.</p>
    <a href="/" class="px-4 py-2 bg-[#e7452e] hover:bg-[#cf3d28] text-white rounded-lg">Volver al inicio</a>
</div>
@endsection