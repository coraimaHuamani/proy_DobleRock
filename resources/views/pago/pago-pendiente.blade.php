@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 text-center">
    <div class="mb-6">
        <span class="inline-block bg-yellow-500 text-white rounded-full p-4">
            <i class="fa-solid fa-clock text-3xl"></i>
        </span>
    </div>
    <h1 class="text-2xl font-bold mb-2 text-yellow-500">Pago pendiente</h1>
    <p class="text-gray-300 mb-6">Tu pago está siendo procesado. Te avisaremos cuando se confirme.</p>
    <a href="/" class="px-4 py-2 bg-[#e7452e] hover:bg-[#cf3d28] text-white rounded-lg">Volver al inicio</a>
</div>
@endsection